<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Items</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

   
    <nav>
        <div class="nav-left">
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('admin.items') }}">Manage Items</a>
            <a href="{{ route('admin.createItem') }}">Create Items</a>
            <a href="{{ route('admin.viewInvoices') }}">View Invoices</a>
        </div>
    
        <div class="nav-right">
            @if(Auth::check())
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="nav-link-button">Logout</button>
                </form>
            @endif
        </div>
    </nav>
    

    <section class="items-grid">
        @foreach($items as $item)
            <div class="item-card">
                <img src="{{ asset('storage/itemPicture/' . $item->itemPicture) }}" alt="{{ $item->itemName }}" class="item-image">

                <div class="item-details">
                    <h3 class="item-name">{{ $item->itemName }}</h3>
                    <p>Category: {{ $item->category->categoryName }}</p>
                    <p>Price: Rp{{ number_format($item->itemPrice, 0, ',', '.') }}</p>
                    <p>Stock: {{ $item->itemQuantity }}</p>
                </div>

   
                <div class="admin-actions">
                    <a href="{{ route('admin.editItem', $item->id) }}" class="edit-button" style="text-decoration: none;">Edit</a>

                    <form action="{{ route('admin.items.delete', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-button">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
    </section>

</body>
</html>
