<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(5);
        return view('pages.products.index', compact('products'));
    }

    public function create()
    {
        return view('pages.products.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
            'price' => 'required|integer|min:0',
        ]);

        // Menyiapkan data untuk disimpan
        $data = $request->only(['name', 'description', 'price']);

        // Jika ada file gambar yang diunggah
        if ($request->hasFile('image')) {
            $fileName = time() . '.' . $request->image->extension();
            $path = $request->file('image')->storeAs('products', $fileName, 'public');
            $data['image'] = 'storage/' . $path;
        }

        // Simpan produk ke database
        Product::create($data);
        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }


    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        return view('pages.products.edit', compact('product'));
    }

    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);
        $data = $request->all();

        // Jika ada file gambar yang diunggah, simpan gambar baru
        if ($request->file('image')) {
            $fileName = time() . '.' . $request->image->extension();
            $path = $request->file('image')->storeAs('products', $fileName, 'public');
            $data['image'] = 'storage/' . $path;
        }

        $product->update($data); // Memperbarui data produk

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }
}
