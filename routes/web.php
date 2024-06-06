<?php

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::group(['controller' => ProductController::class, 'prefix' => 'product'], function () {
        Route::get('/', 'index')->name('products');
    });
    
    Route::group(['controller' => PaymentController::class, 'prefix' => 'payment'], function () {
        Route::get('/home', 'home')->name('home');
        Route::get('/paymentResponce', 'paymentResponce')->name('payment.responce');
        Route::get('/paymentSuccess', 'paymentSuccess')->name('payment.success');
        Route::get('/paymentFaild/{msg?}', 'paymentFaild')->name('payment.faild');
        Route::get('/{id}/{type}', 'payment')->name('payment.item');
        Route::get('/checkout/{id}/{type}', 'checkout')->name('payment.checkout.item');
        Route::post('/purchase/{id}/{type}', 'purchase')->name('payment.purchase');
        Route::get('/userInvoices','getUserInvoices')->name('payment.userInvoices');
    });
});

require __DIR__ . '/auth.php';
