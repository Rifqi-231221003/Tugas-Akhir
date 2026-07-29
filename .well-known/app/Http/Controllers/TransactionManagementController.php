<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\Storage;

class TransactionManagementController extends Controller
{
    // Menampilkan semua data transaction
    public function index()
    {
        $transactions = Payment::all();
        return view('admin.transactionmanagement', compact('transactions'));
    }

    // Menampilkan detail transaction
    public function show($trx_id)
    {
        $transaction = Payment::findOrFail($trx_id);
        return view('admin.detail_transaction', compact('transaction'));
    }

    // Menghapus data transaction
    public function destroy($trx_id)
    {
        $transaction = Payment::findOrFail($trx_id);
        $transaction->delete();

        return redirect()->route('transactionmanagement.index')->with('success', 'Transaction successfully deleted.');
    }

    // Upload bukti pemenuhan pesanan
    public function uploadProof(Request $request, $trx_id)
    {
        $request->validate([
            'fulfillment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $transaction = Payment::findOrFail($trx_id);
        
        // Hapus file lama jika ada
        if ($transaction->product2_payment_proof) {
            $oldFile = public_path($transaction->product2_payment_proof);
            if (file_exists($oldFile)) {
                unlink($oldFile);
            }
        }

        // Upload file baru
        $file = $request->file('fulfillment_proof');
        $filename = 'TRX-' . $trx_id . '_fulfillment_' . time() . '.' . $file->getClientOriginalExtension();
        $path = 'img/payment/fulfillment/' . $filename;
        $file->move(public_path('img/payment/fulfillment'), $filename);

        // Update database
        $transaction->product2_payment_proof = $path;
        $transaction->save();

        return redirect()->route('transactionmanagement.show', $trx_id)->with('success', 'Fulfillment proof uploaded successfully.');
    }

    // Menolak transaksi
    public function reject($trx_id)
    {
        $transaction = Payment::findOrFail($trx_id);
        $transaction->trx_status = 'Rejected';
        $transaction->save();

        return redirect()->route('transactionmanagement.index')->with('success', 'Transaction has been rejected.');
    }

    // Mengkonfirmasi transaksi menjadi Success
    public function confirm($trx_id)
    {
        $transaction = Payment::findOrFail($trx_id);
        
        // Cek apakah sudah upload bukti pemenuhan
        if (!$transaction->product2_payment_proof) {
            return redirect()->route('transactionmanagement.show', $trx_id)
                ->with('error', 'Please upload fulfillment proof first before confirming.');
        }

        $transaction->trx_status = 'Success';
        $transaction->save();

        return redirect()->route('transactionmanagement.index')->with('success', 'Transaction has been confirmed as SUCCESS.');
    }
}