<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Kunjungan Pasien') }}
        </h2>
    </x-slot>

    <div class="container px-4 py-6 mx-auto">
        <div class="p-6 bg-white rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                Laporan Kunjungan Pasien
            </h3>

            <!-- Filter Periode -->
            <div class="mb-6">
                <form method="GET" action="{{ route('petugas.reports.index') }}">
                    <label for="period" class="mr-2">Pilih Periode:</label>
                    <select name="period" id="period" onchange="this.form.submit()"
                            class="border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="daily" {{ $period === 'daily' ? 'selected' : '' }}>Harian</option>
                        <option value="monthly" {{ $period === 'monthly' ? 'selected' : '' }}>Bulanan</option>
                    </select>
                </form>
            </div>

            <!-- Grafik -->
            <div class="mb-6">
                @if (count($labels) > 0)
                    <div class="chart-container" style="position: relative; width: 100%; height: 400px;">
                        <canvas id="visitsChart"></canvas>
                    </div>
                @else
                    <p class="text-gray-600">Tidak ada data kunjungan untuk periode ini.</p>
                @endif
            </div>

            <!-- Tabel Data -->
            @if (count($labels) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border">{{ $period === 'daily' ? 'Tanggal' : 'Bulan' }}</th>
                                <th class="px-4 py-2 border">Jumlah Kunjungan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($labels as $index => $label)
                                <tr>
                                    <td class="px-4 py-2 border">{{ $label }}</td>
                                    <td class="px-4 py-2 border">{{ $data[$index] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-600">Tidak ada data untuk ditampilkan.</p>
            @endif
        </div>
    </div>

    <!-- Chart.js -->
    @if (count($labels) > 0)
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
        <script>
            window.chartData = {
                labels: @json($labels),
                data: @json($data),
                period: @json($period)
            };
        </script>
        <script src="{{ asset('js/reports.js') }}"></script>
    @endif
</x-app-layout>