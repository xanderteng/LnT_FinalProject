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

    <nav>
        <div class="nav-left">
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('product') }}">Our Products</a>
            @if(Auth::check())
                <a href="{{ route('cart') }}">Shopping Cart</a>
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.items') }}">Manage Items</a>
                @endif
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
    

    
    <section class="items-grid">
        @foreach($items as $item)
            <div class="item-card">
                <img src="{{ asset('storage/itemPicture/' . $item->itemPicture) }}" alt="{{ $item->itemName }}" class="item-image">

                <div class="item-details">
                    <h3 class="item-name">{{ $item->itemName }}</h3>
                    <p>Category: {{ $item->category->categoryName }}</p>
                    <p>Price: Rp{{ number_format($item->itemPrice, 0, ',', '.') }}</p>
                    <p>Quantity: {{ $item->itemQuantity }}</p>
                </div>

                
                @if(Auth::check())
                    @if($item->itemQuantity > 0)
                        <form action="{{ route('addToCart') }}" method="POST">
                            @csrf
                            <input type="hidden" name="item_id" value="{{ $item->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="add-to-cart-button">Add to Cart</button>
                        </form>
                    @else
                        <button class="out-of-stock-button" disabled>Out of Stock</button>
                    @endif
                @else
                    @if($item->itemQuantity > 0)
                        <a href="{{ route('getLogin') }}" class="add-to-cart-button">Add to Cart</a>
                    @else
                        <button class="out-of-stock-button" disabled>Out of Stock</button>
                    @endif
                @endif
            </div>
        @endforeach
    </section>

</body>
</html>