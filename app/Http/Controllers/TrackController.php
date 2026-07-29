<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Blockchain;

class TrackController extends Controller
{
    /**
     * Menampilkan halaman tracking form (web view)
     */
    public function index()
    {
        return view('track-transaction');
    }

    /**
     * Memproses tracking berdasarkan trx_id (web form submit)
     */
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

        // Kirim data ke view payment-confirmation
        return view('payment-confirmation', [
            'transaction' => $transaction,
            'product1' => $product1,
            'product2' => $product2,
            'blockchain1' => $blockchain1,
            'blockchain2' => $blockchain2
        ]);
    }

    /**
     * PUBLIC API ENDPOINT - Track transaction without login
     * Method: GET
     * URL: /api/public/track/{trxId}
     * Response: JSON
     * 
     * Contoh response sukses:
     * {
     *   "status": "success",
     *   "data": { ... }
     * }
     * 
     * Contoh response error:
     * {
     *   "status": "error",
     *   "message": "Transaction not found"
     * }
     */
    public function publicTrack($trxId)
    {
        // Cari transaksi berdasarkan trx_id
        $transaction = Payment::where('trx_id', $trxId)->first();

        if (!$transaction) {
            return response()->json([
                'status' => 'error',
                'message' => 'Transaction not found. Please check your Transaction ID.'
            ], 404);
        }

        // Ambil data produk untuk logo
        $product1 = Product::where('product_name', $transaction->product1)->first();
        $product2 = Product::where('product_name', $transaction->product2)->first();

        // Ambil data blockchain untuk product1
        $blockchain1 = null;
        if ($transaction->blockchain1) {
            $blockchain1 = Blockchain::where('product_name', $transaction->product1)
                                    ->where('blockchain', $transaction->blockchain1)
                                    ->first();
        }

        // Ambil data blockchain untuk product2
        $blockchain2 = null;
        if ($transaction->blockchain2) {
            $blockchain2 = Blockchain::where('product_name', $transaction->product2)
                                    ->where('blockchain', $transaction->blockchain2)
                                    ->first();
        }

        // Siapkan response data
        $responseData = [
            'trx_id' => $transaction->trx_id,
            'client_name' => $transaction->client_name,
            'client_email' => $transaction->client_email,
            'client_phonenumber' => $transaction->client_phonenumber,
            'trx_status' => $transaction->trx_status,
            'trx_date' => $transaction->trx_date,
            'product1' => $transaction->product1,
            'product2' => $transaction->product2,
            'blockchain1' => $transaction->blockchain1,
            'blockchain2' => $transaction->blockchain2,
            'product1_amount' => $transaction->product1_amount,
            'product2_amount' => $transaction->product2_amount,
            'fee' => $transaction->fee,
            'product1_dest' => $transaction->product1_dest,
            'product2_dest' => $transaction->product2_dest,
            'product1_img' => $product1 ? $product1->img : null,
            'product2_img' => $product2 ? $product2->img : null,
            'blockchain1_img' => $blockchain1 ? $blockchain1->blockchain_img : null,
            'blockchain2_img' => $blockchain2 ? $blockchain2->blockchain_img : null,
            'product1_payment_proof' => $transaction->product1_payment_proof,
            'product2_payment_proof' => $transaction->product2_payment_proof,
        ];

        return response()->json([
            'status' => 'success',
            'message' => 'Transaction found successfully',
            'data' => $responseData
        ], 200);
    }

    /**
     * API endpoint untuk mendapatkan semua transaksi (admin only)
     * Method: GET
     * URL: /api/transactions
     */
    public function getAllTransactions(Request $request)
    {
        $transactions = Payment::orderBy('trx_date', 'desc')->paginate(20);
        
        return response()->json([
            'status' => 'success',
            'data' => $transactions
        ], 200);
    }

    /**
     * API endpoint untuk mendapatkan transaksi berdasarkan status
     * Method: GET
     * URL: /api/transactions/status/{status}
     * Status: Pending, Success, Rejected
     */
    public function getTransactionsByStatus($status)
    {
        $validStatuses = ['Pending', 'Success', 'Rejected', 'pending', 'success', 'rejected'];
        
        if (!in_array($status, $validStatuses)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid status. Valid statuses: Pending, Success, Rejected'
            ], 400);
        }
        
        $transactions = Payment::where('trx_status', ucfirst(strtolower($status)))
            ->orderBy('trx_date', 'desc')
            ->get();
        
        return response()->json([
            'status' => 'success',
            'data' => $transactions
        ], 200);
    }

    /**
     * Web view untuk tracking (alternatif route)
     */
    public function trackView()
    {
        return view('track-transaction');
    }

    /**
     * Handle tracking from web form (alternative method name)
     */
    public function trackSubmit(Request $request)
    {
        $request->validate([
            'trx_id' => 'required|string'
        ]);

        $transaction = Payment::where('trx_id', $request->trx_id)->first();

        if (!$transaction) {
            return redirect()->back()
                ->with('error', 'Transaction ID not found. Please try again.')
                ->withInput();
        }

        // Redirect to confirmation page with transaction ID
        return redirect()->route('payment.confirmation', ['trxId' => $transaction->trx_id]);
    }
}