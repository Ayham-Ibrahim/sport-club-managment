<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\SubscriptionController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('subscriptions/create', [SubscriptionController::class, 'create'])->name('subscriptions.create');
Route::post('subscriptions/store', [SubscriptionController::class, 'store'])->name('subscriptions.store');
