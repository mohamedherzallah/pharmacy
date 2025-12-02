<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\{
AuthController, CategoryController, MedicineController,
PharmacyController, PharmacyMedicineController,
CartController, CheckoutController, OrderController,
PrescriptionController, ConversationController, MessageController,
UserController,PaymentController
};

Route::post('register', [AuthController::class,'register']);
Route::post('login', [AuthController::class,'login']);

Route::get('/categories', [CategoryController::class,'index']);
Route::get('categories/{id}', [CategoryController::class,'show']);

Route::get('medicines', [MedicineController::class,'index']);
Route::get('medicines/{id}', [MedicineController::class,'show']);
Route::get('pharmacies/{id}/medicines', [MedicineController::class,'byPharmacy']);

Route::get('pharmacies', [PharmacyController::class,'index']);
Route::get('pharmacies/{id}', [PharmacyController::class,'show']);

Route::middleware('auth:sanctum')->group(function(){
Route::post('logout', [AuthController::class,'logout']);
Route::get('profile', [UserController::class,'profile']);
Route::post('profile', [UserController::class,'update']);

// pharmacy management by authenticated pharmacy user
Route::get('pharmacy/medicines', [PharmacyMedicineController::class,'index']);
Route::post('pharmacy/medicines', [PharmacyMedicineController::class,'store']);
Route::delete('pharmacy/medicines/{medicineId}', [PharmacyMedicineController::class,'destroy']);

// cart
Route::get('cart', [CartController::class,'index']);
Route::post('cart/add', [CartController::class,'add']);
Route::post('cart/item/{id}', [CartController::class,'updateItem']);
Route::delete('cart/item/{id}', [CartController::class,'remove']);
Route::post('cart/clear', [CartController::class,'clear']);

// checkout & orders
Route::post('checkout', [CheckoutController::class,'checkout']);
Route::apiResource('orders', OrderController::class)->only(['index','show','update','destroy']);

// prescriptions
Route::post('prescriptions', [PrescriptionController::class,'store']);
Route::get('prescriptions', [PrescriptionController::class,'index']);

// chat
Route::get('conversations', [ConversationController::class,'index']);
Route::post('conversations', [ConversationController::class,'store']);
Route::get('conversations/{id}/messages', [MessageController::class,'index']);
Route::post('conversations/{id}/messages', [MessageController::class,'store']);
});

Route::post('/payment/pay', [PaymentController::class, 'pay']);


Route::post('/pharmacy/register', [AuthController::class, 'registerPharmacy']);

//Route::apiResource('pharmacies', PharmacyController::class);
//Route::apiResource('medicines', MedicineController::class);
//Route::apiResource('categories', CategoryController::class);
//Route::apiResource('orders', OrderController::class);
//Route::apiResource('cart', CartController::class);
