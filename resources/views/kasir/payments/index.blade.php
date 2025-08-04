<x-app-layout>
       <x-slot name="header">
           <h2 class="font-semibold text-xl text-gray-800 leading-tight">
               Daftar Transaksi untuk Pembayaran
           </h2>
       </x-slot>

       <div class="container px-4 py-6 mx-auto">
           <div class="p-6 bg-white rounded-lg shadow-md">
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
               @if ($transactions->isEmpty())
                   <p class="text-gray-600">Tidak ada transaksi yang belum dibayar.</p>
               @else
                   <div class="overflow-x-auto">
                       <table class="min-w-full bg-white">
                           <thead>
                               <tr>
                                   <th class="px-4 py-2 text-left text-gray-900">Pasien</th>
                                   <th class="px-4 py-2 text-left text-gray-900">Dokter</th>
                                   <th class="px-4 py-2 text-left text-gray-900">Total Biaya</th>
                                   <th class="px-4 py-2 text-left text-gray-900">Aksi</th>
                               </tr>
                           </thead>
                           <tbody>
                               @foreach ($transactions as $transaction)
                                   <tr>
                                       <td class="px-4 py-2">{{ $transaction->registration->patient->name }}</td>
                                       <td class="px-4 py-2">{{ $transaction->doctor->name }}</td>
                                       <td class="px-4 py-2">Rp {{ number_format($transaction->total_cost, 0, ',', '.') }}</td>
                                       <td class="px-4 py-2">
                                           <a href="{{ route('kasir.payments.create', $transaction->id) }}"
                                              class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Bayar</a>
                                           <a href="{{ route('kasir.payments.show', $transaction->id) }}"
                                              class="px-3 py-1 bg-gray-500 text-white rounded-lg hover:bg-gray-600">Detail</a>
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