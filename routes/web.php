<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ConfirmationController;
use App\Http\Controllers\TrackController;
use App\Http\Controllers\ExchangeRateController;
use App\Http\Controllers\ViewExchangeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ExchangeRateCodeController;

Route::get('/', [HomeController::class, 'viewer'])->name('home');

// Transaction Routes
Route::get('/transaction/create', [TransactionController::class, 'create'])->name('transaction.create');
Route::post('/transaction/store', [TransactionController::class, 'store'])->name('transaction.store');
Route::get('/transaction/back', [TransactionController::class, 'backToExchange'])->name('transaction.back');

// Payment Routes
Route::get('/payment/upload', [PaymentController::class, 'showUploadForm'])->name('payment.upload');
Route::post('/payment/upload', [PaymentController::class, 'uploadPaymentProof'])->name('payment.upload.submit');

// Confirmation Route
Route::get('/payment/confirmation/{trxId}', [ConfirmationController::class, 'index'])->name('payment.confirmation');

// Exchange Rate Routes
Route::get('/exchange-rate', [ExchangeRateController::class, 'index'])->name('exchange.rate');
Route::get('/api/exchange-rates', [ExchangeRateController::class, 'getRates'])->name('api.exchange.rates');
Route::get('/api/exchange-rate/{from}/{to}', [ExchangeRateController::class, 'getRateByPair'])->name('api.exchange.rate.pair');

// SEO Friendly Exchange Detail
Route::get('/exchange-rate/{from}-to-{to}', [ViewExchangeController::class, 'show'])
    ->name('exchange.rate.detail');

// Exchange Rate Code Routes
Route::get('/exchange-rate-code/{from_code}-to-{to_code}', [ExchangeRateCodeController::class, 'show'])
    ->name('exchange.rate.detail.code');

Route::get('/exchange-rate-code/{from_code}/to/{to_code}', function ($from_code, $to_code) {
    return redirect()->route('exchange.rate.detail.code', [
        'from_code' => $from_code,
        'to_code' => $to_code
    ]);
})->name('exchange.rate.detail.okchanger');

// Tracking Routes
Route::get('/track-transaction', [TrackController::class, 'index'])->name('track.transaction');
Route::post('/track-transaction', [TrackController::class, 'track'])->name('track.transaction.submit');

// Privacy Policy
Route::get('/privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy.policy');

// Contact Routes
Route::get('/contact-us', [ContactController::class, 'showForm'])->name('contact.show');
Route::post('/contact-us', [ContactController::class, 'submitForm'])->name('contact.submit');

