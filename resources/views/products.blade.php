<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">
    <script src="{{ asset('js/products.js') }}"></script>
</head>
<body>

    <!-- NavBar -->
    <nav>
        <div class="nav-left">
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('product') }}">Our Products</a>
            @if(Auth::check())
                <a href="#">Shopping Cart</a>
            @endif
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

    <!-- Search & Filter -->
    <section class="search-filter">
        <form action="{{ route('product') }}" method="GET" class="search-form">
            <input type="text" name="search" placeholder="Search items..." class="search-bar">
            <button type="submit" class="search-button">Search</button>
    
            <button type="button" class="filter-button" onclick="toggleFilter()">Filter</button>
    
            <div class="filter-dropdown" id="filterDropdown">
                @foreach($categories as $category)
                    <label>
                        <input type="checkbox" name="category[]" value="{{ $category->id }}" 
                            {{ is_array(request('category')) && in_array($category->id, request('category')) ? 'checked' : '' }}>
                        {{ $category->categoryName }}
                    </label>
                @endforeach
    
                <button type="submit" class="apply-filter-button">Apply Filter</button>
            </div>
        </form>
    </section>
    

    <!-- Display items -->
    <section class="items-grid">
        @foreach($items as $item)
            <div class="item-card">
                <img src="{{ $item->itemPicture }}" alt="{{ $item->itemName }}" class="item-image">
    
                <div class="item-details">
                    <h3 class="item-name">{{ $item->itemName }}</h3>
                    <p>Category: {{ $item->category->categoryName }}</p>
                    <p>Price: Rp{{ number_format($item->itemPrice, 0, ',', '.') }}</p>
                    <p>Quantity: {{ $item->itemQuantity }}</p>
                </div>
    
                <!-- Add to Cart Button -->
                @if(Auth::check())
                    <button class="add-to-cart-button" 
                        onclick="openCartPopup('{{ $item->itemPicture }}', '{{ $item->itemPrice }}', '{{ $item->itemQuantity }}')">
                        Add to Cart
                    </button>
                @else
                    <a href="{{ route('getLogin') }}" class="add-to-cart-button">Add to Cart</a>
                @endif
            </div>
        @endforeach
    </section>
    
    
    <!-- Add to Cart Popup Modal -->
    <div id="cartPopup" class="cart-popup">
        <div class="cart-popup-content">
            <!-- Close Button -->
            <span class="close-btn" onclick="closeCartPopup()">&times;</span>
    
            <!-- Item Info Section -->
            <div class="cart-item-info">
                <img id="popupItemImage" src="" alt="Item Picture" class="popup-item-image">
                <div class="popup-price-stock">
                    <p id="popupItemPrice">Rp0</p>
                    <p id="popupItemStock">Stock: 0</p>
                </div>
            </div>
    
            <!-- Quantity Selection -->
            <div class="quantity-selection">
                <label for="quantity">Quantity:</label>
                <div class="quantity-controls">
                    <button onclick="decreaseQuantity()">-</button>
                    <input type="text" id="quantityInput" value="1" readonly>
                    <button onclick="increaseQuantity()">+</button>
                </div>
            </div>
    
            <!-- Final Add to Cart Button -->
            <button class="final-add-button" onclick="addToCart()">Add to Cart</button>
        </div>
    </div>
</body>
</html>