<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Transaksi') }}
        </h2>
    </x-slot>

    <div class="container p-4 mx-auto">
        <div class="p-6 bg-white rounded-lg shadow-md">

            <!-- Tombol Aksi -->
            <div class="flex items-center justify-between mb-6">
                <a href="{{ route('kasir.payments.index') }}" class="px-4 py-2 text-white bg-gray-600 rounded-lg hover:bg-gray-700">
                    Kembali
                </a>
                @if ($transaction->payment_status === 'paid')
                    <a href="{{ route('kasir.payments.print', $transaction->id) }}" class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                        Cetak Struk
                    </a>
                @endif
            </div>

            <!-- Grid Info -->
            <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-2">
                <!-- Informasi Transaksi -->
                <div class="p-4 rounded-lg">
                    <h2 class="mb-4 text-lg font-semibold text-gray-900">Informasi Transaksi</h2>
                    <div class="space-y-2 text-gray-700">
                        <p><span class="font-medium">Pasien:</span> {{ $transaction->registration->patient->name }}</p>
                        <p><span class="font-medium">Dokter:</span> {{ $transaction->doctor->name }}</p>
                        <p><span class="font-medium">Tanggal Pendaftaran:</span> {{ $transaction->registration->registration_date->format('d-m-Y') }}</p>
                        <p><span class="font-medium">Total Biaya:</span> Rp {{ number_format($transaction->total_cost, 0, ',', '.') }}</p>
                        <p><span class="font-medium">Status Pembayaran:</span> {{ $transaction->payment_status === 'paid' ? 'Sudah Dibayar' : 'Belum Dibayar' }}</p>
                    </div>
                </div>

                <!-- Detail Pembayaran -->
                @if ($transaction->payment)
                    <div class="p-4 rounded-lg">
                        <h2 class="mb-4 text-lg font-semibold text-gray-900">Detail Pembayaran</h2>
                        <div class="space-y-2 text-gray-700">
                            <p><span class="font-medium">Jumlah Dibayar:</span> Rp {{ number_format($transaction->payment->amount_paid, 0, ',', '.') }}</p>
                            <p><span class="font-medium">Kembalian:</span> Rp {{ number_format($transaction->payment->change, 0, ',', '.') }}</p>
                            <p><span class="font-medium">Tanggal Pembayaran:</span> {{ $transaction->payment->payment_date->format('d-m-Y H:i') }}</p>
                            <p><span class="font-medium">Status:</span> {{ $transaction->payment->status === 'paid' ? 'Lunas' : 'Pending' }}</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Tindakan -->
            <div class="mb-8">
                <h2 class="mb-4 text-lg font-semibold text-gray-900">Tindakan</h2>
                @if ($transaction->actions->isEmpty())
                    <p class="text-gray-700">Tidak ada tindakan.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white ">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tindakan</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($transaction->actions as $action)
                                    <tr class="transition duration-200">
                                        <td class="px-4 py-2 text-gray-900">{{ $action->name }}</td>
                                        <td class="px-4 py-2 text-gray-900">Rp {{ number_format($action->pivot->price, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <!-- Obat -->
            <div class="mb-8">
                <h2 class="mb-4 text-lg font-semibold text-gray-900">Obat</h2>
                @if ($transaction->medicines->isEmpty())
                    <p class="text-gray-700">Tidak ada obat.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white ">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Obat</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($transaction->medicines as $medicine)
                                    <tr class="transition duration-200">
                                        <td class="px-4 py-2 text-gray-900">{{ $medicine->name }}</td>
                                        <td class="px-4 py-2 text-gray-900">{{ $medicine->pivot->quantity }}</td>
                                        <td class="px-4 py-2 text-gray-900">Rp {{ number_format($medicine->pivot->price, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
