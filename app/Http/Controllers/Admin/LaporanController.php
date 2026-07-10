<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Tampilkan halaman Laporan (peminjaman bulanan).
     */
    public function index(Request $request)
    {
        // TODO: ganti dengan query asli ke tabel peminjaman/rental, contoh:
        // $data = Rental::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
        //     ->whereBetween('created_at', [now()->subMonths(5)->startOfMonth(), now()->endOfMonth()])
        //     ->groupBy('bulan')->pluck('total', 'bulan');

        $bulanan = collect(range(5, 0))->map(function ($i) {
            $date = now()->subMonths($i);
            return [
                'label' => ucfirst($date->translatedFormat('M')),
                // Dummy sementara — ganti dengan hasil query di atas.
                'total' => [3, 4, 3, 5, 4, 6][5 - $i] ?? 0,
            ];
        });

        $bulanOptions = collect(range(0, 11))->mapWithKeys(function ($i) {
            $date = now()->startOfMonth()->subMonths($i);
            return [$date->format('Y-m') => $date->translatedFormat('F Y')];
        });

        return view('admin.laporan', [
            'chartLabels'    => $bulanan->pluck('label'),
            'chartValues'    => $bulanan->pluck('total'),
            'bulanOptions'   => $bulanOptions,
            'bulanSelected'  => now()->format('Y-m'),
        ]);
    }

    /**
     * Export laporan peminjaman untuk satu bulan terpilih.
     */
    public function exportBulanan(Request $request)
    {
        $request->validate([
            'bulan' => ['required', 'date_format:Y-m'],
        ]);

        // TODO: bangkitkan file Excel, contoh dengan maatwebsite/excel:
        // return Excel::download(new PeminjamanBulananExport($request->bulan), "laporan-{$request->bulan}.xlsx");

        return back()->with('status', 'Export laporan bulanan sedang diproses.');
    }

    /**
     * Export seluruh histori peminjaman dari awal hingga saat ini.
     */
    public function exportSemua(Request $request)
    {
        // TODO: bangkitkan file Excel untuk seluruh histori, contoh:
        // return Excel::download(new PeminjamanSemuaExport(), 'laporan-semua-histori.xlsx');

        return back()->with('status', 'Export seluruh histori peminjaman sedang diproses.');
    }
}