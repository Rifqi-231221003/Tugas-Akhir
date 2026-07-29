<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exchange;
use App\Models\Product;

class ExchangeRateController extends Controller
{
    /**
     * Menampilkan halaman exchange rate untuk user
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ambil semua data exchange
        $exchanges = Exchange::all();
        
        // Ambil semua produk untuk gambar
        $products = Product::all();
        $productImages = [];
        foreach ($products as $product) {
            $productImages[$product->product_name] = $product->img;
        }
        
        // Ambil daftar unique products untuk filter (dari exchange)
        $uniqueProducts = [];
        foreach ($exchanges as $exchange) {
            if (!in_array($exchange->product1, array_column($uniqueProducts, 'product_name'))) {
                $uniqueProducts[] = [
                    'product_name' => $exchange->product1,
                    'product_code' => $exchange->product1,
                    'category' => $this->getProductCategory($exchange->product1, $products)
                ];
            }
            if (!in_array($exchange->product2, array_column($uniqueProducts, 'product_name'))) {
                $uniqueProducts[] = [
                    'product_name' => $exchange->product2,
                    'product_code' => $exchange->product2,
                    'category' => $this->getProductCategory($exchange->product2, $products)
                ];
            }
        }
        
        // Urutkan berdasarkan nama produk
        usort($uniqueProducts, function($a, $b) {
            return strcmp($a['product_name'], $b['product_name']);
        });
        
        return view('exchange-rate', [
            'exchanges' => $exchanges,
            'productImages' => $productImages,
            'uniqueProducts' => $uniqueProducts
        ]);
    }
    
    /**
     * Mendapatkan kategori produk berdasarkan nama
     *
     * @param string $productName
     * @param \Illuminate\Database\Eloquent\Collection $products
     * @return string|null
     */
    private function getProductCategory($productName, $products)
    {
        foreach ($products as $product) {
            if ($product->product_name === $productName) {
                return $product->category;
            }
        }
        return null;
    }
    
    /**
     * API endpoint untuk mendapatkan exchange rates dalam format JSON
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRates()
    {
        $exchanges = Exchange::all();
        
        // Ambil produk untuk gambar
        $products = Product::all();
        $productImages = [];
        foreach ($products as $product) {
            $productImages[$product->product_name] = [
                'img' => $product->img,
                'category' => $product->category
            ];
        }
        
        $rates = [];
        foreach ($exchanges as $exchange) {
            $rates[] = [
                'id' => $exchange->exc_code,
                'from' => $exchange->product1,
                'to' => $exchange->product2,
                'from_img' => isset($productImages[$exchange->product1]) ? asset('img/product/' . $productImages[$exchange->product1]['img']) : null,
                'to_img' => isset($productImages[$exchange->product2]) ? asset('img/product/' . $productImages[$exchange->product2]['img']) : null,
                'rate' => $exchange->rate,
                'fee' => $exchange->fee,
                'fee_type' => $exchange->fee_type,
                'min' => $exchange->min
            ];
        }
        
        return response()->json([
            'success' => true,
            'data' => $rates
        ]);
    }
    
    /**
     * Mendapatkan exchange rate spesifik berdasarkan pasangan produk
     *
     * @param string $from
     * @param string $to
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRateByPair($from, $to)
    {
        $exchange = Exchange::where('product1', $from)
                            ->where('product2', $to)
                            ->first();
        
        if (!$exchange) {
            return response()->json([
                'success' => false,
                'message' => 'Exchange rate not found'
            ], 404);
        }
        
        // Ambil produk untuk gambar
        $products = Product::all();
        $productImages = [];
        foreach ($products as $product) {
            $productImages[$product->product_name] = $product->img;
        }
        
        return response()->json([
            'success' => true,
            'data' => [
                'from' => $exchange->product1,
                'to' => $exchange->product2,
                'from_img' => isset($productImages[$exchange->product1]) ? asset('img/product/' . $productImages[$exchange->product1]) : null,
                'to_img' => isset($productImages[$exchange->product2]) ? asset('img/product/' . $productImages[$exchange->product2]) : null,
                'rate' => $exchange->rate,
                'fee' => $exchange->fee,
                'fee_type' => $exchange->fee_type,
                'min' => $exchange->min
            ]
        ]);
    }
}