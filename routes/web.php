<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\UserController;


Route::get('/', function () {
    return view('welcome');
});

//Route::get('/manage-user',UserController::class);
    //return view('pharmacy-admin');
//Route::get('/products', [ProductController::class, 'index'])->name('products.index');
//Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
//Route::post('/products', [ProductController::class, 'store'])->name('products.store');

Route::resource('Medicines', MedicineController::class);

Route::resource('categories', CategoryController::class);

Route::resource('pharmacies', PharmacyController::class);


Route::resource('users', UserController::class);
Route::post('/users/{id}/toggle-status', [UserController::class, 'toggleStatus']);
