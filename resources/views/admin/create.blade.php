<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Item</title>
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

    <section class="form-section">
        <h2>Create New Item</h2>
        <form action="{{ route('admin.storeItem') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <label for="itemName">Item Name:</label>
            <input type="text" name="itemName" id="itemName" placeholder="Enter item name" required>
            @error('itemName')
                <p class="error-message">{{ $message }}</p>
            @enderror

            <label for="itemCategory">Item Category:</label>
            <select name="itemCategory" id="itemCategory" required>
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->categoryName }}</option>
                @endforeach
            </select>
            @error('itemCategory')
                <p class="error-message">{{ $message }}</p>
            @enderror

            <label for="itemPrice">Item Price:</label>
            <input type="number" name="itemPrice" id="itemPrice" placeholder="Enter item price" required>
            @error('itemPrice')
                <p class="error-message">{{ $message }}</p>
            @enderror

            
            <label for="itemQuantity">Item Quantity:</label>
            <input type="number" name="itemQuantity" id="itemQuantity" placeholder="Enter item quantity" required>
            @error('itemQuantity')
                <p class="error-message">{{ $message }}</p>
            @enderror


            <label for="itemPicture">Item Picture:</label>
            <input type="file" name="itemPicture" id="itemPicture" accept="image/*" required>
            @error('itemPicture')
                <p class="error-message">{{ $message }}</p>
            @enderror

            <button type="submit" class="submit-button">Add Item</button>
        </form>
    </section>

</body>
</html>
