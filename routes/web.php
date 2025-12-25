<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PharmacyMedicineController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\UserController;
use App\Models\Pharmacy;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');



Route::get('pharmacies/pending', [PharmacyController::class, 'pending'])->name('pharmacies.pending');
Route::put('pharmacies/{id}/approve', [PharmacyController::class, 'approve'])->name('pharmacies.approve');
Route::delete('pharmacies/{id}/reject', [PharmacyController::class, 'reject'])->name('pharmacies.reject');

Route::resource('Medicines', MedicineController::class);

Route::resource('categories', CategoryController::class);

Route::resource('pharmacies', PharmacyController::class);


// عرض كل الأدوية الخاصة بصيدلية معينة
Route::get('/pharmacies/{pharmacy}/medicines', [PharmacyMedicineController::class, 'index'])
    ->name('pharmacy.medicines.index');

Route::get('/pharmacies/{pharmacy}/medicines/add', [PharmacyMedicineController::class, 'create'])->name('pharmacy.medicines.add');

// حفظ الأدوية المختارة مع السعر والكمية
Route::post('/pharmacies/{pharmacy}/medicines', [PharmacyMedicineController::class, 'store'])->name('pharmacy.medicines.store');

// إزالة دواء من صيدلية معينة (اختياري)
Route::delete('/pharmacies/{pharmacy}/medicines/{medicine}', [PharmacyMedicineController::class, 'destroy'])->name('pharmacy.medicines.destroy');

Route::resource('users', UserController::class);
Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

Route::resource('orders', OrderController::class);

