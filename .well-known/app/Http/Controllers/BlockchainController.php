<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blockchain;
use App\Models\Product;

class BlockchainController extends Controller
{
    public function index()
    {
        $blockchains = Blockchain::all();
        return view('admin.blockchain', compact('blockchains'));
    }

    public function create()
    {
        $products = Product::where('category', 'Crypto')
                          ->where('status', 'Active')
                          ->orderBy('product_name')
                          ->get();
        return view('admin.create_blockchain', compact('products'));
    }

    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'product_name' => 'required|string|exists:product,product_name',
            'blockchain' => 'required|string|max:20',
            'blockchain_fee' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,2})?$/',
            'blockchain_img' => 'required|image'
        ]);

        // Generate blockchain_code: product_name-blockchain
        $blockchain_code = $request->product_name . '-' . $request->blockchain;

        // Cek apakah blockchain_code sudah ada
        $existing = Blockchain::where('blockchain_code', $blockchain_code)->first();
        if ($existing) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Blockchain code already exists!');
        }

        // Proses upload gambar - nama file sesuai dengan blockchain
        $imageName = null;
        if ($request->hasFile('blockchain_img')) {
            $file = $request->file('blockchain_img');
            // Ambil ekstensi file
            $extension = $file->getClientOriginalExtension();
            // Gunakan nama blockchain sebagai nama file (akan replace jika update nanti)
            $filename = $request->blockchain . '.' . $extension;
            // Pindahkan file (akan overwrite jika sudah ada)
            $file->move(public_path('img/blockchain'), $filename);
            // Simpan hanya nama file ke database
            $imageName = $filename;
        }

        // Simpan data ke database
        Blockchain::create([
            'blockchain_code' => $blockchain_code,
            'product_name' => $request->product_name,
            'blockchain' => $request->blockchain,
            'blockchain_fee' => $request->blockchain_fee,
            'blockchain_img' => $imageName,
        ]);

        return redirect()->route('blockchain.index')
            ->with('success', 'Blockchain created successfully.');
    }

    public function edit($blockchain_code)
    {
        $blockchain = Blockchain::findOrFail($blockchain_code);
        return view('admin.edit_blockchain', compact('blockchain'));
    }

    public function update(Request $request, $blockchain_code)
    {
        $blockchain = Blockchain::findOrFail($blockchain_code);

        // Validasi hanya untuk fee
        $request->validate([
            'blockchain_fee' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,2})?$/',
        ]);

        // Update hanya blockchain_fee
        $blockchain->update([
            'blockchain_fee' => $request->blockchain_fee,
        ]);

        return redirect()->route('blockchain.index')
            ->with('success', 'Blockchain fee updated successfully.');
    }

    public function destroy($blockchain_code)
    {
        $blockchain = Blockchain::findOrFail($blockchain_code);
        
        // Hapus file gambar dari folder
        $imagePath = public_path('img/blockchain/' . $blockchain->blockchain_img);
        if (file_exists($imagePath) && $blockchain->blockchain_img) {
            unlink($imagePath);
        }

        // Hapus data dari database
        $blockchain->delete();

        return redirect()->route('blockchain.index')
            ->with('success', 'Blockchain deleted successfully.');
    }
}