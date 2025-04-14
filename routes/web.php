<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\FleetsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TripController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;

Route::get('/', [SiteController::class, 'index']);
Route::get('/our-fleets', [SiteController::class, 'fleets']);
Route::get('/our-services', [SiteController::class, 'services']);
Route::get('/contact-us', [SiteController::class, 'contact']);

Route::post('/checkout', [PaymentController::class, 'create']);
Route::get('/success', [PaymentController::class, 'success'])->name('success');
Route::get('/cancel', [PaymentController::class, 'cancel'])->name('cancel');


Route::post('/webhook-stripe', [PaymentController::class, 'handleStripeWebhook']);

// vue routes
Route::get('/booking', [SiteController::class, 'booking']);
Route::post('/search/api/fleets', [FleetsController::class, 'search']);


Route::prefix('/admin')->group(function () {
    Route::middleware(['adminGuestOnly'])->group(function () {
        Route::get('login', [AdminController::class, 'login']);
        Route::post('login', [AdminController::class, 'AttemptLogin']);
        Route::get('forget-password', [AdminController::class, 'forgetPassword']);
        Route::post('change-password', [AdminController::class, 'changePassword']);
    });

    Route::middleware(['adminLoggedIn'])->group(function () {
        Route::get('/', [AdminController::class, 'index']);
        Route::post('/update-booking', [PaymentController::class, 'updateBooking']);
        Route::get('/api/fleets', [FleetsController::class, 'GetFleets']);
        Route::post('/api/fleets', [FleetsController::class, 'InsertFleets']);
        Route::put('/api/fleets/update/{id}', [FleetsController::class, 'UpdateFleets']);
        Route::get('/api/fleets/{id}', [FleetsController::class, 'DeleteFleets']);


        Route::get('/api/drivers', [DriverController::class, 'index']);
        Route::post('/api/drivers', [DriverController::class, 'store']);
        Route::put('/api/drivers/update/{id}', [DriverController::class, 'update']);
        Route::get('/api/drivers/{id}', [DriverController::class, 'destroy']);

        Route::get('/api/trips', [TripController::class, 'index']);

        Route::get('/fleets', [AdminController::class, 'fleets']);
        Route::get('/drivers', [AdminController::class, 'drivers']);
        Route::get('/passengers', [AdminController::class, 'passengers']);
        Route::get('/trips', [AdminController::class, 'trips']);
        Route::get('logout', [AdminController::class, 'logout']);
    });
});
