<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 14px;
        }
        .struk-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
        }
        .struk-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .struk-header h1 {
            font-size: 18px;
            margin: 0;
        }
        .struk-header p {
            margin: 5px 0;
            font-size: 12px;
        }
        .struk-details, .struk-items {
            margin-bottom: 20px;
        }
        .struk-details p, .struk-items p {
            margin: 5px 0;
        }
        .struk-items table {
            width: 100%;
            border-collapse: collapse;
        }
        .struk-items table th, .struk-items table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        .struk-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="struk-container">
        <div class="struk-header">
            <h1>Klinik Sehat</h1>
            <p>Jl. Raya Puncak No.999, Kabupaten Bogor, Jawa Barat</p>
            <p>Telp: 081234567890</p>
            <p>Struk Pembayaran</p>
        </div>

        <div class="struk-details">
            <p><strong>Pasien:</strong> {{ $transaction->registration->patient->name }}</p>
            <p><strong>Dokter:</strong> {{ $transaction->doctor->name }}</p>
            <p><strong>Tanggal Pendaftaran:</strong> {{ $transaction->registration->registration_date->format('d-m-Y') }}</p>
            <p><strong>Tanggal Pembayaran:</strong> {{ $transaction->payment->payment_date ? $transaction->payment->payment_date->format('d-m-Y') : '-' }}</p>
        </div>

        <div class="struk-items">
            <h3>Tindakan</h3>
            @if ($transaction->actions->isEmpty())
                <p>Tidak ada tindakan.</p>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>Tindakan</th>
                            <th>Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaction->actions as $action)
                            <tr>
                                <td>{{ $action->name }}</td>
                                <td>Rp {{ number_format($action->pivot->price, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            <h3>Obat</h3>
            @if ($transaction->medicines->isEmpty())
                <p>Tidak ada obat.</p>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>Obat</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaction->medicines as $medicine)
                            <tr>
                                <td>{{ $medicine->name }}</td>
                                <td>{{ $medicine->pivot->quantity }}</td>
                                <td>Rp {{ number_format($medicine->pivot->price, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <div class="struk-details">
            <p><strong>Total Biaya:</strong> Rp {{ number_format($transaction->total_cost, 0, ',', '.') }}</p>
            <p><strong>Jumlah Dibayar:</strong> Rp {{ number_format($transaction->payment->amount_paid ?? 0, 0, ',', '.') }}</p>
            <p><strong>Kembalian:</strong> Rp {{ number_format($transaction->payment->change ?? 0, 0, ',', '.') }}</p>
        </div>

        <div class="struk-footer">
            <p>Terima kasih atas kunjungan Anda!</p>
            <p>Dicetak pada: {{ now()->format('d-m-Y H:i') }}</p>
        </div>

        <div class="no-print mt-6 text-center">
            <button onclick="window.print()" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                Cetak Struk
            </button>
            <a href="{{ route('kasir.payments.show', $transaction->id) }}"
               class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                Kembali
            </a>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>