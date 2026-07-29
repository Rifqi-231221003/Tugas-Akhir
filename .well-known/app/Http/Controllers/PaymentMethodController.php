<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Blockchain;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $paymentMethods = PaymentMethod::all();
        return view('admin.paymentmethod', compact('paymentMethods'));
    }

    public function create()
    {
        $products = Product::all();
        $blockchains = Blockchain::all();
        return view('admin.create_paymentmethod', compact('products', 'blockchains'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|exists:product,product_name',
            'pm_blockchain' => 'nullable|string',
            'type' => 'required|in:Address,Email,Number',
            'destination' => 'required|string',
            'name' => 'required|string'
        ]);

        // Validasi destination berdasarkan type
        if ($request->type == 'Email') {
            $request->validate([
                'destination' => 'email'
            ]);
        } elseif ($request->type == 'Number') {
            $request->validate([
                'destination' => 'numeric'
            ]);
        }

        // Cek category produk
        $product = Product::where('product_name', $request->product_name)->first();
        $isCrypto = ($product->category == 'Crypto');

        // Generate pm_code: product_name-blockchain (jika crypto) atau product_name (jika e-money)
        if ($isCrypto && $request->pm_blockchain) {
            $pm_code = $request->product_name . '-' . $request->pm_blockchain;
        } else {
            $pm_code = $request->product_name;
        }

        // Cek unique pm_code
        $existing = PaymentMethod::where('pm_code', $pm_code)->first();
        if ($existing) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Payment method code already exists!');
        }

        PaymentMethod::create([
            'pm_code' => $pm_code,
            'product_name' => $request->product_name,
            'pm_blockchain' => $request->pm_blockchain,
            'type' => $request->type,
            'destination' => $request->destination,
            'name' => $request->name
        ]);

        return redirect()->route('paymentmethod.index')
            ->with('success', 'Payment method created successfully.');
    }

    public function edit($pm_code)
    {
        $paymentMethod = PaymentMethod::findOrFail($pm_code);
        $products = Product::all();
        $blockchains = Blockchain::all();
        return view('admin.edit_paymentmethod', compact('paymentMethod', 'products', 'blockchains'));
    }

    public function update(Request $request, $pm_code)
    {
        $paymentMethod = PaymentMethod::findOrFail($pm_code);

        $request->validate([
            'destination' => 'required|string',
            'name' => 'required|string'
        ]);

        // Validasi destination berdasarkan type yang sudah ada
        if ($paymentMethod->type == 'Email') {
            $request->validate([
                'destination' => 'email'
            ]);
        } elseif ($paymentMethod->type == 'Number') {
            $request->validate([
                'destination' => 'numeric'
            ]);
        }

        // Update hanya destination dan name
        $paymentMethod->update([
            'destination' => $request->destination,
            'name' => $request->name
        ]);

        return redirect()->route('paymentmethod.index')
            ->with('success', 'Payment method updated successfully.');
    }

    public function destroy($pm_code)
    {
        $paymentMethod = PaymentMethod::findOrFail($pm_code);
        $paymentMethod->delete();

        return redirect()->route('paymentmethod.index')
            ->with('success', 'Payment method deleted successfully.');
    }
}