<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        // Verifică dacă user-ul este autentificat
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Trebuie să fii autentificat pentru a lăsa un review.');
        }

        // Verifică dacă user-ul a dat deja review la acest produs
        if (Auth::user()->hasReviewedProduct($product->id)) {
            return redirect()->back()->with('error', 'Ai dat deja un review pentru acest produs.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'is_approved' => true,
        ]);

        return redirect()->back()->with('success', 'Mulțumim pentru review! ⭐');
    }

    public function destroy(Review $review)
    {
        // Verifică dacă user-ul este proprietarul review-ului sau admin
        if (Auth::id() !== $review->user_id && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $review->delete();

        return redirect()->back()->with('success', 'Review-ul a fost șters.');
    }
}