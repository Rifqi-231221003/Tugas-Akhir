<?php

namespace App\Http\Controllers;
use App\Models\Exchange;
use App\Models\Product;
use App\Models\Blockchain;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function viewer(Request $request) {
        $exchangeData = Exchange::all();
        $products = Product::all();
        $blockchains = Blockchain::all();
        
        // Ambil parameter dari URL (untuk auto-fill dari exchange-rate)
        $autoFrom = $request->query('from');
        $autoTo = $request->query('to');
        
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
        
        // Buat mapping blockchain berdasarkan product_name (MULTIPLE blockchain)
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
        
        return view('home', compact('exchangeData', 'uniqueProducts', 'products', 'blockchains', 'blockchainMap', 'autoFrom', 'autoTo'));
    }
}