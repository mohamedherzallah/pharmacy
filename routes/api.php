<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\{
    AuthController, CategoryController, MedicineController,
    PharmacyController, PharmacyMedicineController,
    CartController, CheckoutController, OrderController,
    PrescriptionController, ConversationController, MessageController,
    UserController, PaymentController,ProfileController
};

/*
|--------------------------------------------------------------------------
| Auth Routes (Public)
|--------------------------------------------------------------------------
*/
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login',    [AuthController::class, 'login']);

    Route::post('pharmacy/register', [AuthController::class, 'registerPharmacy']);

});


/*
|--------------------------------------------------------------------------
| Public Resources
|--------------------------------------------------------------------------
*/
Route::get('categories', [CategoryController::class,'index']);
Route::get('categories/{id}', [CategoryController::class,'show']);

Route::get('medicines', [MedicineController::class,'index']);
Route::get('medicines/{id}', [MedicineController::class,'show']);
Route::get('pharmacies/{id}/medicines', [MedicineController::class,'byPharmacy']);

Route::get('pharmacies', [PharmacyController::class,'index']);
Route::get('pharmacies/{id}', [PharmacyController::class,'show']);

/*
|--------------------------------------------------------------------------
| Payment (Public)
|--------------------------------------------------------------------------
*/
Route::post('payment/pay', [PaymentController::class, 'pay']);


/*
|--------------------------------------------------------------------------
| Protected Routes (Require Sanctum Token)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    /*
    |------------------------- Auth -------------------------
    */
    Route::post('auth/logout', [AuthController::class,'logout']);
//
//    Route::get('profile',  [UserController::class,'profile']);
//    Route::post('profile', [UserController::class,'update']);
//    Route::put('pharmacy/profile', [PharmacyController::class, 'updatePharmacyProfile']);
    Route::get('profile', [ProfileController::class, 'getProfile']);   // عرض أي بروفايل
    Route::put('profile', [ProfileController::class, 'updateProfile']);

    /*
    |--------------------- Pharmacy Management ---------------------
    */
    Route::prefix('pharmacy')->group(function () {
        Route::get('medicines',  [PharmacyMedicineController::class,'index']);
        Route::post('medicines', [PharmacyMedicineController::class,'store']);
        Route::delete('medicines/{medicineId}', [PharmacyMedicineController::class,'destroy']);
    });

    /*
    |-------------------------- Cart --------------------------
    */
    Route::prefix('cart')->group(function () {
        Route::get('/',    [CartController::class,'index']);
        Route::post('add',           [CartController::class,'add']);
        Route::post('item/{id}',     [CartController::class,'updateItem']);
        Route::delete('item/{id}',   [CartController::class,'remove']);
        Route::post('clear',         [CartController::class,'clear']);
    });

    /*
    |------------------- Checkout & Orders -------------------
    */
    Route::post('checkout', [CheckoutController::class,'checkout']);
    Route::apiResource('orders', OrderController::class)->only([
        'index', 'show', 'update', 'destroy'
    ]);

    /*
    |---------------------- Prescriptions ----------------------
    */
    Route::post('prescriptions', [PrescriptionController::class,'store']);
    Route::get('prescriptions',  [PrescriptionController::class,'index']);

    /*
    |-------------------------- Chat ---------------------------
    */
    Route::prefix('chat')->group(function () {
        Route::get('conversations', [ConversationController::class,'index']);
        Route::post('conversations', [ConversationController::class,'store']);

        Route::get('conversations/{id}/messages',  [MessageController::class,'index']);
        Route::post('conversations/{id}/messages', [MessageController::class,'store']);
    });

});
