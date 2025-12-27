<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Wishlist;
use Livewire\Component;
use Livewire\Attributes\On;

class WishlistComponent extends Component
{
    public $isOpen = false;
    public $wishlistItems = [];
    public $wishlistCount = 0;

    public function mount()
    {
        $this->loadWishlist();
    }

    #[On('wishlist-updated')]
    public function loadWishlist()
    {
        if (auth()->check()) {
            // Pentru useri autentificați - din baza de date
            $this->wishlistItems = Wishlist::where('user_id', auth()->id())
                ->with('product.categories')
                ->get()
                ->map(function ($wishlist) {
                    $product = $wishlist->product;
                    
                    if (!$product) {
                        return null;
                    }
                    
                    $primaryCategory = $product->categories->first();
                    
                    return [
                        'id' => $product->id,
                        'title' => $product->title,
                        'slug' => $product->slug,
                        'category_slug' => $primaryCategory ? $primaryCategory->slug : 'uncategorized',
                        'price' => $product->price,
                        'final_price' => $product->final_price,
                        'has_discount' => $product->hasDiscount(),
                        'discount_percentage' => $product->discount_percentage,
                        'image' => $product->first_image,
                        'stock' => $product->stock,
                        'is_active' => $product->is_active,
                    ];
                })
                ->filter()
                ->toArray();
        } else {
            // Pentru guest users - din sesiune
            $wishlistIds = session()->get('wishlist', []);
            $this->wishlistItems = Product::with('categories')
                ->whereIn('id', $wishlistIds)
                ->get()
                ->map(function ($product) {
                    $primaryCategory = $product->categories->first();
                    
                    return [
                        'id' => $product->id,
                        'title' => $product->title,
                        'slug' => $product->slug,
                        'category_slug' => $primaryCategory ? $primaryCategory->slug : 'uncategorized',
                        'price' => $product->price,
                        'final_price' => $product->final_price,
                        'has_discount' => $product->hasDiscount(),
                        'discount_percentage' => $product->discount_percentage,
                        'image' => $product->first_image,
                        'stock' => $product->stock,
                        'is_active' => $product->is_active,
                    ];
                })
                ->toArray();
        }

        $this->wishlistCount = count($this->wishlistItems);
    }

    #[On('wishlist-toggle')]
    public function toggleWishlist($productId)
    {
        $product = Product::find($productId);
        
        if (!$product) {
            $this->dispatch('notification', [
                'type' => 'error',
                'message' => 'Product not found'
            ]);
            return;
        }

        if (auth()->check()) {
            // Pentru useri autentificați
            $wishlistItem = Wishlist::where('user_id', auth()->id())
                ->where('product_id', $productId)
                ->first();

            if ($wishlistItem) {
                // Șterge din wishlist
                $wishlistItem->delete();
                $this->dispatch('notification', [
                    'type' => 'success',
                    'message' => 'Removed from wishlist!'
                ]);
            } else {
                // Adaugă în wishlist
                Wishlist::create([
                    'user_id' => auth()->id(),
                    'product_id' => $productId,
                ]);
                $this->dispatch('notification', [
                    'type' => 'success',
                    'message' => 'Added to wishlist!'
                ]);
                $this->isOpen = true;
            }
        } else {
            // Pentru guest users - folosim sesiunea
            $wishlist = session()->get('wishlist', []);
            
            if (in_array($productId, $wishlist)) {
                // Șterge din wishlist
                $wishlist = array_diff($wishlist, [$productId]);
                $this->dispatch('notification', [
                    'type' => 'success',
                    'message' => 'Removed from wishlist!'
                ]);
            } else {
                // Adaugă în wishlist
                $wishlist[] = $productId;
                $this->dispatch('notification', [
                    'type' => 'success',
                    'message' => 'Added to wishlist!'
                ]);
                $this->isOpen = true;
            }
            
            session()->put('wishlist', array_values($wishlist));
        }

        $this->loadWishlist();
        $this->dispatch('wishlist-icon-updated');
    }

    public function removeFromWishlist($productId)
    {
        if (auth()->check()) {
            Wishlist::where('user_id', auth()->id())
                ->where('product_id', $productId)
                ->delete();
        } else {
            $wishlist = session()->get('wishlist', []);
            $wishlist = array_diff($wishlist, [$productId]);
            session()->put('wishlist', array_values($wishlist));
        }

        $this->loadWishlist();
        $this->dispatch('wishlist-icon-updated');
        
        $this->dispatch('notification', [
            'type' => 'success',
            'message' => 'Removed from wishlist!'
        ]);
    }

    public function moveToCart($productId)
    {
        $this->dispatch('cart-add-item', productId: $productId, quantity: 1);
        $this->removeFromWishlist($productId);
        
        $this->dispatch('notification', [
            'type' => 'success',
            'message' => 'Moved to cart!'
        ]);
    }

    public function clearWishlist()
    {
        if (auth()->check()) {
            Wishlist::where('user_id', auth()->id())->delete();
        } else {
            session()->forget('wishlist');
        }

        $this->loadWishlist();
        $this->dispatch('wishlist-icon-updated');
        
        $this->dispatch('notification', [
            'type' => 'success',
            'message' => 'Wishlist cleared!'
        ]);
    }

    public function togglePanel()
    {
        $this->isOpen = !$this->isOpen;
    }

    public function render()
    {
        return view('livewire.wishlist-component');
    }
}