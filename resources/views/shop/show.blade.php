<x-guest-layout>
    <div class="py-8 bg-gradient-to-b from-pink-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="mb-6 text-sm">
                <ol class="flex items-center space-x-2 text-gray-600">
                    <li><a href="{{ route('shop') }}" class="hover:text-primary font-medium transition">Magazin</a></li>
                    @if(isset($category))
                        <li><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
                        <li><a href="{{ route('shop.category', $category->slug) }}" class="hover:text-primary font-medium transition">{{ $category->name }}</a></li>
                    @endif
                    <li><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
                    <li class="font-bold text-primary">{{ $product->title }}</li>
                </ol>
            </nav>

            <div class="mb-6">
                <a href="{{ isset($category) ? route('shop.category', $category->slug) : route('shop') }}" 
                   class="text-primary hover:text-primary-dark inline-flex items-center font-semibold transition text-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to {{ isset($category) ? $category->name : 'Shop' }}
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-6 lg:p-8">
                    <!-- Images Section -->
                    <div x-data="{ currentImage: 0, images: {{ json_encode($product->images ?? []) }} }">
                        @if($product->images && count($product->images) > 0)
                            <div class="relative">
                                <div class="bg-gray-100 rounded-xl overflow-hidden mb-4 shadow-md" style="height: 500px;">
                                    <template x-for="(image, index) in images" :key="index">
                                        <img :src="`/storage/${image}`" 
                                            x-show="currentImage === index"
                                            :alt="`{{ $product->title }} - Image ${index + 1}`"
                                            class="w-full h-full object-cover">
                                    </template>
                                </div>
                                
                                @if(count($product->images) > 1)
                                    <div class="grid grid-cols-4 gap-2">
                                        @foreach($product->images as $index => $image)
                                            <button @click="currentImage = {{ $index }}"
                                                    :class="currentImage === {{ $index }} ? 'ring-2 ring-primary' : 'ring-1 ring-gray-200'"
                                                    class="rounded-lg overflow-hidden hover:ring-2 hover:ring-primary transition shadow-sm" style="height: 80px;">
                                                <img src="{{ asset('storage/' . $image) }}" 
                                                    alt="Thumbnail {{ $index + 1 }}"
                                                    class="w-full h-full object-cover">
                                            </button>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="bg-gradient-to-br from-pink-100 to-purple-100 rounded-xl flex items-center justify-center shadow-md" style="height: 500px;">
                                <svg class="w-32 h-32 text-primary opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Product Info Section -->
                    <div x-data="{ quantity: 1 }" class="flex flex-col">
                        <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-4">{{ $product->title }}</h1>
                        
                        <!-- Categories -->
                       @if($product->categories->count() > 0)
                        <div class="flex flex-wrap gap-2 mb-4">
                            @foreach($product->categories as $cat)
                                <span class="inline-flex items-center px-3 py-1.5 bg-pink-50 text-primary rounded-full text-xs font-semibold shadow-sm">
                                    <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    {{ $cat->name }}
                                </span>
                            @endforeach
                        </div>
                    @endif

                        <!-- Colors -->
                        @if($product->colors->count() > 0)
                            <div class="mb-6">
                                <h3 class="text-sm font-bold text-gray-800 mb-3">Culori disponibile:</h3>
                                <div class="flex flex-wrap gap-3">
                                    @foreach($product->colors as $color)
                                        <div class="flex items-center gap-2 bg-gray-50 px-3 py-2 rounded-lg border border-gray-200">
                                            <div class="w-6 h-6 rounded-full border-2 border-gray-300 shadow-sm" 
                                                 style="background-color: {{ $color->hex_code }}"
                                                 title="{{ $color->name }}">
                                            </div>
                                            <span class="font-semibold text-gray-800 text-sm">{{ $color->name }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Dimensions -->
                        @if($product->dimensions)
                            <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-lg p-4 mb-6 border border-blue-100 shadow-sm">
                                <h3 class="text-sm font-bold text-gray-800 mb-2 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                                    </svg>
                                    Dimensiuni produs:
                                </h3>
                                <p class="text-lg font-bold text-gray-900">{{ $product->dimensions }}</p>
                            </div>
                        @endif
                        
                        <div class="flex items-center gap-4 mb-6">
                            @if($product->hasDiscount())
                                <div class="flex flex-col">
                                    <span class="text-md line-through text-gray-400">
                                        RON {{ number_format($product->price, 2) }}
                                    </span>
                                    <span class="text-xl font-bold text-red-600">
                                        RON {{ number_format($product->final_price, 2) }}
                                    </span>
                                </div>
                                <span class="px-4 py-2 bg-red-100 text-red-800 rounded-full font-bold text-sm shadow-sm">
                                    Save {{ $product->discount_percentage }}%
                                </span>
                            @else
                                <span class="text-3xl font-bold text-primary">
                                    RON {{ number_format($product->price, 2) }}
                                </span>
                            @endif
                            <span class="px-3 py-1.5 text-xs font-bold rounded-full shadow-sm
                                {{ $product->stock > 10 ? 'bg-green-100 text-green-800' : ($product->stock > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                @if($product->stock > 10)
                                    ✓ În stoc ({{ $product->stock }})
                                @elseif($product->stock > 0)
                                    ⚠ Doar {{ $product->stock }} rămase
                                @else
                                    ✕ Stoc epuizat
                                @endif
                            </span>
                        </div>

                        <div class="mb-6 pb-6 border-b border-gray-200">
                            <h3 class="text-base font-bold text-gray-900 mb-3">Descriere</h3>
                            <p class="text-gray-600 leading-relaxed text-sm">{{ $product->description }}</p>
                        </div>

                       @if($product->stock > 0)
                        <div class="flex gap-3 mb-6">
                            <div class="flex items-center border-2 border-gray-300 rounded-lg shadow-sm bg-white">
                                <button @click="quantity = Math.max(1, quantity - 1)" 
                                        class="px-4 py-2 hover:bg-gray-100 transition">
                                    <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M20 12H4"></path>
                                    </svg>
                                </button>
                                <input type="number" 
                                    x-model="quantity" 
                                    min="1" 
                                    :max="{{ $product->stock }}"
                                    class="w-16 text-center text-base font-bold border-0 focus:ring-0">
                                <button @click="quantity = Math.min({{ $product->stock }}, quantity + 1)" 
                                        class="px-4 py-2 hover:bg-gray-100 transition">
                                    <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </button>
                            </div>
                            <button @click="addToCart({{ $product->id }}, quantity)" 
                                    class="flex-1 bg-primary hover:bg-primary-dark text-white px-6 py-3 rounded-lg font-bold text-sm transition transform hover:scale-105 flex items-center justify-center shadow-md">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                Adaugă în coș
                            </button>
                        </div>
                        
                        <!-- Wishlist Button -->
                        <div class="mb-6">
                            <button onclick="toggleWishlist({{ $product->id }})"
                                    class="w-full border-2 border-pink-600 text-pink-600 hover:bg-pink-50 px-6 py-3 rounded-lg font-bold text-sm transition flex items-center justify-center shadow-md">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                                Adaugă la lista de dorințe
                            </button>
                        </div>
                    @else
                        <div class="bg-red-50 border-2 border-red-200 rounded-lg p-4 mb-6 shadow-sm">
                            <p class="text-red-800 font-bold text-sm">⚠ Acest produs este în prezent epuizat</p>
                        </div>
                        
                        <!-- Wishlist Button for Out of Stock -->
                        <div class="mb-6">
                            <button onclick="toggleWishlist({{ $product->id }})"
                                    class="w-full border-2 border-pink-600 text-pink-600 hover:bg-pink-50 px-6 py-3 rounded-lg font-bold text-sm transition flex items-center justify-center shadow-md">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                                Adaugă la lista de dorințe
                            </button>
                        </div>
                    @endif

                        <!-- Product Meta -->
                        <div class="border-t border-gray-200 pt-6 space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600 font-medium">SKU:</span>
                                <span class="font-bold text-gray-900">{{ $product->id }}</span>
                            </div>
                            @if($product->categories->count() > 0)
                                <div class="flex justify-between">
                                    <span class="text-gray-600 font-medium">Categorii:</span>
                                    <span class="font-bold text-gray-900">{{ $product->categories->pluck('name')->join(', ') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 p-6 lg:p-8">
        
        <!-- Rating Summary -->
        <div class="border-b border-gray-200 pb-6 mb-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Recenzii clienți</h2>
            
            @if($product->reviews_count > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Overall Rating -->
                    <div class="flex items-center gap-4">
                        <div class="text-center">
                            <div class="text-5xl font-bold text-primary">{{ $product->average_rating }}</div>
                            <div class="flex justify-center mt-2">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($product->average_rating))
                                        <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                    @elseif($i - 0.5 <= $product->average_rating)
                                        <svg class="w-5 h-5 text-yellow-400" viewBox="0 0 20 20">
                                            <defs>
                                                <linearGradient id="half-{{ $product->id }}">
                                                    <stop offset="50%" stop-color="#FBBF24"/>
                                                    <stop offset="50%" stop-color="#D1D5DB"/>
                                                </linearGradient>
                                            </defs>
                                            <path fill="url(#half-{{ $product->id }})" d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-gray-300 fill-current" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                            <div class="text-sm text-gray-600 mt-1">{{ $product->reviews_count }} {{ $product->reviews_count == 1 ? 'review' : 'reviews' }}</div>
                        </div>
                    </div>
                    
                    <!-- Rating Distribution -->
                    <div class="space-y-2">
                        @foreach(range(5, 1) as $stars)
                            @php
                                $count = $product->rating_distribution[$stars] ?? 0;
                                $percentage = $product->reviews_count > 0 ? ($count / $product->reviews_count) * 100 : 0;
                            @endphp
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-medium text-gray-700 w-16">{{ $stars }} stars</span>
                                <div class="flex-1 bg-gray-200 rounded-full h-3">
                                    <div class="bg-yellow-400 h-3 rounded-full transition-all" style="width: {{ $percentage }}%"></div>
                                </div>
                                <span class="text-sm text-gray-600 w-8">{{ $count }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                    <p class="text-gray-600 font-medium">Nicio recenzie încă. Fii primul care scrie o recenzie pentru acest produs!</p>
                </div>
            @endif
        </div>

        <!-- Add Review Form -->
        @auth
            @if(!isset($userReview))
                <div class="mb-8 bg-gradient-to-r from-pink-50 to-purple-50 rounded-lg p-6 border border-pink-100">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Scrie o recenzie</h3>
                    
                    <form action="{{ route('reviews.store', $product) }}" method="POST" x-data="{ rating: 0 }">
                        @csrf
                        
                        <!-- Star Rating -->
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Evaluarea ta *</label>
                            <div class="flex gap-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button" 
                                            @click="rating = {{ $i }}"
                                            class="focus:outline-none transition-transform hover:scale-110">
                                        <svg :class="rating >= {{ $i }} ? 'text-yellow-400' : 'text-gray-300'" 
                                             class="w-8 h-8 fill-current" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                    </button>
                                @endfor
                            </div>
                            <input type="hidden" name="rating" x-model="rating" required>
                            @error('rating')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Comment -->
                        <div class="mb-4">
                            <label for="comment" class="block text-sm font-bold text-gray-700 mb-2">Recenzia ta</label>
                            <textarea name="comment" 
                                      id="comment" 
                                      rows="4" 
                                      class="w-full border-2 border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-primary"
                                      placeholder="Împărtășește-ți experiența cu acest produs...">{{ old('comment') }}</textarea>
                            @error('comment')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <button type="submit" 
                                x-bind:disabled="rating === 0"
                                :class="rating === 0 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-primary-dark'"
                                class="bg-primary text-white px-6 py-3 rounded-lg font-bold transition shadow-md">
                            Trimite recenzia
                        </button>
                    </form>
                </div>
            @else
                <div class="mb-8 bg-green-50 border border-green-200 rounded-lg p-4">
                    <p class="text-green-800 font-medium flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        Mulțumim! Ai deja o recenzie pentru acest produs.
                    </p>
                </div>
            @endif
        @else
            <div class="mb-8 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <p class="text-blue-800 font-medium">
                    <a href="{{ route('login') }}" class="underline font-bold hover:text-blue-900">Autentificare</a> 
                    sau 
                    <a href="{{ route('register') }}" class="underline font-bold hover:text-blue-900">creează un cont</a> 
                    pentru a lăsa o recenzie.
                </p>
            </div>
        @endauth

        <!-- Reviews List -->
        @if($product->approvedReviews->count() > 0)
            <div class="space-y-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Toate recenziile ({{ $product->reviews_count }})</h3>
                
                @foreach($product->approvedReviews()->with('user')->latest()->get() as $review)
                    <div class="border-b border-gray-200 pb-6 last:border-b-0">
                        <div class="flex items-start justify-between mb-3">
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="font-bold text-gray-900">{{ $review->user->name }}</span>
                                    @if(Auth::check() && Auth::id() === $review->user_id)
                                        <span class="text-xs bg-blue-100 text-blue-800 px-2 py-0.5 rounded-full">Your Review</span>
                                    @endif
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="flex">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }} fill-current" viewBox="0 0 20 20">
                                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                    <span class="text-sm text-gray-500">{{ $review->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                            
                            @if(Auth::check() && (Auth::id() === $review->user_id || Auth::user()->isAdmin()))
                                <form action="{{ route('reviews.destroy', $review) }}" method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this review?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                        Șterge
                                    </button>
                                </form>
                            @endif
                        </div>
                        
                        @if($review->comment)
                            <p class="text-gray-700 leading-relaxed">{{ $review->comment }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

    <script>
        function addToCart(productId, quantity) {
            Livewire.dispatch('cart-add-item', { productId: productId, quantity: quantity });
        }

         function toggleWishlist(productId) {
            Livewire.dispatch('wishlist-toggle', { productId: productId });
        }
    </script>
</x-guest-layout>