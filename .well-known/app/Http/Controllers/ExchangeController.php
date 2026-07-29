<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exchange;
use App\Models\Product;

class ExchangeController extends Controller
{
    // Menampilkan semua data exchange
    public function index()
    {
        $exchanges = Exchange::all();
        return view('admin.exchange', compact('exchanges'));
    }

    // Menampilkan form tambah exchange
    public function create()
    {
        // Ambil data produk untuk dropdown product1 dan product2
        $products = Product::all();
        return view('admin.create_exchange', compact('products'));
    }

    // Menyimpan data exchange baru
    public function store(Request $request)
    {
        // Validasi data dengan maksimal 2 digit decimal
        $request->validate([
            'product1'   => 'required|string|max:10|different:product2',
            'product2'   => 'required|string|max:10|different:product1',
            'rate'       => ['required', 'numeric', 'min:0', 'regex:/^\d+(\.\d{1,2})?$/'],
            'fee_type'   => 'required|in:Percentage,Fiat',
            'fee'        => ['required', 'numeric', 'min:0', 'regex:/^\d+(\.\d{1,2})?$/'],
            'min'        => ['required', 'numeric', 'min:0', 'regex:/^\d+(\.\d{1,2})?$/'],
        ]);

        // Cari product_code berdasarkan product_name yang dipilih
        $product1 = Product::where('product_name', $request->product1)->first();
        $product2 = Product::where('product_name', $request->product2)->first();

        if (!$product1 || !$product2) {
            return redirect()->back()->withInput()->withErrors(['product1' => 'Product not found.']);
        }

        // Generate exc_code menggunakan product_code (bukan product_name)
        $exc_code = $product1->product_code . '-' . $product2->product_code;

        // Cek apakah kode sudah ada
        $exists = Exchange::where('exc_code', $exc_code)->exists();
        if ($exists) {
            return redirect()->back()->withInput()->withErrors(['product1' => 'Exchange rate for this product pair already exists.']);
        }

        // Simpan data ke database (product1 dan product2 tetap menggunakan nama produk)
        Exchange::create([
            'exc_code'   => $exc_code,
            'product1'   => $request->product1,
            'product2'   => $request->product2,
            'rate'       => $request->rate,
            'fee_type'   => $request->fee_type,
            'fee'        => $request->fee,
            'min'        => $request->min,
        ]);

        return redirect()->route('exchange.index')->with('success', 'Exchange rate successfully added.');
    }

    // Menampilkan form edit exchange
    public function edit($exc_code)
    {
        $exchange = Exchange::findOrFail($exc_code);
        $products = Product::all();
        return view('admin.edit_exchange', compact('exchange', 'products'));
    }

    // Mengupdate data exchange
    public function update(Request $request, $exc_code)
    {
        $exchange = Exchange::findOrFail($exc_code);

        // Validasi data (tanpa validasi product1 dan product2 karena tidak bisa diubah)
        $request->validate([
            'rate'       => ['required', 'numeric', 'min:0', 'regex:/^\d+(\.\d{1,2})?$/'],
            'fee_type'   => 'required|in:Percentage,Fiat',
            'fee'        => ['required', 'numeric', 'min:0', 'regex:/^\d+(\.\d{1,2})?$/'],
            'min'        => ['required', 'numeric', 'min:0', 'regex:/^\d+(\.\d{1,2})?$/'],
        ]);

        // Update data (tanpa mengubah product1, product2, dan exc_code)
        $exchange->update([
            'rate'       => $request->rate,
            'fee_type'   => $request->fee_type,
            'fee'        => $request->fee,
            'min'        => $request->min,
        ]);

        return redirect()->route('exchange.index')->with('success', 'Exchange rate successfully updated.');
    }

    // Menghapus data exchange
    public function destroy($exc_code)
    {
        $exchange = Exchange::findOrFail($exc_code);
        $exchange->delete();

        return redirect()->route('exchange.index')->with('success', 'Exchange rate successfully deleted.');
    }
}