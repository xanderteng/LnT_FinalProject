<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
</head>
<body>

    <nav>
        <div class="nav-left">
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('product') }}">Our Products</a>
            <a href="{{ route('cart') }}">Shopping Cart</a>
        </div>

        <div class="nav-right">
            @if(Auth::check())
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="nav-link-button">Logout</button>
                </form>
            @else
                <a href="{{ route('getLogin') }}" class="nav-link-button">Login</a>
            @endif
        </div>
    </nav>

    <section class="address-section">
        <h2>Delivery Address</h2>
        <form action="{{ route('confirmOrder') }}" method="POST">
            @csrf

            
            <textarea name="home_address" placeholder="Enter the full delivery address here..." class="address-textarea">{{ old('home_address') }}</textarea>
            @error('home_address')
                <p class="error-message">{{ $message }}</p>
            @enderror

            
            <input type="text" name="postal_code" placeholder="Postal Code" class="postal-code-input" value="{{ old('postal_code') }}">
            @error('postal_code')
                <p class="error-message">{{ $message }}</p>
            @enderror

            
            @if(count($cartItems) > 0)
                <div class="cart-summary">
                    <p>Total: Rp{{ number_format($totalPrice, 0, ',', '.') }}</p>
                    <button type="submit" class="confirm-order-button">Confirm Order</button>
                </div>
            @endif
        </form>
    </section>

  
    <section class="cart-section">
        <h2>Your Shopping Cart</h2>

        @forelse($cartItems as $itemId => $item)
            <div class="cart-item" id="cart-item-{{ $itemId }}">

                <img src="{{ asset('storage/itemPicture/' . $item['itemPicture']) }}" alt="{{ $item['itemName'] }}" class="cart-item-image">

                <div class="cart-item-details">
                    <h3>{{ $item['itemName'] }}</h3>
                    <p>Price: Rp{{ number_format($item['itemPrice'], 0, ',', '.') }}</p>

                   
                    <form action="{{ route('updateCart') }}" method="POST" class="quantity-form">
                        @csrf
                        <input type="hidden" name="item_id" value="{{ $itemId }}">

                        <label>Quantity:</label>

                        
                        <button type="submit" name="quantity_change" value="-1"
                            @if($item['quantity'] == 1) disabled @endif>-</button>

                       
                        <input type="text" name="quantity" value="{{ $item['quantity'] }}" readonly>

                       
                        <button type="submit" name="quantity_change" value="1"
                            @if($item['quantity'] >= $item['itemQuantity']) disabled @endif>+</button>

                        <span class="stock-info">Stock: {{ $item['itemQuantity'] }}</span>
                    </form>

                    <p>Subtotal: Rp{{ number_format($item['itemPrice'] * $item['quantity'], 0, ',', '.') }}</p>

                   
                    <form action="{{ route('removeFromCart') }}" method="POST" class="remove-form">
                        @csrf
                        <input type="hidden" name="item_id" value="{{ $itemId }}">
                        <button type="submit" class="remove-item-button">Remove</button>
                    </form>
                </div>

            </div>
        @empty
            <p>Your cart is empty. Start adding items to see them here!</p>
        @endforelse
    </section>

</body>
</html>
