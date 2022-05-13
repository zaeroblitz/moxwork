<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Landing\LandingController;
use App\Http\Controllers\Dashboard\MemberController;
use App\Http\Controllers\Dashboard\MyOrderController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\RequestController;
use App\Http\Controllers\Dashboard\ServiceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('explore', [LandingController::class, 'explore'])->name('landing.explore');
Route::get('detail/{id}', [LandingController::class, 'detail'])->name('landing.detail');
Route::get('booking/{id}', [LandingController::class, 'booking'])->name('landing.booking');
Route::get('detail-booking/{id}', [LandingController::class, 'detail_booking'])->name('landing.detail-booking');
Route::resource('/', LandingController::class);

Route::group(['prefix' => 'member', 'as' => 'member.', 'middleware' => ['auth:sanctum', 'verified']],
function() {
    // Dashboard
    Route::resource('dashboard', MemberController::class);

    // Service
    Route::resource('service', ServiceController::class);

    // Request
    Route::get('approve-request/{id}', [RequestController::class, 'approve'])->name('request.approve');
    Route::resource('request', RequestController::class);

    // My Order
    Route::get('accept/oreder/{id}', [MyOrderController::class, 'accepted'])->name('order.accept');
    Route::get('reject/order/{id}', [MyOrderController::class, 'rejected'])->name('order.reject');
    Route::resource('order', MyOrderController::class);

    // Profile
    Route::get('delete-photo', [ProfileController::class, 'delete_photo'])->name('profile.delete-photo');
    Route::resource('profile', ProfileController::class);
}
);

/* Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
}); */