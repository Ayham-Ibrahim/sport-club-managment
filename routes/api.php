<?php

use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\SportController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\SubscriptionController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/**
 * Auth Routes
 *
 * These routes handle user authentication, including login, registration, and logout.
 */
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    // handle logout method
    Route::post('/logout', [AuthController::class, 'logout']);

});





// // version v1
Route::prefix('v1')->group(function () {

    /**
     * Route that does not need Authentication
     */
    // make a payment
    Route::post('make-payment',[PaymentController::class,'store']);
    
    // list articles and show  detailes of article by id
    Route::post('list-articles',[ArticleController::class, 'index']);
    Route::get('articles/{article}',[ArticleController::class, 'show']);
    

    // list articles and show  detailes of article by id
    Route::get('get-categories',[CategoryController::class, 'index']);
    Route::get('get-category/{category}', [CategoryController::class, 'show']);

    // list sports and show  detailes of article by id
    Route::get('sports',[SportController::class, 'index']);
    Route::get('sports/{sport}', [SportController::class, 'show']);

    // list rooms and show  detailes of article by id
    Route::get('rooms',[RoomController::class, 'index']);
    Route::get('rooms/{room}', [RoomController::class, 'show']);

    // list offers and show  detailes of article by id
    Route::get('offers',[OfferController::class, 'index']);
    Route::get('offers/{offer}', [OfferController::class, 'show']);

    // list facilities and show  detailes of article by id
    Route::get('facilities',[FacilityController::class, 'index']);
    Route::get('facilities/{facility}', [FacilityController::class, 'show']);




    /**
     * admin and content writer  Routes
     *
     * These routes handle Auth admin and content writer  operations.
     */
    Route::middleware(['auth:sanctum','checkRole:ContentWriter,Admin'])->group(function () {
        /**
         *  category Management Routes
         *
         * These routes handle category management operations 
         */
        Route::controller(CategoryController::class)->group(function () {
            Route::post('create-category', 'store');
            Route::put('update-category/{category}', 'update');
            Route::delete('delete-category/{category}', 'destroy');
        });

        /**
         *  Article Management Routes
         *
         * These routes handle category management operations 
         */
        Route::controller(ArticleController::class)->group(function () {
            Route::post('articles', 'store');
            Route::put('articles/{article}', 'update');
            Route::delete('articles/{article}', 'destroy');
        });
        
        /**
         *  tag Management Routes
         *
         * These routes handle tag management operations 
         */
        Route::resource('tags', TagController::class);



    });

    Route::middleware(['auth:sanctum','checkRole:SportManager,Admin'])->group(function () {
        
        // These routes handle facilities management operations (create ,update,deleete) 
        Route::controller(FacilityController::class)->group(function () {
            Route::post('facilities', 'store');
            Route::put('facilities/{facility}', 'update');
            Route::delete('facilities/{facility}', 'destroy');
        });

        // These routes handle offers management operations (create ,update,deleete) 
        Route::controller(OfferController::class)->group(function () {
            Route::post('offers', 'store');
            Route::put('offers/{offer}', 'update');
            Route::delete('offers/{offer}', 'destroy');
        });

        // These routes handle rooms management operations (create ,update,deleete) 
        Route::controller(RoomController::class)->group(function () {
            Route::post('rooms', 'store');
            Route::put('rooms/{room}', 'update');
            Route::delete('rooms/{room}', 'destroy');
        });

        // These routes handle sport management operations (create ,update,deleete) 
        Route::controller(SportController::class)->group(function () {
            Route::post('sports', 'store');
            Route::put('sports/{sport}', 'update');
            Route::delete('sports/{sport}', 'destroy');
        });

        // filtering the subscripers payments
        Route::post('payments',[PaymentController::class,'index']);

        // manage subscription operation (renew , suspend,delete)
        Route::post('renew-subscription/{subscription}',[SubscriptionController::class,'renew']);
        Route::post('suspend-subscription/{subscription}',[SubscriptionController::class,'suspend']);
        Route::post('delete-subscription/{subscription}',[SubscriptionController::class,'destroy']);
    });
});


