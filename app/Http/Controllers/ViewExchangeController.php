<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exchange;
use App\Models\Product;
use App\Models\Blockchain;
use App\Models\Name;

class ViewExchangeController extends Controller
{
    /**
     * Display the exchange rate detail page for a specific pair
     */
    public function show($from, $to)
    {
        // Decode URL parameters (mengubah PayPal menjadi PayPal, dll)
        $from = urldecode($from);
        $to = urldecode($to);
        
        // Cari exchange rate berdasarkan from dan to
        $exchange = Exchange::where('product1', $from)
                            ->where('product2', $to)
                            ->first();
        
        // Jika tidak ditemukan, cari dengan case insensitive
        if (!$exchange) {
            $exchange = Exchange::whereRaw('LOWER(product1) = ?', [strtolower($from)])
                                ->whereRaw('LOWER(product2) = ?', [strtolower($to)])
                                ->first();
        }
        
        // Jika tetap tidak ditemukan, tampilkan 404
        if (!$exchange) {
            abort(404, 'Exchange rate not found for ' . $from . ' to ' . $to);
        }
        
        // Hitung fee yang benar
        $dbFee = $exchange->fee;
        $feeType = $exchange->fee_type;
        $toProductName = $exchange->product2;
        
        if ($toProductName === 'Neteller') {
            $displayFee = '$0.60 (minimal fee)';
            $feeAmount = 0.60;
        } elseif ($toProductName === 'Skrill') {
            $displayFee = '$0.60 (minimal fee)';
            $feeAmount = 0.60;
        } elseif ($toProductName === 'Payoneer') {
            $displayFee = '$4.00 (minimal fee)';
            $feeAmount = 4.00;
        } else {
            if ($feeType == 'Percentage') {
                $displayFee = $dbFee . '%';
                $feeAmount = $dbFee;
            } else {
                $displayFee = '$' . number_format($dbFee, 2);
                $feeAmount = $dbFee;
            }
        }
        
        // Data untuk meta tags dinamis
        $title = "Exchange {$exchange->product1} to {$exchange->product2} - Best Rate | Exachanger";
        $description = "Exchange {$exchange->product1} to {$exchange->product2} at the best rate. 1 {$exchange->product1} = " . number_format($exchange->rate, 2) . " {$exchange->product2}. Low fees and fast processing.";
        $canonical = url("/exchange-rate/{$from}-to-{$to}");
        
        // Ambil gambar produk
        $productImages = [];
        $products = Product::all();
        foreach ($products as $product) {
            $productImages[$product->product_name] = $product->img;
        }
        
        // ==========================================
        // TAMBAHKAN DATA UNTUK LIVE EXCHANGE (SAMA SEPERTI HOME)
        // ==========================================
        
        // Data exchange untuk live exchange activity
        $exchangeData = Exchange::all();
        
        // Ambil semua nama dari tabel 'name' untuk live exchange activity
        $liveNames = Name::pluck('name')->toArray();
        
        // Ambil product1 yang unik dari exchange
        $uniqueProductNames = Exchange::select('product1')->distinct()->get();
        
        $uniqueProducts = [];
        foreach ($uniqueProductNames as $item) {
            $product = Product::where('product_name', $item->product1)->first();
            if ($product) {
                $uniqueProducts[] = [
                    'product_code' => $product->product_code,
                    'product_name' => $product->product_name,
                    'category' => $product->category,
                    'img' => asset('img/product/' . $product->img)
                ];
            }
        }
        
        // Buat mapping blockchain berdasarkan product_name
        $blockchains = Blockchain::all();
        $blockchainMap = [];
        foreach ($blockchains as $blockchain) {
            $productName = $blockchain->product_name;
            if (!isset($blockchainMap[$productName])) {
                $blockchainMap[$productName] = [];
            }
            $blockchainMap[$productName][] = [
                'blockchain' => $blockchain->blockchain,
                'blockchain_img' => $blockchain->blockchain_img,
                'blockchain_fee' => $blockchain->blockchain_fee,
                'blockchain_code' => $blockchain->blockchain_code
            ];
        }
        
        // Data product map untuk JavaScript
        $productMap = [];
        foreach ($products as $product) {
            $productMap[$product->product_code] = [
                'product_code' => $product->product_code,
                'product_name' => $product->product_name,
                'category' => $product->category,
                'img' => asset('img/product/' . $product->img)
            ];
        }
        
        // Available products untuk JavaScript
        $availableProducts = [];
        foreach ($uniqueProducts as $product) {
            $availableProducts[] = [
                'code' => $product['product_code'],
                'name' => $product['product_name'],
                'category' => $product['category']
            ];
        }
        
        // ==========================================
        // AMBIL PRODUCT CODE UNTUK FROM DAN TO
        // ==========================================
        $fromProductCode = '';
        $toProductCode = '';
        
        // Cari product code untuk from product
        $fromProduct = Product::where('product_name', $exchange->product1)->first();
        if ($fromProduct) {
            $fromProductCode = $fromProduct->product_code;
        }
        
        // Cari product code untuk to product
        $toProduct = Product::where('product_name', $exchange->product2)->first();
        if ($toProduct) {
            $toProductCode = $toProduct->product_code;
        }
        
        return view('exchange-rate-detail', compact(
            'exchange', 
            'displayFee', 
            'feeAmount',
            'title', 
            'description', 
            'canonical',
            'productImages',
            'exchangeData',
            'liveNames',
            'uniqueProducts',
            'products',
            'blockchainMap',
            'productMap',
            'availableProducts',
            'fromProductCode',
            'toProductCode'
        ));
    }
}