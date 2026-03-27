<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    /**
     * Display a listing of products with inventory stats.
     */
    public function index(Request $request)
    {
        $query = Product::with('category')->latest();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhereHas('category', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  });
        }

        $products = $query->paginate(12);

        // Stats Calculation
        $allProducts = Product::all();
        $totalProducts = $allProducts->count();
        $stokTersedia = $allProducts->where('stock', '>', 50)->count(); // Arbitrary threshold for 'tersedia'
        $stokRendah = $allProducts->where('stock', '>', 0)->where('stock', '<=', 50)->count(); // Arbitrary threshold for 'rendah'
        $stokHabis = $allProducts->where('stock', 0)->count();

        // For the warning alert
        $lowStockProductsCount = $stokRendah;
        $outOfStockProductsCount = $stokHabis;

        return view('admin.products.index', compact(
            'products', 
            'totalProducts', 
            'stokTersedia', 
            'stokRendah', 
            'stokHabis',
            'lowStockProductsCount',
            'outOfStockProductsCount'
        ));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'image' => 'nullable|image|max:2048' // Assuming file uploads
        ]);

        $data = $request->except('image');
        $data['is_active'] = $request->has('is_active');
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'image' => 'nullable|image|max:2048'
        ]);

        $data = $request->except('image');
        $data['is_active'] = $request->has('is_active');
        if ($request->name !== $product->name) {
            $data['slug'] = Str::slug($request->name);
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
