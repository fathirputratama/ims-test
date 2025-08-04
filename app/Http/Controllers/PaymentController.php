<?php
namespace App\Http\Controllers;

use App\Models\MedicalTransaction;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index()
    {
        $transactions = MedicalTransaction::with(['registration.patient', 'doctor', 'payment'])
            ->where('payment_status', 'unpaid')
            ->get();
        return view('kasir.payments.index', compact('transactions'));
    }

    public function paid(Request $request)
    {
        $query = MedicalTransaction::with(['registration.patient', 'doctor', 'payment'])
            ->where('payment_status', 'paid');

        // Filter berdasarkan rentang tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereHas('payment', function ($q) use ($request) {
                $q->whereBetween('payment_date', [
                    $request->start_date . ' 00:00:00',
                    $request->end_date . ' 23:59:59'
                ]);
            });
        }

        // Pencarian berdasarkan nama pasien
        if ($request->filled('patient_name')) {
            $query->whereHas('registration.patient', function ($q) use ($request) {
                $q->where('name', 'ilike', '%' . $request->patient_name . '%');
            });
        }

        $transactions = $query->get();

        return view('kasir.payments.paid', compact('transactions'));
    }

    public function create($transactionId)
    {
        $transaction = MedicalTransaction::with(['registration.patient', 'doctor', 'actions', 'medicines'])
            ->findOrFail($transactionId);
        if ($transaction->payment_status !== 'unpaid') {
            return redirect()->route('kasir.payments.index')->with('error', 'Transaksi ini sudah dibayar.');
        }
        return view('kasir.payments.create', compact('transaction'));
    }

    public function store(Request $request, $transactionId)
    {
        $request->validate([
            'amount_paid' => 'required|numeric|min:' . MedicalTransaction::findOrFail($transactionId)->total_cost,
        ], [
            'amount_paid.required' => 'Jumlah pembayaran wajib diisi.',
            'amount_paid.min' => 'Jumlah pembayaran harus cukup untuk menutupi total biaya.',
        ]);

        DB::beginTransaction();
        try {
            $transaction = MedicalTransaction::findOrFail($transactionId);
            if ($transaction->payment_status !== 'unpaid') {
                throw new \Exception('Transaksi ini sudah dibayar.');
            }

            $amountPaid = $request->amount_paid;
            $totalCost = $transaction->total_cost;
            $change = $amountPaid - $totalCost;

            Payment::create([
                'medical_transaction_id' => $transaction->id,
                'amount_paid' => $amountPaid,
                'change' => $change >= 0 ? $change : 0,
                'payment_date' => now(),
                'status' => 'paid',
            ]);

            $transaction->update(['payment_status' => 'paid']);

            DB::commit();
            return redirect()->route('kasir.payments.index')->with('success', 'Pembayaran berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan pembayaran: ' . $e->getMessage())->withInput();
        }
    }

    public function show($transactionId)
    {
        $transaction = MedicalTransaction::with(['registration.patient', 'doctor', 'actions', 'medicines', 'payment'])
            ->findOrFail($transactionId);
        return view('kasir.payments.show', compact('transaction'));
    }

    public function print($transactionId)
    {
        $transaction = MedicalTransaction::with(['registration.patient', 'doctor', 'actions', 'medicines', 'payment'])
            ->findOrFail($transactionId);
        return view('kasir.payments.print', compact('transaction'));
    }
}