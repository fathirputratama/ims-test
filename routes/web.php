<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\ActionController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\MedicalTransactionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::resource('/admin/employees', EmployeeController::class)->names('admin.employees');
    Route::resource('/admin/medicines', MedicineController::class)->names('admin.medicines');
    Route::resource('/admin/users', UserController::class)->names('admin.users');
    Route::resource('/admin/actions', ActionController::class)->names('admin.actions');

});

Route::middleware(['auth', 'role:petugas'])->group(function () {
    Route::resource('/petugas/registrations', RegistrationController::class)->names('petugas.registrations');
    Route::get('/petugas/reports', [ReportController::class, 'index'])->name('petugas.reports.index');
});

Route::middleware(['auth', 'role:dokter'])->group(function () {
    Route::resource('/dokter/transactions', MedicalTransactionController::class)->names('dokter.transactions')->only(['index', 'create', 'store', 'show']);
});

Route::middleware(['auth', 'role:kasir'])->group(function () {
    Route::get('/kasir/payments', [App\Http\Controllers\PaymentController::class, 'index'])->name('kasir.payments.index');
    Route::get('/kasir/payments/paid', [App\Http\Controllers\PaymentController::class, 'paid'])->name('kasir.payments.paid');
    Route::get('/kasir/payments/{transactionId}/create', [App\Http\Controllers\PaymentController::class, 'create'])->name('kasir.payments.create');
    Route::post('/kasir/payments/{transactionId}', [App\Http\Controllers\PaymentController::class, 'store'])->name('kasir.payments.store');
    Route::get('/kasir/payments/{transactionId}', [App\Http\Controllers\PaymentController::class, 'show'])->name('kasir.payments.show');
    Route::get('/kasir/payments/{transactionId}/print', [App\Http\Controllers\PaymentController::class, 'print'])->name('kasir.payments.print');
});

require __DIR__.'/auth.php';
