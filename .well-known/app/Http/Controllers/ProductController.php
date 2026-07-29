<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index() {
        $product=Product::all();
        return view('admin.dashboard', compact('product'));
    }

    public function create() {
        return view('admin.create_product');
    }

    // Menyimpan data baru
    public function store(Request $request) {
        // Validasi data
        $request->validate([
            'product_code' => 'required|string|max:5|unique:product,product_code',
            'product_name' => 'required|string|max:10',
            'category' => 'required|string|max:10',
            'status' => 'required|string|max:10',
            'img' => 'required|image',
        ]);

            // Proses upload gambar ke /public/img/product
        if ($request->hasFile('img')) {
        $file = $request->file('img');
        
        // Ambil ekstensi file
        $extension = $file->getClientOriginalExtension();
        
        // Gunakan kode produk sebagai nama file (akan replace jika update nanti)
        $filename = $request->product_name . '.' . $extension;
        
        // Pindahkan file (akan overwrite jika sudah ada)
        $file->move(public_path('img/product'), $filename);
        
        // Simpan hanya nama file ke database
        $imageName = $filename;
        }

        // Simpan data ke database
        Product::create([
            'product_code' => $request->product_code,
            'product_name' => $request->product_name,
            'category' => $request->category,
            'status' => $request->status,
            'img' => $imageName,
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('product.dashboard')->with('success', 'You have successfully added the product.');
    }

    // Method untuk menampilkan form edit
    public function edit($product_code)
    {
        $product = Product::findOrFail($product_code);
        return view('admin.edit_product', compact('product'));
    }

    // Method untuk update data
    public function update(Request $request, $product_code)
    {
        $product = Product::findOrFail($product_code);

        // Validasi data
        $request->validate([
            'product_name' => 'required|string|max:10',
            'category'     => 'required|string|max:10',
            'status'       => 'required|string|max:10',
            'img'          => 'nullable|image', // image tidak wajib saat update
        ]);

        // Update gambar jika ada upload baru
        if ($request->hasFile('img')) {
            // Hapus gambar lama jika ada
            $oldImagePath = public_path('img/product/' . $product->img);
            if (file_exists($oldImagePath) && $product->img) {
                unlink($oldImagePath);
            }

            // Upload gambar baru
            $file = $request->file('img');
            $extension = $file->getClientOriginalExtension();
            $filename = $product->product_code . '.' . $extension;
            $file->move(public_path('img/product'), $filename);
            $product->img = $filename;
        }

        // Update data produk
        $product->update([
            'product_name' => $request->product_name,
            'category'     => $request->category,
            'status'       => $request->status,
            'img'          => $product->img ?? $product->img,
        ]);

        return redirect()->route('product.dashboard')->with('success', 'Product successfully updated.');
    }

    // Method untuk menghapus data
    public function destroy($product_code)
    {
        $product = Product::findOrFail($product_code);

        // Hapus file gambar dari folder
        $imagePath = public_path('img/product/' . $product->img);
        if (file_exists($imagePath) && $product->img) {
            unlink($imagePath);
        }

        // Hapus data dari database
        $product->delete();

        return redirect()->route('product.dashboard')->with('success', 'Product successfully deleted.');
    }
}
