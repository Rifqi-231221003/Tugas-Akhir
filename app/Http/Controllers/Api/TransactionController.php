<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Exchange;
use App\Models\Product;
use App\Models\Blockchain;
use App\Models\PaymentMethod;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    /**
     * Create transaction (sebelum upload payment)
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0.01|max:9999',
            'from_product_code' => 'required|string',
            'to_exc_code' => 'required|string',
            'from_blockchain' => 'nullable|string',
            'to_blockchain' => 'nullable|string',
            'rate' => 'required|numeric',
            'fee_amount' => 'required|numeric',
            'fee_text' => 'required|string',
            'final_amount' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Get product details
        $fromProduct = Product::where('product_code', $request->from_product_code)->first();
        $exchange = Exchange::where('exc_code', $request->to_exc_code)->first();
        
        if (!$fromProduct || !$exchange) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid product or exchange rate'
            ], 400);
        }

        $toProductCode = explode('-', $request->to_exc_code)[1];
        $toProduct = Product::where('product_code', $toProductCode)->first();

        // Get payment method destination
        $paymentMethodQuery = PaymentMethod::where('product_name', $fromProduct->product_name);
        if ($request->from_blockchain) {
            $paymentMethodQuery->where('pm_blockchain', $request->from_blockchain);
        }
        $paymentMethod = $paymentMethodQuery->first();

        // Store in session (temporary)
        $tempData = [
            'from_product_code' => $request->from_product_code,
            'from_product_name' => $fromProduct->product_name,
            'to_product_name' => $toProduct->product_name,
            'from_blockchain' => $request->from_blockchain,
            'to_blockchain' => $request->to_blockchain,
            'amount' => $request->amount,
            'rate' => $request->rate,
            'fee' => $request->fee_amount,
            'fee_text' => $request->fee_text,
            'final_amount' => $request->final_amount,
            'product1_dest' => $paymentMethod ? $paymentMethod->destination : ''
        ];

        session(['temp_transaction_api' => $tempData]);

        return response()->json([
            'status' => 'success',
            'message' => 'Transaction data saved. Please proceed to upload payment proof.',
            'data' => [
                'from_product' => $fromProduct,
                'to_product' => $toProduct,
                'payment_destination' => $paymentMethod ? $paymentMethod->destination : null,
                'amount' => $request->amount,
                'final_amount' => $request->final_amount,
                'fee' => $request->fee_text
            ]
        ]);
    }

    /**
     * Upload payment proof
     */
    public function uploadProof(Request $request)
    {
        $tempData = session('temp_transaction_api');

        if (!$tempData) {
            return response()->json([
                'status' => 'error',
                'message' => 'No transaction data found. Please create transaction first.'
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'full_phone' => 'required|string|max:20',
            'product2_dest' => 'required|string|max:255',
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:10240'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Generate transaction ID
        $transactionId = 'TRX-' . strtoupper(uniqid());

        // Upload file
        $filename = null;
        if ($request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');
            $filename = $transactionId . '_proof_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('img/payment/src'), $filename);
        }

        // Save to database
        $transaction = Payment::create([
            'trx_id' => $transactionId,
            'client_name' => $request->full_name,
            'client_email' => $request->email,
            'client_phonenumber' => $request->full_phone,
            'trx_status' => 'Pending',
            'trx_date' => now(),
            'product1' => $tempData['from_product_name'],
            'product2' => $tempData['to_product_name'],
            'blockchain1' => $tempData['from_blockchain'],
            'blockchain2' => $tempData['to_blockchain'],
            'product1_amount' => $tempData['amount'],
            'product2_amount' => $tempData['final_amount'],
            'fee' => $tempData['fee'],
            'product1_dest' => $tempData['product1_dest'],
            'product2_dest' => $request->product2_dest,
            'product1_payment_proof' => $filename ? 'img/payment/src/' . $filename : null,
            'product2_payment_proof' => null
        ]);

        // Clear session
        session()->forget('temp_transaction_api');

        // Get user if logged in
        $user = $request->user();
        if ($user) {
            $transaction->user_id = $user->id;
            $transaction->save();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Payment proof uploaded successfully',
            'data' => [
                'trx_id' => $transactionId,
                'status' => 'Pending',
                'message' => 'Your transaction is pending. We will process it within 24 hours.',
                'track_url' => url('/track-transaction?trx_id=' . $transactionId)
            ]
        ], 201);
    }

    /**
     * Track transaction by ID
     */
    public function track($trxId)
    {
        $transaction = Payment::where('trx_id', $trxId)->first();

        if (!$transaction) {
            return response()->json([
                'status' => 'error',
                'message' => 'Transaction not found'
            ], 404);
        }

        // Get product images
        $product1 = Product::where('product_name', $transaction->product1)->first();
        $product2 = Product::where('product_name', $transaction->product2)->first();

        return response()->json([
            'status' => 'success',
            'data' => [
                'trx_id' => $transaction->trx_id,
                'status' => $transaction->trx_status,
                'date' => $transaction->trx_date,
                'from' => [
                    'name' => $transaction->product1,
                    'amount' => $transaction->product1_amount,
                    'img' => $product1 ? asset('img/product/' . $product1->img) : null
                ],
                'to' => [
                    'name' => $transaction->product2,
                    'amount' => $transaction->product2_amount,
                    'img' => $product2 ? asset('img/product/' . $product2->img) : null
                ],
                'fee' => $transaction->fee,
                'status_history' => $this->getStatusHistory($transaction->trx_status)
            ]
        ]);
    }

    /**
     * Get user's own transactions
     */
    public function myTransactions(Request $request)
    {
        $user = $request->user();
        
        // Get user email or try to find by name
        $transactions = Payment::where('client_email', $user->email)
            ->orWhere('client_name', $user->name)
            ->orderBy('trx_date', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $transactions->map(function ($transaction) {
                return [
                    'trx_id' => $transaction->trx_id,
                    'status' => $transaction->trx_status,
                    'date' => $transaction->trx_date,
                    'from' => $transaction->product1,
                    'to' => $transaction->product2,
                    'amount' => $transaction->product1_amount,
                    'received' => $transaction->product2_amount
                ];
            })
        ]);
    }

    /**
     * Get status history text
     */
    private function getStatusHistory($status)
    {
        $history = [
            'Pending' => [
                ['status' => 'Pending', 'date' => now()->format('Y-m-d H:i:s'), 'description' => 'Transaction created, waiting for payment verification']
            ]
        ];

        if ($status === 'Success') {
            $history['Pending'][] = ['status' => 'Success', 'date' => now()->format('Y-m-d H:i:s'), 'description' => 'Payment verified and completed'];
        } elseif ($status === 'Rejected') {
            $history['Pending'][] = ['status' => 'Rejected', 'date' => now()->format('Y-m-d H:i:s'), 'description' => 'Payment verification failed'];
        }

        return $history;
    }
}