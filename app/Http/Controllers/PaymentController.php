<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Blockchain;
use App\Models\PaymentMethod;
use App\Models\Payment;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    // Menampilkan halaman upload payment proof
    public function showUploadForm()
    {
        // Ambil data dari session
        $tempData = session('temp_transaction');
        
        if (!$tempData) {
            return redirect()->route('home')->with('error', 'No transaction data found. Please start over.');
        }
        
        // Ambil data produk dengan logo
        $product1 = Product::where('product_name', $tempData['from_product_name'])->first();
        $product2 = Product::where('product_name', $tempData['to_product_name'])->first();
        
        // Ambil data blockchain
        $blockchain1 = null;
        if ($tempData['from_blockchain']) {
            $blockchain1 = Blockchain::where('product_name', $tempData['from_product_name'])
                                    ->where('blockchain', $tempData['from_blockchain'])
                                    ->first();
        }
        
        $blockchain2 = null;
        if ($tempData['to_blockchain']) {
            $blockchain2 = Blockchain::where('product_name', $tempData['to_product_name'])
                                    ->where('blockchain', $tempData['to_blockchain'])
                                    ->first();
        }
        
        // Ambil payment method berdasarkan product_name dan blockchain (jika ada)
        $paymentMethod = null;
        
        if ($tempData['from_blockchain']) {
            // Jika ada blockchain, cari berdasarkan product_name dan blockchain
            $paymentMethod = PaymentMethod::where('product_name', $tempData['from_product_name'])
                                            ->where('pm_blockchain', $tempData['from_blockchain'])
                                            ->first();
        }
        
        // Jika tidak ketemu atau tidak ada blockchain, cari tanpa blockchain (untuk E-Money)
        if (!$paymentMethod) {
            $paymentMethod = PaymentMethod::where('product_name', $tempData['from_product_name'])->first();
        }
        
        // Tentukan apakah perlu menampilkan Account Name
        $showAccountName = false;
        
        if ($product1) {
            if ($product1->category !== 'Crypto') {
                // E-Money: tampilkan name
                $showAccountName = true;
            } elseif ($blockchain1 && $blockchain1->blockchain === 'Binance Pay ID') {
                // Crypto + Binance Pay ID: tampilkan name
                $showAccountName = true;
            }
            // Crypto + blockchain lain: $showAccountName tetap false
        }
        
        return view('upload-payment', [
            'tempData' => $tempData,
            'product1' => $product1,
            'product2' => $product2,
            'blockchain1' => $blockchain1,
            'blockchain2' => $blockchain2,
            'paymentMethod' => $paymentMethod,
            'showAccountName' => $showAccountName
        ]);
    }
    
    // Memproses upload payment proof dan menyimpan transaksi
    public function uploadPaymentProof(Request $request)
    {
        // Ambil data dari session
        $tempData = session('temp_transaction');
        
        if (!$tempData) {
            return redirect()->route('home')->with('error', 'No transaction data found. Please start over.');
        }
        
        // Validasi file harus gambar
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:10240'
        ], [
            'payment_proof.required' => 'Please select a payment proof file to upload.',
            'payment_proof.image' => 'The file must be an image (JPG, PNG, or JPEG).',
            'payment_proof.mimes' => 'The file must be a JPG, PNG, or JPEG image.',
            'payment_proof.max' => 'The file size must not exceed 10MB.'
        ]);
        
        // Generate transaction ID
        $transactionId = 'TRX-' . strtoupper(uniqid());
        
        // Buat folder jika belum ada
        $uploadPath = public_path('img/payment/src');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }
        
        // Upload file
        $filename = null;
        if ($request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');
            $filename = $transactionId . '_proof_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
        }
        
        // Simpan ke database menggunakan model Payment
        $payment = Payment::create([
            'trx_id' => $transactionId,
            'client_name' => $tempData['full_name'],
            'client_email' => $tempData['email'],
            'client_phonenumber' => $tempData['full_phone'],
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
            'product2_dest' => $tempData['product2_dest'],
            'product1_payment_proof' => $filename ? 'img/payment/src/' . $filename : null,
            'product2_payment_proof' => null
        ]);
        
        // KIRIM EMAIL KE PEMBELI DAN CC KE ADMIN
        try {
            $this->sendOrderEmail($payment, $tempData, $transactionId);
            
            // Log success
            \Log::info('Order email sent successfully to: ' . $tempData['email']);
        } catch (\Exception $e) {
            // Log error tapi tetap lanjutkan proses
            \Log::error('Failed to send order email: ' . $e->getMessage());
        }
        
        // Hapus session
        session()->forget('temp_transaction');
        
        // Redirect ke halaman confirmation
        return redirect()->route('payment.confirmation', $transactionId);
    }
    
    // Fungsi untuk mengirim email
    private function sendOrderEmail($payment, $tempData, $transactionId)
    {
        // Data untuk email
        $emailData = [
            'transaction_id' => $transactionId,
            'order' => $payment,
            'tempData' => $tempData,
            'order_date' => now()->format('d F Y H:i'),
            'amount_to_pay' => number_format($tempData['amount'], 2),
            'from_currency' => $tempData['from_product_name'],
            'to_currency' => $tempData['to_product_name'],
            'final_amount' => number_format($tempData['final_amount'], 2),
            'rate' => number_format($tempData['rate'], 2),
            'fee' => $tempData['fee_text'] ?? $tempData['fee'],
            'destination_wallet' => $tempData['product2_dest'] ?? '-',
            'customer_name' => $tempData['full_name'],
            'customer_email' => $tempData['email'],
            'customer_phone' => $tempData['full_phone'] ?? $tempData['phone'] ?? '-',
            'status' => 'Verification'
        ];
        
        // Kirim email ke PEMBELI (To)
        Mail::send('emails.order-confirmation', $emailData, function ($message) use ($emailData) {
            $message->to($emailData['customer_email'], $emailData['customer_name'])
                    ->cc('admin@exachanger.com') // CC ke admin
                    ->from(config('mail.from.address'), config('mail.from.name'))
                    ->subject('Order Confirmation - #' . $emailData['transaction_id'] . ' | Exachanger');
        });
    }
}