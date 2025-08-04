<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use App\Models\Registration;
use App\Models\Province;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{
    public function index()
    {
        $registrations = Registration::with(['patient', 'doctor'])->get();
        return view('petugas.registrations.index', compact('registrations'));
    }

    public function create()
    {
        $patients = Patient::all();
        $doctors = User::where('role', 'dokter')->get();
        $provinces = Province::all();
        $cities = City::all();
        return view('petugas.registrations.create', compact('patients', 'doctors', 'provinces', 'cities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:L,P',
            'phone' => 'nullable|string|max:15',
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:cities,id',
            'address_detail' => 'nullable|string',
            'user_id' => 'required|exists:users,id,role,dokter',
            'registration_date' => 'required|date',
        ]);

        DB::beginTransaction();
        try {
            $province = Province::findOrFail($request->province_id);
            $city = City::findOrFail($request->city_id);
            $address = trim(implode(', ', array_filter([
                $request->address_detail,
                $city->name,
                $province->name,
            ])));

            $patient = Patient::firstOrCreate(
                ['name' => $request->name, 'birth_date' => $request->birth_date],
                [
                    'gender' => $request->gender,
                    'phone' => $request->phone,
                    'address' => $address,
                ]
            );

            Registration::create([
                'patient_id' => $patient->id,
                'user_id' => $request->user_id,
                'registration_date' => $request->registration_date,
                'status' => 'pending',
            ]);

            DB::commit();
            return redirect()->route('petugas.registrations.index')->with('success', 'Pendaftaran berhasil.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal mendaftarkan pasien: ' . $e->getMessage());
        }
    }

    public function edit(Registration $registration)
    {
        if ($registration->status === 'completed') {
            return redirect()->route('petugas.registrations.index')->with('error', 'Pendaftaran yang sudah selesai tidak dapat diedit.');
        }

        $patients = Patient::all();
        $doctors = User::where('role', 'dokter')->get();
        $provinces = Province::all();
        $cities = City::all();
        return view('petugas.registrations.edit', compact('registration', 'patients', 'doctors', 'provinces', 'cities'));
    }

    public function update(Request $request, Registration $registration)
    {
        if ($registration->status === 'completed') {
            return redirect()->route('petugas.registrations.index')->with('error', 'Pendaftaran yang sudah selesai tidak dapat diedit.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:L,P',
            'phone' => 'nullable|string|max:15',
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:cities,id',
            'address_detail' => 'nullable|string',
            'user_id' => 'required|exists:users,id,role,dokter',
            'registration_date' => 'required|date',
            'status' => 'required|in:pending,canceled',
        ], [
            'status.in' => 'Status hanya boleh pending atau canceled.',
        ]);

        DB::beginTransaction();
        try {
            $province = Province::findOrFail($request->province_id);
            $city = City::findOrFail($request->city_id);
            $address = trim(implode(', ', array_filter([
                $request->address_detail,
                $city->name,
                $province->name,
            ])));

            $registration->patient->update([
                'name' => $request->name,
                'birth_date' => $request->birth_date,
                'gender' => $request->gender,
                'phone' => $request->phone,
                'address' => $address,
            ]);

            $registration->update([
                'user_id' => $request->user_id,
                'registration_date' => $request->registration_date,
                'status' => $request->status,
            ]);

            DB::commit();
            return redirect()->route('petugas.registrations.index')->with('success', 'Pendaftaran berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui pendaftaran: ' . $e->getMessage());
        }
    }

    public function destroy(Registration $registration)
    {
        $registration->delete();
        return redirect()->route('petugas.registrations.index')->with('success', 'Pendaftaran berhasil dihapus.');
    }
}