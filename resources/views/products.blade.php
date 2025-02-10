<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">
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
        <form action="#" method="GET" class="search-form">
            <input type="text" name="search" placeholder="Search items..." class="search-bar">
            <button type="submit" class="search-button">Search</button>
        </form>
    
        <button class="filter-button" onclick="toggleFilter()">Filter</button>
    
        <div class="filter-dropdown" id="filterDropdown">
            <form action="#" method="GET">
                @foreach($categories as $category)
                    <label>
                        <input type="checkbox" name="category[]" value="{{ $category->id }}">
                        {{ $category->categoryName }}
                    </label>
                @endforeach
                <button type="submit" class="apply-filter-button">Apply Filter</button>
            </form>
        </div>
    </section>
    
    

    <!-- Display items -->
    <section class="items-grid">
        @foreach($items as $item)
            <div class="item-card">
                <img src="{{ $item->itemPicture }}" alt="{{ $item->itemName }}" class="item-image">
    
                <div class="item-details">
                    <h3 class="item-name">{{ $item->itemName }}</h3> <!-- Item Name Above Category -->
                    <p>Category: {{ $item->category->categoryName }}</p>
                    <p>Price: Rp{{ number_format($item->itemPrice, 0, ',', '.') }}</p>
                    <p>Quantity: {{ $item->itemQuantity }}</p>
                </div>
    
                <a href="#" class="add-to-cart-button">Add to Cart</a>
            </div>
        @endforeach
    </section>
    <script>
        //Script for dropdown
        function toggleFilter() {
            const dropdown = document.getElementById('filterDropdown');
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        }
    </script>

</body>
</html>