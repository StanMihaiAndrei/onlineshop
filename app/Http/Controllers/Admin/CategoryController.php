<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // Obține toate categoriile principale cu subcategoriile lor
        $categories = Category::with(['allChildren' => function($query) {
                $query->withCount('products');
            }])
            ->withCount('products')
            ->whereNull('parent_id')
            ->latest()
            ->paginate(15);
        
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        // Obține doar categoriile principale pentru dropdown
        $parentCategories = Category::whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
        
        return view('admin.categories.create', compact('parentCategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully!');
    }

    public function edit(Category $category)
    {
        // Obține doar categoriile principale, excluzând categoria curentă și subcategoriile ei
        $parentCategories = Category::whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
        
        return view('admin.categories.edit', compact('category', 'parentCategories'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        // Verifică că nu setăm categoria ca părinte al ei însăși
        if ($validated['parent_id'] == $category->id) {
            return back()->withErrors(['parent_id' => 'A category cannot be its own parent.']);
        }

        // Verifică că nu setăm o subcategorie a categoriei curente ca părinte
        if ($validated['parent_id'] && $category->allChildren->contains('id', $validated['parent_id'])) {
            return back()->withErrors(['parent_id' => 'Cannot set a subcategory as parent.']);
        }

        $category->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'parent_id' => $validated['parent_id'],
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        // Verifică dacă categoria are subcategorii
        if ($category->allChildren()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->withErrors(['error' => 'Cannot delete category with subcategories. Delete subcategories first.']);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully!');
    }
}