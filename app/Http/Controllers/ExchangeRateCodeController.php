<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exchange;
use App\Models\Product;
use App\Models\Blockchain;
use App\Models\Name;

class ExchangeRateCodeController extends Controller
{
    /**
     * Display the exchange rate detail page using product codes
     * Contoh: /exchange-rate-code/SKRL-to-PP
     */
    public function show($from_code, $to_code)
    {
        // Decode URL parameters
        $from_code = urldecode($from_code);
        $to_code = urldecode($to_code);
        
        // Cari product berdasarkan product_code
        $fromProduct = Product::where('product_code', $from_code)->first();
        $toProduct = Product::where('product_code', $to_code)->first();
        
        // Jika product tidak ditemukan
        if (!$fromProduct || !$toProduct) {
            abort(404, 'Product not found for codes: ' . $from_code . ' to ' . $to_code);
        }
        
        $from = $fromProduct->product_name;
        $to = $toProduct->product_name;
        
        // Cari exchange rate berdasarkan product_name
        $exchange = Exchange::where('product1', $from)
                            ->where('product2', $to)
                            ->first();
        
        // Jika tidak ditemukan, coba dengan case insensitive
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
        $canonical = url("/exchange-rate-code/{$from_code}-to-{$to_code}");
        
        // ========== PERBAIKAN: Normalisasi path gambar ==========
        // Fungsi helper untuk mendapatkan URL gambar yang benar
        $getImageUrl = function($img) {
            if (empty($img)) {
                return asset('img/product/default.png');
            }
            // Jika sudah full URL
            if (filter_var($img, FILTER_VALIDATE_URL)) {
                return $img;
            }
            // Jika sudah mengandung path img/product/
            if (str_contains($img, 'img/product/')) {
                return asset($img);
            }
            // Jika hanya nama file
            return asset('img/product/' . $img);
        };
        
        // Ambil gambar produk dengan path yang benar
        $productImages = [];
        $products = Product::all();
        foreach ($products as $product) {
            $productImages[$product->product_name] = $getImageUrl($product->img);
        }
        
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
                    'img' => $getImageUrl($product->img) // Perbaikan di sini
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
        
        // Data product map untuk JavaScript (dengan path gambar yang benar)
        $productMap = [];
        foreach ($products as $product) {
            $productMap[$product->product_code] = [
                'product_code' => $product->product_code,
                'product_name' => $product->product_name,
                'category' => $product->category,
                'img' => $getImageUrl($product->img) // Perbaikan di sini
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
        
        // Ambil product code untuk from dan to
        $fromProductCode = $from_code;
        $toProductCode = $to_code;
        
        return view('exchange-rate-detail-code', compact(
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