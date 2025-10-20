<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['categories', 'colors'])->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $colors = Color::where('is_active', true)->orderBy('name')->get();
        return view('admin.products.create', compact('categories', 'colors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'colors' => 'nullable|array',
            'colors.*' => 'exists:colors,id',
        ]);

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $images[] = $path;
            }
        }

        $product = Product::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'images' => $images,
        ]);

        // Atașăm categoriile și culorile
        if (!empty($validated['categories'])) {
            $product->categories()->attach($validated['categories']);
        }
        if (!empty($validated['colors'])) {
            $product->colors()->attach($validated['colors']);
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully!');
    }

    public function show(Product $product)
    {
        $product->load(['categories', 'colors']);
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $product->load(['categories', 'colors']);
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $colors = Color::where('is_active', true)->orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'categories', 'colors'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'colors' => 'nullable|array',
            'colors.*' => 'exists:colors,id',
        ]);

        // Păstrăm imaginile existente
        $images = $product->images ?? [];

        // Adăugăm imagini noi dacă există
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $images[] = $path;
            }
        }

        $product->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'images' => $images,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        // Sincronizăm categoriile și culorile
        $product->categories()->sync($validated['categories'] ?? []);
        $product->colors()->sync($validated['colors'] ?? []);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        // Delete images from storage
        if ($product->images) {
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully!');
    }

    public function deleteImage(Request $request, Product $product)
    {
        $imageIndex = $request->input('image_index');
        $images = $product->images ?? [];

        if (isset($images[$imageIndex])) {
            Storage::disk('public')->delete($images[$imageIndex]);
            unset($images[$imageIndex]);
            $images = array_values($images);
            $product->update(['images' => $images]);
            
            return back()->with('success', 'Image deleted successfully!');
        }

        return back()->with('error', 'Image not found!');
    }
}