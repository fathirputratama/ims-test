<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Transaksi
        </h2>
    </x-slot>

    <div class="container p-4 mx-auto">
        <div class="p-6 bg-white rounded-lg shadow-md">

            <!-- Tindakan -->
            <div class="mb-8">
                <h2 class="mb-4 text-lg font-semibold text-gray-900">Tindakan</h2>
                @if ($transaction->actions->isEmpty())
                    <p class="text-gray-700">Tidak ada tindakan.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Nama</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Harga</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($transaction->actions as $action)
                                    <tr>
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
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Nama</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Jumlah</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Harga</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($transaction->medicines as $medicine)
                                    <tr>
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

            <!-- Info dan Pembayaran -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="p-4 rounded-lg">
                    <h3 class="mb-4 text-lg font-semibold text-gray-900">Informasi Transaksi</h3>
                    <div class="space-y-2 text-gray-700">
                        <p><span class="font-medium">Pasien:</span> {{ $transaction->registration->patient->name }}</p>
                        <p><span class="font-medium">Dokter:</span> {{ $transaction->doctor->name }}</p>
                        <p><span class="font-medium">Tanggal Pendaftaran:</span> {{ $transaction->registration->registration_date->format('d-m-Y') }}</p>
                        <p><span class="font-medium">Total Biaya:</span> Rp {{ number_format($transaction->total_cost, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="p-4 rounded-lg">
                    <h3 class="mb-4 text-lg font-semibold text-gray-900">Form Pembayaran</h3>
                    @if (session('error'))
                        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                            {{ session('error') }}
                        </div>
                    @endif
                    <form action="{{ route('kasir.payments.store', $transaction->id) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="amount_paid" class="block text-sm text-gray-700">Jumlah Dibayar</label>
                            <input type="number" name="amount_paid" id="amount_paid" required step="0.01"
                                   min="{{ $transaction->total_cost }}"
                                   value="{{ old('amount_paid') }}"
                                   class="w-full px-3 py-2 mt-1 border rounded-lg">
                            @error('amount_paid')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                            Simpan Pembayaran
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
