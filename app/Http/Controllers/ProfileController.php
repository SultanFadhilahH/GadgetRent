<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Handle semua tampilan tab (Profil, Verifikasi, Alamat, Ubah Password) di satu tempat.
     */
    public function edit(Request $request): View
    {
        $currentRoute = $request->route()->getName();

        $tab = 'profile';

        if ($currentRoute === 'profile.identity') {
            $tab = 'identity';
        } elseif ($currentRoute === 'addresses.index') {
            $tab = 'addresses';
        } elseif ($currentRoute === 'password.edit') {
            $tab = 'password';
        } elseif ($currentRoute === 'orders.index') {
            $tab = 'orders';
        }

        return view('customer.profile', [
            'user'       => $request->user(),
            'currentTab' => $tab,
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function saveAddress(Request $request): RedirectResponse
    {
        $request->validate([
            'province'       => 'required|string|max:100',
            'city'           => 'required|string|max:100',
            'district'       => 'nullable|string|max:100',
            'postal_code'    => 'nullable|string|max:10',
            'address_detail' => 'required|string|max:500',
        ]);

        $request->user()->update([
            'province'       => $request->province,
            'city'           => $request->city,
            'district'       => $request->district,
            'postal_code'    => $request->postal_code,
            'address_detail' => $request->address_detail,
        ]);

        return Redirect::route('addresses.index')->with('status', 'address-saved');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Verifikasi KTP menggunakan OCR.Space API (gratis, tanpa perlu kartu kredit).
     * Daftar API key gratis di: https://ocr.space/ocrapi/freekey
     */
    public function verifyKtp(Request $request)
    {
        $request->validate([
            'ktp_image' => 'required|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $path     = $request->file('ktp_image')->store('ktp', 'public');
        $fullPath = storage_path('app/public/' . $path);

        try {
            // "helloworld" adalah demo key publik resmi OCR.Space (dibagi bersama semua
            // pengguna, jadi bisa kena rate-limit). Daftar key gratis milik sendiri di
            // https://ocr.space/ocrapi/freekey lalu isi OCR_SPACE_API_KEY di .env.
            $apiKey = env('OCR_SPACE_API_KEY') ?: 'helloworld';

            // Kirim gambar ke OCR.Space API
            $response = Http::timeout(60)
                ->attach('file', file_get_contents($fullPath), basename($fullPath))
                ->post('https://api.ocr.space/parse/image', [
                    'apikey'            => $apiKey,
                    'language'          => 'eng',
                    'isOverlayRequired' => 'false',
                    'detectOrientation' => 'true',
                    'scale'             => 'true',
                    'OCREngine'         => '2',
                ]);

            $result = $response->json();

            // Cek apakah ada error dari API
            if (!$response->ok() || ($result['IsErroredOnProcessing'] ?? true)) {
                $msg = $result['ErrorMessage'][0] ?? ($result['ErrorDetails'] ?? 'OCR gagal memproses gambar.');
                return response()->json(['success' => false, 'message' => 'OCR Error: ' . $msg]);
            }

            // Ambil teks hasil OCR
            $parsedResults = $result['ParsedResults'] ?? [];
            if (empty($parsedResults)) {
                return response()->json(['success' => false, 'message' => 'Tidak ada teks yang terdeteksi pada gambar.']);
            }

            $fullText = $parsedResults[0]['ParsedText'] ?? '';
            if (empty(trim($fullText))) {
                return response()->json(['success' => false, 'message' => 'Teks KTP tidak dapat terbaca. Pastikan foto jelas dan tidak buram.']);
            }

            // --- PARSING DATA KTP ---
            $lines         = explode("\n", $fullText);
            $nik           = null;
            $nama          = null;
            $gender        = null;
            $alamat        = null;   // Alamat/jalan detail
            $rtRw          = null;   // RT/RW
            $kelurahan     = null;   // Kel/Desa
            $kecamatan     = null;   // Kecamatan
            $kotaKab       = null;   // Kabupaten/Kota
            $provinsi      = null;   // Provinsi

            foreach ($lines as $i => $line) {
                $lineTrim = trim($line);

                // --- NIK: 16 digit angka ---
                if (!$nik && preg_match('/\b(\d{16})\b/', $lineTrim, $matches)) {
                    $nik = $matches[1];
                }

                // --- Nama ---
                if (!$nama && preg_match('/^nama\s*[:\-]?\s*(.+)/i', $lineTrim, $m)) {
                    $candidate = trim(preg_replace('/[^a-zA-Z\s]/', '', $m[1]));
                    if (strlen($candidate) > 2) {
                        $nama = $candidate;
                    } elseif (isset($lines[$i + 1])) {
                        $candidate2 = trim(preg_replace('/[^a-zA-Z\s]/', '', $lines[$i + 1]));
                        if (strlen($candidate2) > 2) {
                            $nama = $candidate2;
                        }
                    }
                }

                // --- Jenis Kelamin ---
                if (!$gender) {
                    $upper = strtoupper($lineTrim);
                    if (stripos($lineTrim, 'Kelamin') !== false || stripos($lineTrim, 'Jenis') !== false) {
                        if (str_contains($upper, 'LAKI-LAKI') || str_contains($upper, 'LAKI LAKI')) {
                            $gender = 'Laki-laki';
                        } elseif (str_contains($upper, 'PEREMPUAN')) {
                            $gender = 'Perempuan';
                        } elseif (str_contains($upper, 'MALE') && !str_contains($upper, 'FEMALE')) {
                            $gender = 'Laki-laki';
                        } elseif (str_contains($upper, 'FEMALE')) {
                            $gender = 'Perempuan';
                        } elseif (isset($lines[$i + 1])) {
                            // Cek di baris berikutnya
                            $nextUpper = strtoupper(trim($lines[$i + 1]));
                            if (str_contains($nextUpper, 'LAKI')) {
                                $gender = 'Laki-laki';
                            } elseif (str_contains($nextUpper, 'PEREMPUAN') || str_contains($nextUpper, 'FEMALE')) {
                                $gender = 'Perempuan';
                            } elseif (str_contains($nextUpper, 'MALE')) {
                                $gender = 'Laki-laki';
                            }
                        }
                    }
                }

                // --- Alamat (Jalan + nomor rumah) ---
                if (!$alamat && preg_match('/^alamat\s*[:\-]?\s*(.+)/i', $lineTrim, $m)) {
                    $candidate = trim($m[1]);
                    if (strlen($candidate) > 3) {
                        $alamat = $candidate;
                    } elseif (isset($lines[$i + 1])) {
                        $next = trim($lines[$i + 1]);
                        if (strlen($next) > 3 && !preg_match('/^(RT|RW|Kel|Desa|Kec|Kab|Kota|Prov|Agama|Gol|NIK|Nama|Tempat|Tgl|Masa)/i', $next)) {
                            $alamat = $next;
                        }
                    }
                }

                // --- RT/RW (format: RT/RW : 005/003 atau RT 005 RW 003) ---
                if (!$rtRw && preg_match('/RT\s*[\/\-]?\s*RW\s*[:\-]?\s*(\d{1,3}[\s\/\-]+\d{1,3})/i', $lineTrim, $m)) {
                    $rtRw = trim(preg_replace('/\s+/', ' ', $m[1]));
                }
                if (!$rtRw && preg_match('/\bRT\s*[\/\.]\s*(\d+)\s*[\/\.]\s*(\d+)/i', $lineTrim, $m)) {
                    $rtRw = $m[1] . '/' . $m[2];
                }

                // --- Kelurahan / Desa ---
                if (!$kelurahan && preg_match('/^(?:kel(?:urahan)?|desa)\s*[:\-]?\s*(.+)/i', $lineTrim, $m)) {
                    $candidate = trim(preg_replace('/[^a-zA-Z\s]/', '', $m[1]));
                    if (strlen($candidate) > 2) $kelurahan = $candidate;
                }

                // --- Kecamatan ---
                if (!$kecamatan && preg_match('/^kec(?:amatan)?\s*[:\-]?\s*(.+)/i', $lineTrim, $m)) {
                    $candidate = trim(preg_replace('/[^a-zA-Z\s]/', '', $m[1]));
                    if (strlen($candidate) > 2) $kecamatan = $candidate;
                }

                // --- Kabupaten / Kota ---
                if (!$kotaKab && preg_match('/^(?:kab(?:upaten)?|kota)\s*[:\-]?\s*(.+)/i', $lineTrim, $m)) {
                    $candidate = trim(preg_replace('/[^a-zA-Z\s]/', '', $m[1]));
                    if (strlen($candidate) > 2) $kotaKab = $candidate;
                }

                // --- Provinsi ---
                if (!$provinsi && preg_match('/^(?:provinsi|propinsi|province)\s*[:\-]?\s*(.+)/i', $lineTrim, $m)) {
                    $candidate = trim(preg_replace('/[^a-zA-Z\s]/', '', $m[1]));
                    if (strlen($candidate) > 2) $provinsi = $candidate;
                }
                if (!$provinsi && preg_match('/provinsi\s+([A-Z\s]+)/i', $lineTrim, $m)) {
                    $candidate = trim(preg_replace('/[^a-zA-Z\s]/', '', $m[1]));
                    if (strlen($candidate) > 2) $provinsi = $candidate;
                }
            }

            // --- Susun address_detail: Jalan + RT/RW + Kel + Kec ---
            $addressParts = [];
            if ($alamat)    $addressParts[] = $alamat;
            if ($rtRw)      $addressParts[] = 'RT/RW ' . $rtRw;
            if ($kelurahan) $addressParts[] = 'Kel. ' . ucwords(strtolower($kelurahan));
            if ($kecamatan) $addressParts[] = 'Kec. ' . ucwords(strtolower($kecamatan));
            $addressDetail = implode(', ', $addressParts);

            // --- Simpan ke profil user ---
            $user = $request->user();
            if ($nik)          $user->nik            = $nik;
            if ($nama)         $user->name           = ucwords(strtolower($nama));
            if ($gender)       $user->gender         = $gender;
            if ($provinsi)     $user->province       = ucwords(strtolower($provinsi));
            if ($kotaKab)      $user->city           = ucwords(strtolower($kotaKab));
            if ($kecamatan)    $user->district       = ucwords(strtolower($kecamatan));
            if ($addressDetail) $user->address_detail = $addressDetail;

            $user->ktp_image_path  = $path;
            $user->ktp_verified_at = now();
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'KTP berhasil diverifikasi',
                'data'    => [
                    'nik'            => $user->nik,
                    'name'           => $user->name,
                    'gender'         => $user->gender,
                    'province'       => $user->province,
                    'city'           => $user->city,
                    'district'       => $user->district,
                    'address_detail' => $user->address_detail,
                    'ktp_image_path' => $user->ktp_image_path,
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }
}

