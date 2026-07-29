<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Exchange;
use App\Models\Blockchain;
use App\Models\PaymentMethod;

class TransactionController extends Controller
{
    // Menampilkan halaman form transaksi
    public function create(Request $request)
    {
        $amount = $request->input('amount');
        $fromProductCode = $request->input('from_product_code');
        $toExcCode = $request->input('to_exc_code');
        $fromBlockchainName = $request->input('from_blockchain');
        $toBlockchainName = $request->input('to_blockchain');
        $rate = $request->input('rate');
        $feeAmount = $request->input('fee_amount');
        $feeText = $request->input('fee_text');
        $finalAmount = $request->input('final_amount');
        
        // Ambil data produk From
        $fromProduct = Product::where('product_code', $fromProductCode)->first();
        if (!$fromProduct) {
            return redirect()->route('home')->with('error', 'Invalid product selected');
        }
        
        // Ambil data produk To dari exchange
        $exchange = Exchange::where('exc_code', $toExcCode)->first();
        if (!$exchange) {
            return redirect()->route('home')->with('error', 'Invalid exchange rate selected');
        }
        
        $toProductCode = explode('-', $toExcCode)[1];
        $toProduct = Product::where('product_code', $toProductCode)->first();
        
        // Ambil data blockchain From
        $fromBlockchainData = null;
        if ($fromBlockchainName) {
            $blockchain = Blockchain::where('product_name', $fromProduct->product_name)
                                    ->where('blockchain', $fromBlockchainName)
                                    ->first();
            if ($blockchain) {
                $fromBlockchainData = [
                    'name' => $blockchain->blockchain,
                    'img' => $blockchain->blockchain_img ? asset('img/blockchain/' . $blockchain->blockchain_img) : null,
                    'fee' => $blockchain->blockchain_fee
                ];
            }
        }
        
        // Ambil data blockchain To
        $toBlockchainData = null;
        if ($toBlockchainName) {
            $blockchain = Blockchain::where('product_name', $toProduct->product_name)
                                    ->where('blockchain', $toBlockchainName)
                                    ->first();
            if ($blockchain) {
                $toBlockchainData = [
                    'name' => $blockchain->blockchain,
                    'img' => $blockchain->blockchain_img ? asset('img/blockchain/' . $blockchain->blockchain_img) : null,
                    'fee' => $blockchain->blockchain_fee
                ];
            }
        }

        // Ambil data payment_method berdasarkan product_name DAN blockchain yang dipilih
        $paymentMethod = PaymentMethod::where('product_name', $toProduct->product_name)
                                        ->where('pm_blockchain', $toBlockchainName)
                                        ->first();
        
        return view('transaction', [
            'amount' => $amount,
            'fromProduct' => [
                'code' => $fromProduct->product_code,
                'name' => $fromProduct->product_name,
                'img' => asset('img/product/' . $fromProduct->img),
                'category' => $fromProduct->category
            ],
            'toProduct' => [
                'code' => $toProduct->product_code,
                'name' => $toProduct->product_name,
                'img' => asset('img/product/' . $toProduct->img),
                'category' => $toProduct->category
            ],
            'fromBlockchain' => $fromBlockchainData,
            'toBlockchain' => $toBlockchainData,
            'rate' => $rate,
            'exchangeFee' => $exchange->fee,
            'feeType' => $exchange->fee_type,
            'feeAmount' => $feeAmount,
            'feeText' => $feeText,
            'finalAmount' => $finalAmount,
            'minAmount' => $exchange->min,
            'customer_data' => null
        ]);
    }
    
