<?php

use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\SportController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\SubscriptionController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::prefix('v1')->group(function () {

});

/**
 * Auth Routes
 *
 * These routes handle user authentication, including login, registration, and logout.
 */
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::resource('sports', SportController::class);
Route::resource('facilities', FacilityController::class);
Route::resource('rooms', RoomController::class);
Route::resource('offers', OfferController::class);

Route::post('renew-subscription/{subscription}',[SubscriptionController::class,'renew']);
Route::post('suspend-subscription/{subscription}',[SubscriptionController::class,'suspend']);
Route::post('delete-subscription/{subscription}',[SubscriptionController::class,'destroy']);

Route::post('make-payment',[PaymentController::class,'store']);
Route::post('payments',[PaymentController::class,'index']);


/**
 * Authenticated user Routes
 *
 * These routes handle Auth user  operations (Admin and users).
 */
Route::middleware('auth:sanctum')->group(function () {
    // handle logout method
    Route::post('/logout', [AuthController::class, 'logout']);

    /**
     *  category Management Routes
     *
     * These routes handle category management operations 
     */
    Route::controller(CategoryController::class)->group(function () {
        Route::get('get-categories', 'index');
        Route::get('get-category/{category}', 'show');
        Route::post('create-category', 'store');
        Route::put('update-category/{category}', 'update');
        Route::delete('delete-category/{category}', 'destroy');
    });

    // Route::resource('categories', CategoryController::class);

    
    /**
     *  tag Management Routes
     *
     * These routes handle tag management operations 
     */
    Route::controller(CategoryController::class)->group(function () {
        Route::get('get-tags', 'index');
        Route::get('get-tag/{tag}', 'show');
        Route::post('create-tag', 'store');
        Route::put('update-tag/{tag}', 'update');
        Route::delete('delete-tag/{tag}', 'destroy');
    });


    
});