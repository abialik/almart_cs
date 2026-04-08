<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'is_active' => 'boolean'
        ]);

        Category::create([
            'name' => $request->name,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->back()->with('success', 'Kategori Berhasil Ditambahkan!');
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'is_active' => 'boolean'
        ]);

        $category->update([
            'name' => $request->name,
            'is_active' => $request->has('is_active'),
            'slug' => Str::slug($request->name)
        ]);

        return redirect()->back()->with('success', 'Kategori Berhasil Diperbarui!');
    }

    public function destroy(Category $category)
    {
        if ($category->products()->count() > 0) {
            return redirect()->back()->with('error', 'Kategori tidak dapat dihapus karena masih memiliki produk di dalamnya.');
        }

        $category->delete();
        return redirect()->back()->with('success', 'Kategori Berhasil Dihapus!');
    }
}
