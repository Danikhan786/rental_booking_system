<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [FrontendController::class, 'index'])->name('frontend.index');
Route::get('/property', [FrontendController::class, 'property'])->name('frontend.property');

Auth::routes();

Route::middleware(['auth'])->group(function () {
    // Home route
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    Route::get('/dashboard', [FrontendController::class, 'dashboard'])->name('backend.dashboard');
    // Route::get('/dashboard/properties', [FrontendController::class, 'backendProperty'])->name('backend.properties.index');
    Route::resource('properties', PropertyController::class);
    Route::resource('bookings', BookingController::class);
    // Route for displaying the contract page
    Route::get('/bookings/contract/{propertyId}/{bookingDate}/{bookingEndDate}/{customersData}', [BookingController::class, 'contract'])->name('bookings.contract');
    // Route for accepting the contract
    Route::post('/bookings/accept-contract', [BookingController::class, 'acceptContract'])->name('bookings.acceptContract');

    Route::post('stripe/payment',[BookingController::class, 'payment'])->name('stripe');
    Route::get('stripe/success',[BookingController::class, 'success'])->name('stripe_success');
    Route::get('stripe/cancel',[BookingController::class, 'cancel'])->name('stripe_cancel');

});
