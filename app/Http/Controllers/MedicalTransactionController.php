<?php
namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Medicine;
use App\Models\MedicalTransaction;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MedicalTransactionController extends Controller
{
    public function index()
    {
        $transactions = MedicalTransaction::with(['registration.patient', 'doctor'])->get();
        return view('dokter.transactions.index', compact('transactions'));
    }

    public function create()
    {
        $registrations = Registration::with('patient')
            ->where('status', 'pending')
            ->where('user_id', auth()->user()->id)
            ->get();
        $actions = Action::all();
        $medicines = Medicine::where('stock', '>', 0)->get();
        return view('dokter.transactions.create', compact('registrations', 'actions', 'medicines'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'registration_id' => 'required|exists:registrations,id',
            'notes' => 'nullable|string',
            'actions' => 'nullable|array',
            'actions.*.action_id' => 'nullable|exists:actions,id',
            'medicines' => 'nullable|array',
            'medicines.*.medicine_id' => 'nullable|exists:medicines,id',
            'medicines.*.quantity' => 'nullable|integer|min:1',
        ], [
            'registration_id.required' => 'Pendaftaran wajib dipilih.',
            'actions.*.action_id.exists' => 'Tindakan tidak valid.',
            'medicines.*.medicine_id.exists' => 'Obat tidak valid.',
            'medicines.*.quantity.integer' => 'Jumlah obat harus berupa angka.',
            'medicines.*.quantity.min' => 'Jumlah obat minimal 1.',
        ]);

        DB::beginTransaction();
        try {
            $doctorId = auth()->user()->id;
            $registration = Registration::findOrFail($request->registration_id);
            if ($registration->user_id !== $doctorId) {
                throw new \Exception('Anda tidak berwenang untuk transaksi ini.');
            }

            $totalPrice = 0;

            $transaction = MedicalTransaction::create([
                'registration_id' => $request->registration_id,
                'user_id' => $doctorId,
                'total_cost' => 0,
                'notes' => $request->notes,
                'payment_status' => 'unpaid',
            ]);

            if ($request->filled('actions')) {
                foreach ($request->actions as $actionData) {
                    if (!empty($actionData['action_id'])) {
                        $action = Action::findOrFail($actionData['action_id']);
                        $transaction->actions()->attach($action->id, [
                            'price' => $action->price,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                        $totalPrice += $action->price;
                    }
                }
            }

            if ($request->filled('medicines')) {
                foreach ($request->medicines as $medicineData) {
                    if (!empty($medicineData['medicine_id']) && !empty($medicineData['quantity'])) {
                        $medicine = Medicine::findOrFail($medicineData['medicine_id']);
                        if ($medicine->stock < $medicineData['quantity']) {
                            throw new \Exception("Stok obat {$medicine->name} tidak cukup.");
                        }
                        $transaction->medicines()->attach($medicine->id, [
                            'quantity' => $medicineData['quantity'],
                            'price' => $medicine->price * $medicineData['quantity'],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                        $totalPrice += $medicine->price * $medicineData['quantity'];
                        $medicine->decrement('stock', $medicineData['quantity']);
                    }
                }
            }

            if ($totalPrice === 0) {
                throw new \Exception('Transaksi harus memiliki setidaknya satu tindakan atau obat.');
            }

            $transaction->update(['total_cost' => $totalPrice]);

            $registration->update(['status' => 'completed']);

            DB::commit();
            return redirect()->route('dokter.transactions.index')->with('success', 'Transaksi berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage())->withInput();
        }
    }

    public function show(MedicalTransaction $transaction)
    {
        $transaction->load(['registration.patient', 'doctor', 'actions', 'medicines']);
        return view('dokter.transactions.show', compact('transaction'));
    }
}