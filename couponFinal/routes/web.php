<?php

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\AddresseController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\FilterController;

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






Route::post('auth/save', [LoginController::class, 'save'])->name('auth.save');
Route::post('auth/check', [LoginController::class, 'check'])->name('auth.check');
Route::get('auth/logout', [LoginController::class, 'logout'])->name('auth.logout');

Route::group(['middleware'=>['AuthCheck']], function() {
    Route::get('/', [LoginController::class, 'index']);
    Route::get('/admin/dashboard', [LoginController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/auth/login', [LoginController::class, 'login'])->name('auth.login')->middleware('guest');
    // Route::get('/auth/register', [LoginController::class, 'register'])->name('auth.register');

    // COUPONS REQUESTS
    
    Route::post('/coupon', [CouponController::class, 'store'])->name('coupon');
    Route::get('/coupon/create', [CouponController::class, 'create'])->name('coupon.create');
    Route::get('/coupon/active', [CouponController::class, 'active'])->name('coupon.active');
    Route::get('/coupon/all', [CouponController::class, 'all'])->name('coupon.all');
    Route::get('/coupon/used', [CouponController::class, 'used'])->name('coupon.used');
    Route::get('/coupon/non_used', [CouponController::class, 'non_used'])->name('coupon.non_used');
    Route::get('/coupon/create', [CouponController::class, 'create'])->name('coupon.create');

    Route::post('/edit/{id}', [CouponController::class, 'edit'])->name('edit');
    Route::patch('/update/{id}', [CouponController::class, 'update'])->name('update');
    Route::delete('/delete', [CouponController::class, 'delete'])->name('delete');

    Route::post('/filter', [FilterController::class, 'filter'])->name('filter');
    
    Route::get('/email/addresse', [AddresseController::class, 'addresse'])->name('email.addresse');
});



