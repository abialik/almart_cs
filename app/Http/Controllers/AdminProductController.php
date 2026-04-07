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

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhereHas('category', function($catQuery) use ($request) {
                      $catQuery->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        if ($request->filled('status')) {
            $status = $request->status;
            if ($status === 'tersedia') {
                $query->where('stock', '>', 50);
            } elseif ($status === 'rendah') {
                $query->where('stock', '>', 0)->where('stock', '<=', 50);
            } elseif ($status === 'habis') {
                $query->where('stock', 0);
            }
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
        if ($request->has('price')) {
            $request->merge([
                'price' => str_replace(['.', ','], '', $request->price)
            ]);
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:products,name',
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
            $file = $request->file('image');
            $filename = time() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/products'), $filename);
            $data['image'] = 'images/products/' . $filename;
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        if ($request->has('price')) {
            $request->merge([
                'price' => str_replace(['.', ','], '', $request->price)
            ]);
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:products,name,' . $product->id,
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
            $file = $request->file('image');
            $filename = time() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/products'), $filename);
            $data['image'] = 'images/products/' . $filename;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        // Cegah penghapusan jika produk sudah pernah dibeli
        if (\App\Models\OrderItem::where('product_id', $product->id)->exists()) {
            return redirect()->back()->with('error', 'Produk ini tidak bisa dihapus karena sudah tercatat dalam riwayat pesanan pelanggan. Silakan Edit dan Nonaktifkan status produk.');
        }

        // Hapus file gambar dari server
        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }

        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produk dan gambar berhasil dihapus.');
    }
}
