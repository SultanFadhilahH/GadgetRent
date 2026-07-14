<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Gadget;
use App\Models\Rental;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // ── Stat Cards ─────────────────────────────────────────────────────────
        $totalGadgets      = Gadget::count();
        $totalCategories   = Category::count();

        // Gadget yang sedang disewa (status rented)
        $rentedGadget      = Gadget::where('status', 'rented')->first();
        $rentedCount       = Gadget::where('status', 'rented')->count();

        // Rental aktif (ongoing + overdue)
        $activeRentals     = Rental::whereIn('status', ['ongoing', 'overdue'])->count();
        $overdueRentals    = Rental::where('status', 'overdue')->count();

        // Pendapatan bulan ini (dari rental completed bulan ini)
        $pendapatanBulanIni = Rental::where('status', 'completed')
            ->whereMonth('updated_at', now()->month)
            ->whereYear('updated_at', now()->year)
            ->sum('total_price');

        $completedBulanIni  = Rental::where('status', 'completed')
            ->whereMonth('updated_at', now()->month)
            ->whereYear('updated_at', now()->year)
            ->count();

        // ── Grafik Penjualan 6 Bulan Terakhir ──────────────────────────────────
        $chartData = collect(range(5, 0))->map(function ($i) {
            $date = now()->subMonths($i);
            $total = Rental::where('status', 'completed')
                ->whereMonth('updated_at', $date->month)
                ->whereYear('updated_at', $date->year)
                ->sum('total_price');

            return [
                'label' => $date->locale('id')->translatedFormat('M'),
                'total' => $total,
            ];
        });

        $chartLabels = $chartData->pluck('label');
        $chartValues = $chartData->pluck('total');

        return view('dashboard', compact(
            'totalGadgets',
            'totalCategories',
            'rentedGadget',
            'rentedCount',
            'activeRentals',
            'overdueRentals',
            'pendapatanBulanIni',
            'completedBulanIni',
            'chartLabels',
            'chartValues',
        ));
    }
}
