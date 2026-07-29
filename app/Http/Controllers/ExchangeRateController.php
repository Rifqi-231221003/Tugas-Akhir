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

    /**
     * XML endpoint untuk OKChanger
     * Format XML yang dibutuhkan oleh OKChanger
     * URL: https://exachanger.com/exchange-rates-okchanger.xml
     *
     * @return \Illuminate\Http\Response
     */
    public function okchangerXml()
    {
        // Ambil semua exchange rates
        $exchanges = Exchange::all();
        
        // Ambil semua products untuk mapping product_code
        $products = Product::all();
        $productCodeMap = [];
        foreach ($products as $product) {
            $productCodeMap[$product->product_name] = $product->product_code;
        }
        
        // Mulai build XML
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= "<rates>\n";
        
        foreach ($exchanges as $exchange) {
            // Dapatkan product code untuk from dan to
            $fromCode = $productCodeMap[$exchange->product1] ?? $exchange->product1;
            $toCode = $productCodeMap[$exchange->product2] ?? $exchange->product2;
            
            // Hitung out rate (1 unit from = berapa unit to)
            $in = 1;
            $out = number_format($exchange->rate, 4, '.', '');
            
            // Reserve (jumlah yang tersedia)
            // Jika tidak ada field reserve, gunakan nilai default 999999
            $amount = $exchange->reserve ?? 999999;
            
            $xml .= "    <item>\n";
            $xml .= "        <from>{$fromCode}</from>\n";
            $xml .= "        <to>{$toCode}</to>\n";
            $xml .= "        <in>{$in}</in>\n";
            $xml .= "        <out>{$out}</out>\n";
            $xml .= "        <amount>{$amount}</amount>\n";
            $xml .= "    </item>\n";
        }
        
        $xml .= "</rates>";
        
        // Kembalikan response sebagai XML
        return response($xml, 200)
            ->header('Content-Type', 'text/xml');
    }
}