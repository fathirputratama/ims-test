<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Daftar Transaksi Sudah Dibayar
        </h2>
    </x-slot>

    <div class="container px-4 py-6 mx-auto">
        <div class="p-6 bg-white rounded-lg shadow-md">
            <!-- Form Filter -->
            <form method="GET" action="{{ route('kasir.payments.paid') }}" class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="start_date" class="block text-gray-700">Tanggal Mulai</label>
                    <input type="date" name="start_date" id="start_date" class="w-full p-2 mt-1 border rounded-lg"
                           value="{{ request('start_date') }}">
                </div>
                <div>
                    <label for="end_date" class="block text-gray-700">Tanggal Selesai</label>
                    <input type="date" name="end_date" id="end_date" class="w-full p-2 mt-1 border rounded-lg"
                           value="{{ request('end_date') }}">
                </div>
                <div>
                    <label for="patient_name" class="block text-gray-700">Nama Pasien</label>
                    <input type="text" name="patient_name" id="patient_name" class="w-full p-2 mt-1 border rounded-lg"
                           value="{{ request('patient_name') }}" placeholder="Cari nama pasien...">
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                        Filter
                    </button>
                    <a href="{{ route('kasir.payments.paid') }}"
                       class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                        Reset
                    </a>
                </div>
            </form>

            <!-- Pesan Sukses/Error -->
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Tabel Transaksi -->
            @if ($transactions->isEmpty())
                <p class="text-gray-600">Tidak ada transaksi yang sudah dibayar.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left text-gray-900">Pasien</th>
                                <th class="px-4 py-2 text-left text-gray-900">Dokter</th>
                                <th class="px-4 py-2 text-left text-gray-900">Tanggal</th>
                                <th class="px-4 py-2 text-left text-gray-900">Total Biaya</th>
                                <th class="px-4 py-2 text-left text-gray-900">Jumlah Dibayar</th>
                                <th class="px-4 py-2 text-left text-gray-900">Kembalian</th>
                                <th class="px-4 py-2 text-left text-gray-900">Tanggal Pembayaran</th>
                                <th class="px-4 py-2 text-left text-gray-900">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td class="px-4 py-2">{{ $transaction->registration->patient->name }}</td>
                                    <td class="px-4 py-2">{{ $transaction->doctor->name }}</td>
                                    <td class="px-4 py-2">{{ $transaction->registration->registration_date->format('d-m-Y') }}</td>
                                    <td class="px-4 py-2">Rp {{ number_format($transaction->total_cost, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2">Rp {{ number_format($transaction->payment->amount_paid, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2">Rp {{ number_format($transaction->payment->change, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2">{{ $transaction->payment->payment_date->format('d-m-Y H:i') }}</td>
                                    <td class="px-4 py-2">
                                        <a href="{{ route('kasir.payments.show', $transaction->id) }}"
                                           class="px-3 py-1 bg-gray-500 text-white rounded-lg hover:bg-gray-600">Detail</a>
                                        <a href="{{ route('kasir.payments.print', $transaction->id) }}"
                                           class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Cetak Struk</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>