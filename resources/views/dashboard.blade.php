@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">

    {{-- ── PAGE HEADER ─────────────────────────────────────────────── --}}
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-white" style="font-family:'Space Grotesk',sans-serif;">
            Dashboard
        </h1>
        <p class="text-xs text-slate-500 mt-1">
            Ringkasan operasional GadgetRent — {{ now()->locale('id')->translatedFormat('d M Y') }}
        </p>
    </div>

    {{-- ── STAT CARDS ───────────────────────────────────────────────── --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

        {{-- Total Gadget --}}
        <div class="relative overflow-hidden rounded-xl border border-white/5 bg-[#1a1d26] p-5">
            <div class="absolute left-0 top-0 bottom-0 w-[3px] bg-amber-500 rounded-l-xl"></div>
            <p class="text-[10px] font-semibold uppercase tracking-widest text-slate-500"
               style="font-family:'JetBrains Mono',monospace;">Total Gadget</p>
            <p class="mt-2 text-3xl font-bold text-white" style="font-family:'Space Grotesk',sans-serif;">
                {{ $totalGadgets }}
            </p>
            <p class="mt-1 text-xs text-slate-400">{{ $totalCategories }} kategori aktif</p>
        </div>

        {{-- Sedang Disewa --}}
        <div class="relative overflow-hidden rounded-xl border border-white/5 bg-[#1a1d26] p-5">
            <div class="absolute left-0 top-0 bottom-0 w-[3px] bg-amber-500 rounded-l-xl"></div>
            <p class="text-[10px] font-semibold uppercase tracking-widest text-slate-500"
               style="font-family:'JetBrains Mono',monospace;">Sedang Disewa</p>
            <p class="mt-2 text-3xl font-bold text-white" style="font-family:'Space Grotesk',sans-serif;">
                {{ $rentedCount }}
            </p>
            <p class="mt-1 text-xs text-slate-400">
                @if($rentedGadget)
                    {{ $rentedGadget->name }}
                @else
                    Tidak ada yang disewa
                @endif
            </p>
        </div>

        {{-- Rental Aktif --}}
        <div class="relative overflow-hidden rounded-xl border border-white/5 bg-[#1a1d26] p-5">
            <div class="absolute left-0 top-0 bottom-0 w-[3px] bg-amber-500 rounded-l-xl"></div>
            <p class="text-[10px] font-semibold uppercase tracking-widest text-slate-500"
               style="font-family:'JetBrains Mono',monospace;">Rental Aktif</p>
            <p class="mt-2 text-3xl font-bold text-white" style="font-family:'Space Grotesk',sans-serif;">
                {{ $activeRentals }}
            </p>
            <p class="mt-1 text-xs text-slate-400">
                @if($overdueRentals > 0)
                    <span class="text-red-400">{{ $overdueRentals }} berpotensi terlambat</span>
                @else
                    Semua dalam jadwal
                @endif
            </p>
        </div>

        {{-- Pendapatan Bulan Ini --}}
        <div class="relative overflow-hidden rounded-xl border border-white/5 bg-[#1a1d26] p-5">
            <div class="absolute left-0 top-0 bottom-0 w-[3px] bg-amber-500 rounded-l-xl"></div>
            <p class="text-[10px] font-semibold uppercase tracking-widest text-slate-500"
               style="font-family:'JetBrains Mono',monospace;">Pendapatan Bulan Ini</p>
            <p class="mt-2 text-3xl font-bold text-white" style="font-family:'Space Grotesk',sans-serif;">
                Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}
            </p>
            <p class="mt-1 text-xs text-slate-400">dari {{ $completedBulanIni }} transaksi selesai</p>
        </div>

    </div>

    {{-- ── GRAFIK PENJUALAN ──────────────────────────────────────────── --}}
    <div class="rounded-xl border border-white/5 bg-[#1a1d26] overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-white/5">
            <h2 class="font-semibold text-white text-sm" style="font-family:'Space Grotesk',sans-serif;">
                Grafik Penjualan
            </h2>
            <span class="text-[11px] text-slate-500" style="font-family:'JetBrains Mono',monospace;">
                6 bulan terakhir
            </span>
        </div>

        <div class="p-5">
            <div class="h-56 sm:h-64">
                <canvas id="dashboardChart"></canvas>
            </div>
        </div>
    </div>

</div>

{{-- ── CHART SCRIPT ──────────────────────────────────────────────────── --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const labels = {!! json_encode($chartLabels ?? []) !!};
    const rawValues = {!! json_encode($chartValues ?? []) !!};

    // Format nilai ke "Rp X.XXXrb" untuk display bar
    const ctx = document.getElementById('dashboardChart');
    if (!ctx || typeof Chart === 'undefined') return;

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                data: rawValues,
                backgroundColor: 'rgba(232,163,61,0.85)',
                borderRadius: 7,
                borderSkipped: false,
                maxBarThickness: 56,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: (item) => 'Rp ' + item.parsed.y.toLocaleString('id-ID')
                    },
                    backgroundColor: '#1C2025',
                    borderColor: 'rgba(241,239,234,0.08)',
                    borderWidth: 1,
                    titleColor: '#94999F',
                    bodyColor: '#F1EFEA',
                    padding: 10,
                },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#62676D',
                        font: { family: "'JetBrains Mono', monospace", size: 11 },
                        callback: (v) => v === 0 ? '0' : 'Rp ' + (v / 1000) + 'rb',
                    },
                    grid: { color: 'rgba(255,255,255,0.05)' },
                    border: { display: false },
                },
                x: {
                    ticks: {
                        color: '#62676D',
                        font: { family: "'JetBrains Mono', monospace", size: 11 },
                    },
                    grid: { display: false },
                    border: { display: false },
                },
            },
        },
        plugins: [{
            id: 'valueOnTop',
            afterDatasetsDraw(chart) {
                const { ctx: c } = chart;
                chart.data.datasets.forEach((dataset, i) => {
                    const meta = chart.getDatasetMeta(i);
                    meta.data.forEach((bar, index) => {
                        const value = dataset.data[index];
                        if (value === 0) return;
                        const label = 'Rp ' + (value / 1000).toLocaleString('id-ID') + 'rb';
                        c.save();
                        c.fillStyle = '#94999F';
                        c.font = '500 11px "JetBrains Mono", monospace';
                        c.textAlign = 'center';
                        c.fillText(label, bar.x, bar.y - 8);
                        c.restore();
                    });
                });
            }
        }]
    });
});
</script>
@endsection