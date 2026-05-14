@php
    $cart = $cart ?? \App\Models\Cart::where('product_id', $product->id)
        ->when(Auth::check(), fn($q) => $q->where('user_id', Auth::id()))
        ->when(!Auth::check(), fn($q) => $q->where('session_id', session('session_id')))
        ->first();
@endphp

<div class="cart-action-wrapper" 
    data-product="{{ $product->id }}"
    @if($cart) data-cart="{{ $cart->id }}" @endif>
    
    @if($cart)
        <!-- UI when item is already in cart: [ - Qty + ] [ Add ] -->
        <div class="d-flex align-items-center gap-2">
            <div class="d-flex align-items-center border rounded-pill overflow-hidden bg-light" style="height: 38px; border-color: #A45517 !important;">
                
                <button type="button" 
                    class="btn btn-sm px-2 py-0 border-0 updateCartItem minus" 
                    data-url="{{ route('cartUpdateQty') }}"
                    data-cart="{{ $cart->id }}"
                    data-qty="{{ $cart->quantity }}">−</button>

                <span class="fw-semibold px-2 cartQtyDisplay text-dark" style="min-width: 25px; text-align: center;">{{ $cart->quantity }}</span>

                <button type="button" 
                    class="btn btn-sm px-2 py-0 border-0 updateCartItem plus"
                    data-url="{{ route('cartUpdateQty') }}"
                    data-cart="{{ $cart->id }}"
                    data-qty="{{ $cart->quantity }}">+</button>
            </div>
            
            <button
                class="btn btn-primary btn-sm rounded-pill px-3 addToCart flex-grow-1"
                data-url="{{ route('addToCart') }}"
                data-product="{{ $product->id }}"
                style="height: 38px; background-color: #A45517; border-color: #A45517;"
            >
               Add
            </button>
            
            <input type="hidden" name="product_qty" value="1" class="product_qty">
        </div>
    @else
        <!-- Initial "Add to Cart" button for item NOT in cart -->
        <div class="add-to-cart-initial-btn">
            <button class="btn btn-primary btn-sm rounded-pill w-100 addToCart" 
                    data-url="{{ route('addToCart') }}"
                    data-product="{{ $product->id }}"
                    style="height: 38px; background-color: #A45517; border-color: #A45517;">
                Add to Cart
            </button>
            <input type="hidden" name="product_qty" value="1" class="product_qty">
        </div>
    @endif
</div>
