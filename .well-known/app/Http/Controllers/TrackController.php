<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Blockchain;

class TrackController extends Controller
{
    // Menampilkan halaman tracking form
    public function index()
    {
        return view('track-transaction');
    }

    // Memproses tracking berdasarkan trx_id
    public function track(Request $request)
    {
        $request->validate([
            'trx_id' => 'required|string'
        ]);

        $transaction = Payment::where('trx_id', $request->trx_id)->first();

        if (!$transaction) {
            return redirect()->route('track.transaction')
                ->with('error', 'Transaction not found. Please check your Trx ID and try again.');
        }

        // Ambil data produk untuk logo
        $product1 = Product::where('product_name', $transaction->product1)->first();
        $product2 = Product::where('product_name', $transaction->product2)->first();

        // Ambil data blockchain
        $blockchain1 = null;
        if ($transaction->blockchain1) {
            $blockchain1 = Blockchain::where('product_name', $transaction->product1)
                                    ->where('blockchain', $transaction->blockchain1)
                                    ->first();
        }

        $blockchain2 = null;
        if ($transaction->blockchain2) {
            $blockchain2 = Blockchain::where('product_name', $transaction->product2)
                                    ->where('blockchain', $transaction->blockchain2)
                                    ->first();
        }

        // Kirim data ke view payment-confirmation yang sudah ada
        return view('payment-confirmation', [
            'transaction' => $transaction,
            'product1' => $product1,
            'product2' => $product2,
            'blockchain1' => $blockchain1,
            'blockchain2' => $blockchain2
        ]);
    }
}