    // Memproses data customer - simpan ke session sementara
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'from_product_code' => 'required|string',
            'from_product_name' => 'required|string',
            'to_product_code' => 'required|string',
            'to_product_name' => 'required|string',
            'to_category' => 'required|string',
            'rate' => 'required|numeric',
            'fee' => 'required|numeric',
            'fee_text' => 'required|string',
            'final_amount' => 'required|numeric',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'full_phone' => 'required|string|max:20',
        ]);
        
        // Validasi conditional
        if ($request->to_category === 'Crypto') {
            $request->validate([
                'wallet_address' => 'required|string|max:255'
            ]);
            $product2Dest = $request->wallet_address;
        } else {
            $request->validate([
                'account_email' => 'required|email|max:255'
            ]);
            $product2Dest = $request->account_email;
        }
        
        // Cari destination untuk product1 dari payment_method berdasarkan product_name dan blockchain
        $paymentMethod = PaymentMethod::where('product_name', $request->from_product_name);

        // Jika ada blockchain, cari yang sesuai
        if ($request->from_blockchain) {
            $paymentMethod = $paymentMethod->where('pm_blockchain', $request->from_blockchain);
        }

        $paymentMethod = $paymentMethod->first();
        $product1Dest = $paymentMethod ? $paymentMethod->destination : '';
        
        // ============================================= //
        // PERBAIKAN: Bersihkan nomor telepon dari double country code //
        // ============================================= //
        $cleanPhone = $request->full_phone;
        
        // Hapus double formatting seperti "+374 +37456777" menjadi "+37456777"
        if (preg_match('/^(\+\d+)\s\+\d+/', $cleanPhone)) {
            $cleanPhone = preg_replace('/^(\+\d+)\s\+\d+/', '$1', $cleanPhone);
        }
        
        // Hapus spasi berlebih
        $cleanPhone = preg_replace('/\s+/', '', $cleanPhone);
        
        // Simpan data ke session sementara
        session([
            'temp_transaction' => [
                'from_product_code' => $request->from_product_code,
                'from_product_name' => $request->from_product_name,
                'to_product_code' => $request->to_product_code,
                'to_product_name' => $request->to_product_name,
                'to_category' => $request->to_category,
                'from_blockchain' => $request->from_blockchain,
                'to_blockchain' => $request->to_blockchain,
                'amount' => $request->amount,
                'rate' => $request->rate,
                'fee' => $request->fee,
                'fee_text' => $request->fee_text,
                'final_amount' => $request->final_amount,
                'full_name' => $request->full_name,
                'email' => $request->email,
                'full_phone' => $cleanPhone, // Gunakan nomor yang sudah dibersihkan
                'product1_dest' => $product1Dest,
                'product2_dest' => $product2Dest,
                'exc_code' => $request->from_product_code . '-' . $request->to_product_code,
            ]
        ]);
        
        // Redirect ke halaman upload payment proof
        return redirect()->route('payment.upload');
    }
    
    // ============================================= //
    // METHOD UNTUK BACK BUTTON                       //
    // ============================================= //
    public function backToExchange()
    {
        $tempData = session('temp_transaction');
        
        if (!$tempData) {
            return redirect()->route('home')->with('error', 'No transaction data found. Please start over.');
        }
        
        // Ambil data dari session
        $amount = $tempData['amount'];
        $fromProductCode = $tempData['from_product_code'];
        $toProductCode = $tempData['to_product_code'];
        $fromBlockchainName = $tempData['from_blockchain'];
        $toBlockchainName = $tempData['to_blockchain'];
        $rate = $tempData['rate'];
        $feeAmount = $tempData['fee'];
        $feeText = $tempData['fee_text'];
        $finalAmount = $tempData['final_amount'];
        
        // Ambil data produk From
        $fromProduct = Product::where('product_code', $fromProductCode)->first();
        if (!$fromProduct) {
            return redirect()->route('home')->with('error', 'Invalid product selected');
        }
        
        // Ambil data produk To
        $toProduct = Product::where('product_code', $toProductCode)->first();
        if (!$toProduct) {
            return redirect()->route('home')->with('error', 'Invalid product selected');
        }
        
        // Cari exchange rate - menggunakan kolom product1 dan product2 (sesuai database)
        $exchange = Exchange::where('product1', $fromProductCode)
                            ->where('product2', $toProductCode)
                            ->first();
        
        // Ambil data blockchain From
        $fromBlockchainData = null;
        if ($fromBlockchainName) {
            $blockchain = Blockchain::where('product_name', $fromProduct->product_name)
                                    ->where('blockchain', $fromBlockchainName)
                                    ->first();
            if ($blockchain) {
                $fromBlockchainData = [
                    'name' => $blockchain->blockchain,
                    'img' => $blockchain->blockchain_img ? asset('img/blockchain/' . $blockchain->blockchain_img) : null,
                    'fee' => $blockchain->blockchain_fee
                ];
            }
        }
        
        // Ambil data blockchain To
        $toBlockchainData = null;
        if ($toBlockchainName) {
            $blockchain = Blockchain::where('product_name', $toProduct->product_name)
                                    ->where('blockchain', $toBlockchainName)
                                    ->first();
            if ($blockchain) {
                $toBlockchainData = [
                    'name' => $blockchain->blockchain,
                    'img' => $blockchain->blockchain_img ? asset('img/blockchain/' . $blockchain->blockchain_img) : null,
                    'fee' => $blockchain->blockchain_fee
                ];
            }
        }
        
        // ============================================= //
        // PERBAIKAN: Bersihkan nomor telepon untuk ditampilkan kembali //
        // ============================================= //
        $rawPhone = $tempData['full_phone'] ?? '';
        
        // Hapus double formatting seperti "+374 +37456777" menjadi "+37456777"
        if (preg_match('/^(\+\d+)\s\+\d+/', $rawPhone)) {
            $rawPhone = preg_replace('/^(\+\d+)\s\+\d+/', '$1', $rawPhone);
        }
        
        // Hapus spasi berlebih
        $rawPhone = preg_replace('/\s+/', '', $rawPhone);
        
        // Data customer yang sudah diisi sebelumnya
        $customerData = [
            'full_name' => $tempData['full_name'],
            'email' => $tempData['email'],
            'full_phone' => $rawPhone, // Gunakan nomor yang sudah dibersihkan
            'product2_dest' => $tempData['product2_dest']
        ];
        
        return view('transaction', [
            'amount' => $amount,
            'fromProduct' => [
                'code' => $fromProduct->product_code,
                'name' => $fromProduct->product_name,
                'img' => asset('img/product/' . $fromProduct->img),
                'category' => $fromProduct->category
            ],
            'toProduct' => [
                'code' => $toProduct->product_code,
                'name' => $toProduct->product_name,
                'img' => asset('img/product/' . $toProduct->img),
                'category' => $toProduct->category
            ],
            'fromBlockchain' => $fromBlockchainData,
            'toBlockchain' => $toBlockchainData,
            'rate' => $rate,
            'exchangeFee' => $exchange->fee ?? 0,
            'feeType' => $exchange->fee_type ?? 'percentage',
            'feeAmount' => $feeAmount,
            'feeText' => $feeText,
            'finalAmount' => $finalAmount,
            'minAmount' => $exchange->min ?? 0,
            'customer_data' => $customerData
        ]);
    }
}