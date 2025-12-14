<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\{AddressController,
    AuthController,
    CategoryController,
    FavoriteController,
    MedicineController,
    PaymentCardController,
    PharmacyController,
    PharmacyMedicineController,
    CartController,
    CheckoutController,
    OrderController,
    PrescriptionController,
    ConversationController,
    MessageController,
    UserController,
    PaymentController,
    ProfileController};

/*
|--------------------------------------------------------------------------
| Auth Routes (Public)
|--------------------------------------------------------------------------
*/
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login',    [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class,'logout']);

    Route::post('pharmacy/register', [AuthController::class, 'registerPharmacy']);

});

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/user/change-password', [AuthController::class, 'changePassword']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
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
Route::get('pharmacy/{id}', [PharmacyController::class,'show']);

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



//    Route::put('pharmacy/profile', [PharmacyController::class, 'updatePharmacyProfile']);
    Route::get('profile', [ProfileController::class, 'getProfile']);   // عرض أي بروفايل
    Route::put('profile', [ProfileController::class, 'updateProfile']);

    /*
    |--------------------- Pharmacy Management ---------------------
    */
    Route::prefix('pharmacy')->group(function () {
        Route::get('medicines',  [PharmacyMedicineController::class,'index']);
        Route::post('medicines', [PharmacyMedicineController::class,'store']);
        Route::put('medicines/{id}', [PharmacyMedicineController::class, 'update']); // إضافة هذا
        Route::delete('medicines/{Id}', [PharmacyMedicineController::class,'destroy']);
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


    Route::apiResource('addresses', AddressController::class);

// Favorites
    Route::prefix('favorites')->group(function () {
        Route::get('/', [FavoriteController::class, 'index']);
        Route::post('add/{medicine_id}', [FavoriteController::class, 'store']);
        Route::delete('remove/{medicine_id}', [FavoriteController::class, 'destroy']);
        Route::get('check/{medicineId}', [FavoriteController::class, 'check']);

    });


    Route::prefix('payment-cards')->group(function () {
        Route::get('/', [PaymentCardController::class, 'index']);
        Route::post('add', [PaymentCardController::class, 'store']);
        Route::post('{id}/set-default', [PaymentCardController::class, 'setDefault']);
        Route::delete('{id}', [PaymentCardController::class, 'destroy']);
    });

    Route::get('/pharmacy/stats', [PharmacyController::class, 'stats']);


// Notifications
//    Route::get('notifications', [NotificationController::class, 'index']);
//    Route::post('notifications/{id}/read', [NotificationController::class, 'markAsRead']);

//
//// Ratings
//    Route::post('medicines/{id}/rate', [RatingController::class, 'rateMedicine']);
//    Route::post('pharmacies/{id}/rate', [RatingController::class, 'ratePharmacy']);
});
