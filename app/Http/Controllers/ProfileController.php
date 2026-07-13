<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Handle semua tampilan tab (Profil, Verifikasi, Alamat, Ubah Password) di satu tempat.
     */
    public function edit(Request $request): View
    {
        // Cek nama rute aktif untuk menentukan tab mana yang dibuka
        $currentRoute = $request->route()->getName();

        $tab = 'profile'; // default

        if ($currentRoute === 'profile.identity') {
            $tab = 'identity';
        } elseif ($currentRoute === 'addresses.index') {
            $tab = 'addresses';
        } elseif ($currentRoute === 'password.edit') { // <--- TAMBAHKAN LOGIKA INI
            $tab = 'password';
        } elseif ($currentRoute === 'orders.index') {   // <--- SEKALIAN BUAT TAB PESANAN SAYA
            $tab = 'orders';
        }

        return view('customer.profile', [
            'user' => $request->user(),
            'currentTab' => $tab // Kirim data tab aktif ke blade
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
}
