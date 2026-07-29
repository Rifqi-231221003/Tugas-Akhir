<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\ExchangeRateController;
use App\Http\Controllers\TrackController;

Route::get('/', function () {
    return response()->json([
        'status' => 'success',
        'api_name' => 'Exachanger API',
        'version' => '1.0.0',
        'base_url' => url('/api'),
        'endpoints' => [
            'GET /' => 'API documentation',
            'GET /exchange-rates' => 'Get all exchange rates',
            'GET /exchange-rate/{from}/{to}' => 'Get specific exchange rate',
            'GET /products' => 'Get all active products',
            'GET /blockchains/{productName}' => 'Get blockchains by product',
            'GET /payment-methods/{productName}' => 'Get payment methods',
            'POST /register' => 'Register new user',
            'POST /login' => 'Login user',
            'GET /profile' => 'Get user profile (Bearer token)',
            'POST /logout' => 'Logout user (Bearer token)',
            'GET /track/{trxId}' => 'Track transaction without login (Android App)',
        ]
    ]);
});

Route::get('/exchange-rates', [ExchangeRateController::class, 'getRates']);
Route::get('/exchange-rate/{from}/{to}', [ExchangeRateController::class, 'getRateByPair']);

Route::get('/products', function () {
    return response()->json([
        'status' => 'success',
        'data' => \App\Models\Product::where('status', 'Active')->get()
    ]);
});

Route::get('/blockchains/{productName}', function ($productName) {
    $blockchains = \App\Models\Blockchain::where('product_name', $productName)->get();
    return response()->json([
        'status' => 'success',
        'data' => $blockchains
    ]);
});

Route::get('/payment-methods/{productName}', function ($productName) {
    $methods = \App\Models\PaymentMethod::where('product_name', $productName)->get();
    return response()->json([
        'status' => 'success',
        'data' => $methods
    ]);
});

// PERBAIKAN: Hapus prefix 'public', ganti jadi 'track' langsung
Route::get('/track/{trxId}', [TrackController::class, 'publicTrack'])
    ->name('api.public.track');

Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:10,1');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
    
    Route::get('/my-transactions', [TransactionController::class, 'myTransactions']);
    Route::get('/transaction/{trxId}', [TransactionController::class, 'show']);
    Route::post('/transaction/create', [TransactionController::class, 'create']);
    Route::post('/transaction/upload-proof', [TransactionController::class, 'uploadProof']);
});