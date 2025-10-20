<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::latest()->paginate(15);
        return view('admin.colors.index', compact('colors'));
    }

    public function create()
    {
        return view('admin.colors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'hex_code' => 'required|regex:/^#[0-9A-F]{6}$/i',
        ]);

        Color::create($validated);

        return redirect()->route('admin.colors.index')
            ->with('success', 'Color created successfully!');
    }

    public function edit(Color $color)
    {
        return view('admin.colors.edit', compact('color'));
    }

    public function update(Request $request, Color $color)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'hex_code' => 'required|regex:/^#[0-9A-F]{6}$/i',
        ]);

        $color->update([
            'name' => $validated['name'],
            'hex_code' => $validated['hex_code'],
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.colors.index')
            ->with('success', 'Color updated successfully!');
    }

    public function destroy(Color $color)
    {
        $color->delete();

        return redirect()->route('admin.colors.index')
            ->with('success', 'Color deleted successfully!');
    }
}