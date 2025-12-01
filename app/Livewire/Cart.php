<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\On;

class Cart extends Component
{
    public $isOpen = false;
    public $cartItems = [];
    public $cartCount = 0;
    public $cartTotal = 0;

    public function mount()
    {
        $this->loadCart();
    }

    #[On('cart-updated')]
    public function loadCart()
    {
        $this->cartItems = session()->get('cart', []);
        $this->cartCount = array_sum(array_column($this->cartItems, 'quantity'));
        $this->cartTotal = collect($this->cartItems)->sum(function ($item) {
            return $item['final_price'] * $item['quantity'];
        });
    }

    #[On('cart-add-item')]
    public function addToCart($productId, $quantity = 1)
    {
        $product = Product::with('categories')->find($productId);
        
        if (!$product || !$product->is_active || $product->stock < $quantity) {
            $this->dispatch('notification', [
                'type' => 'error',
                'message' => 'Product not available'
            ]);
            return;
        }

        $cart = session()->get('cart', []);
        
        // Găsim prima categorie sau folosim 'uncategorized'
        $primaryCategory = $product->categories->first();
        $categorySlug = $primaryCategory ? $primaryCategory->slug : 'uncategorized';
        
        if (isset($cart[$productId])) {
            $newQuantity = $cart[$productId]['quantity'] + $quantity;
            if ($newQuantity > $product->stock) {
                $this->dispatch('notification', [
                    'type' => 'error',
                    'message' => 'Not enough stock available'
                ]);
                return;
            }
            $cart[$productId]['quantity'] = $newQuantity;
        } else {
            $cart[$productId] = [
                'id' => $product->id,
                'title' => $product->title,
                'slug' => $product->slug,
                'category_slug' => $categorySlug,
                'price' => $product->price,
                'final_price' => $product->final_price,
                'has_discount' => $product->hasDiscount(),
                'discount_percentage' => $product->discount_percentage,
                'quantity' => $quantity,
                'image' => $product->first_image,
                'stock' => $product->stock
            ];
        }

        session()->put('cart', $cart);
        $this->loadCart();
        $this->isOpen = true;
        
        $this->dispatch('notification', [
            'type' => 'success',
            'message' => 'Product added to cart!'
        ]);
    }

    public function updateQuantity($productId, $quantity)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$productId])) {
            if ($quantity <= 0) {
                unset($cart[$productId]);
            } elseif ($quantity > $cart[$productId]['stock']) {
                $this->dispatch('notification', [
                    'type' => 'error',
                    'message' => 'Not enough stock available'
                ]);
                return;
            } else {
                $cart[$productId]['quantity'] = $quantity;
            }
            
            session()->put('cart', $cart);
            $this->loadCart();
        }
    }

    public function removeFromCart($productId)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
            $this->loadCart();
            
            $this->dispatch('notification', [
                'type' => 'success',
                'message' => 'Product removed from cart'
            ]);
        }
    }

    public function clearCart()
    {
        session()->forget('cart');
        $this->loadCart();
        $this->isOpen = false;
        
        $this->dispatch('notification', [
            'type' => 'success',
            'message' => 'Cart cleared'
        ]);
    }

    public function toggleCart()
    {
        $this->isOpen = !$this->isOpen;
    }

    public function render()
    {
        return view('livewire.cart');
    }
}