<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\UserController;


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

Route::resource('users', UserController::class);
Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

Route::resource('orders', OrderController::class);

