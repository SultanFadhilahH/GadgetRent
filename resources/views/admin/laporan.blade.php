<x-admin-layout :title="'Laporan'" :role="'ADMIN'">

    {{-- ================= PAGE HEADING ================= --}}
    <div class="mb-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-white">Laporan</h1>
        <p class="text-sm text-slate-400 mt-1">Laporan peminjaman bulanan</p>
    </div>

    {{-- ================= CHART CARD ================= --}}
    <div class="bg-[#12151d] border border-white/5 rounded-2xl p-4 sm:p-6 mb-6">
        <div class="flex items-center justify-between mb-6 flex-wrap gap-2">
            <h2 class="font-semibold text-white text-base sm:text-lg">Laporan Peminjaman Bulanan</h2>
            <span class="text-xs text-slate-500">6 bulan terakhir</span>
        </div>

        <div class="overflow-x-auto">
            <div class="min-w-[420px] h-56 sm:h-64">
                <canvas id="laporanChart"></canvas>
            </div>
        </div>
    </div>

    {{-- ================= EXPORT CARD ================= --}}
    <div class="bg-[#12151d] border border-white/5 rounded-2xl p-4 sm:p-6">
        <h2 class="font-semibold text-white text-base sm:text-lg mb-5">Export Laporan Peminjaman</h2>

        <form method="POST" action="{{ route('admin.laporan.export-bulanan') }}" class="grid grid-cols-1 lg:grid-cols-[1fr_auto] gap-3 items-end mb-5">
            @csrf
            <div>
                <label for="bulan" class="block text-xs text-slate-400 mb-1.5">Peminjaman per Bulan</label>
                <select id="bulan" name="bulan"
                    class="w-full rounded-lg bg-[#1c202b] border border-white/10 text-slate-200 text-sm py-2.5 px-3 focus:border-amber-500 focus:ring-amber-500">
                    @foreach ($bulanOptions ?? [] as $value => $label)
                        <option value="{{ $value }}" @selected(($bulanSelected ?? null) === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-amber-500 hover:bg-amber-400 text-black font-semibold text-sm px-4 py-2.5 transition whitespace-nowrap">
                <x-admin-icon name="download" class="h-4 w-4" />
                Export Excel (Bulanan)
            </button>
        </form>

        <form method="POST" action="{{ route('admin.laporan.export-semua') }}" class="grid grid-cols-1 lg:grid-cols-[1fr_auto] gap-3 items-end">
            @csrf
            <div>
                <label class="block text-xs text-slate-400 mb-1.5">Semua Histori Peminjaman</label>
                <div class="w-full rounded-lg bg-[#1c202b] border border-white/10 text-slate-500 text-sm py-2.5 px-3">
                    Seluruh data peminjaman dari awal hingga saat ini
                </div>
            </div>
            <button type="submit"
                class="inline-flex items-center justify-center gap-2 rounded-lg border border-white/15 hover:bg-white/5 text-slate-200 font-semibold text-sm px-4 py-2.5 transition whitespace-nowrap">
                <x-admin-icon name="download" class="h-4 w-4" />
                Export Excel (Semua Histori)
            </button>
        </form>
    </div>

    {{-- ================= CHART SCRIPT ================= --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const labels = @json($chartLabels ?? ['Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul']);
            const values = @json($chartValues ?? [3, 4, 3, 5, 4, 6]);

            const ctx = document.getElementById('laporanChart');
            if (!ctx || typeof Chart === 'undefined') return;

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        data: values,
                        backgroundColor: '#f5a623',
                        borderRadius: 6,
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
                                label: (item) => `${item.parsed.y}x`
                            }
                        },
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { color: '#64748b', stepSize: 1 },
                            grid: { color: 'rgba(255,255,255,0.06)' },
                        },
                        x: {
                            ticks: { color: '#64748b' },
                            grid: { display: false },
                        },
                    },
                },
                plugins: [{
                    id: 'valueOnTop',
                    afterDatasetsDraw(chart) {
                        const { ctx } = chart;
                        chart.data.datasets.forEach((dataset, i) => {
                            const meta = chart.getDatasetMeta(i);
                            meta.data.forEach((bar, index) => {
                                const value = dataset.data[index];
                                ctx.save();
                                ctx.fillStyle = '#e2e8f0';
                                ctx.font = '600 12px Figtree, sans-serif';
                                ctx.textAlign = 'center';
                                ctx.fillText(`${value}x`, bar.x, bar.y - 8);
                                ctx.restore();
                            });
                        });
                    }
                }]
            });
        });
    </script>
</x-admin-layout>
