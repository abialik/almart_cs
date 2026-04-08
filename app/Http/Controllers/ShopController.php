<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HOME PAGE (Preview 8 Produk)
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        // Redirect Admin and Petugas to their respective dashboards
        if (auth()->check()) {
            if (auth()->user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif (auth()->user()->role === 'petugas') {
                return redirect()->route('petugas.dashboard');
            }
        }

        $products = $this->filterProducts($request)
            ->latest()
            ->paginate(15)
            ->withQueryString();

        // Ambil produk yang paling banyak terjual secara otomatis
        $bestSells = Product::active()
            ->withCount(['orderItems as sold_units' => function ($query) {
                $query->select(\DB::raw('SUM(qty)'));
            }])
            ->orderBy('sold_units', 'desc')
            ->take(10)
            ->get();

        $categories = Category::where('is_active', true)->get();

        return view('shop.home', compact('products', 'categories', 'bestSells'));
    }


    /*
    |--------------------------------------------------------------------------
    | ALL PRODUCTS PAGE (Pagination)
    |--------------------------------------------------------------------------
    */
    public function all(Request $request)
    {
        $products = $this->filterProducts($request)
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $categories = Category::where('is_active', true)->get();

        return view('shop.products', compact('products', 'categories'));
    }


    /*
    |--------------------------------------------------------------------------
    | PRODUCT DETAIL PAGE
    |--------------------------------------------------------------------------
    */
    public function show($slug)
    {
        $product = Product::with(['category', 'reviews.user'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Related products (1 kategori)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        return view('product.detail', compact('product', 'relatedProducts'));
    }


    /*
    |--------------------------------------------------------------------------
    | FILTER LOGIC (Reusable)
    |--------------------------------------------------------------------------
    */
    private function filterProducts(Request $request)
    {
        $query = Product::with('category')
            ->where('is_active', true);

        // Search by name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by category slug
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        return $query;
    }
}