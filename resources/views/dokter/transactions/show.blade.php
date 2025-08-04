<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Transaksi
        </h2>
    </x-slot>

    <div class="container px-4 py-6 mx-auto">
        <div class="p-6 bg-white rounded-lg shadow-md">
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Transaksi</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <p><strong>Nama Pasien:</strong> {{ $transaction->registration->patient->name }}</p>
                    <p><strong>Dokter:</strong> {{ $transaction->doctor->name }}</p>
                    <p><strong>Tanggal Pendaftaran:</strong> {{ $transaction->registration->registration_date->format('d-m-Y') }}</p>
                </div>
                <div>
                    <p><strong>Total Biaya:</strong> Rp {{ number_format($transaction->total_cost, 0, ',', '.') }}</p>
                    <p><strong>Status Pembayaran:</strong> {{ $transaction->payment_status }}</p>
                    <p><strong>Catatan:</strong> {{ $transaction->notes ?? '-' }}</p>
                </div>
            </div>

            <h3 class="text-lg font-semibold text-gray-900 mb-4">Tindakan</h3>
            @if ($transaction->actions->isEmpty())
                <p class="text-gray-600 mb-4">Tidak ada tindakan.</p>
            @else
                <table class="w-full mb-6 border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border p-2 text-left">Nama Tindakan</th>
                            <th class="border p-2 text-left">Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaction->actions as $action)
                            <tr>
                                <td class="border p-2">{{ $action->name }}</td>
                                <td class="border p-2">Rp {{ number_format($action->pivot->price, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            <h3 class="text-lg font-semibold text-gray-900 mb-4">Obat</h3>
            @if ($transaction->medicines->isEmpty())
                <p class="text-gray-600 my-4">Tidak ada obat.</p>
            @else
                <table class="w-full mb-6 border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border p-2 text-left">Nama Obat</th>
                            <th class="border p-2 text-left">Jumlah</th>
                            <th class="border p-2 text-left">Harga Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaction->medicines as $medicine)
                            <tr>
                                <td class="border p-2">{{ $medicine->name }}</td>
                                <td class="border p-2">{{ $medicine->pivot->quantity }}</td>
                                <td class="border p-2">Rp {{ number_format($medicine->pivot->price, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            <a href="{{ route('dokter.transactions.index') }}"
               class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                Kembali
            </a>
        </div>
    </div>
</x-app-layout>