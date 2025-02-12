<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Item</title>
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
        <h2>Edit Item: {{ $item->itemName }}</h2>
        <form action="{{ route('admin.updateItem', $item->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            
            <label for="itemName">Item Name:</label>
            <input type="text" name="itemName" id="itemName" value="{{ old('itemName', $item->itemName) }}" required>
            @error('itemName')
                <p class="error-message">{{ $message }}</p>
            @enderror

            
            <label for="itemCategory">Item Category:</label>
            <select name="itemCategory" id="itemCategory" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $item->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->categoryName }}
                    </option>
                @endforeach
            </select>
            @error('itemCategory')
                <p class="error-message">{{ $message }}</p>
            @enderror

            
            <label for="itemPrice">Item Price:</label>
            <input type="number" name="itemPrice" id="itemPrice" value="{{ old('itemPrice', $item->itemPrice) }}" required>
            @error('itemPrice')
                <p class="error-message">{{ $message }}</p>
            @enderror

            
            <label for="itemQuantity">Item Quantity:</label>
            <input type="number" name="itemQuantity" id="itemQuantity" value="{{ old('itemQuantity', $item->itemQuantity) }}" required>
            @error('itemQuantity')
                <p class="error-message">{{ $message }}</p>
            @enderror

            
            <label>Current Picture:</label>
            <img src="{{ asset('storage/itemPicture/' . $item->itemPicture) }}" alt="{{ $item->itemName }}" style="width:150px; height:auto; margin-bottom:10px;">

            
            <label for="itemPicture">Change Picture (optional):</label>
            <input type="file" name="itemPicture" id="itemPicture" accept="image/*">
            @error('itemPicture')
                <p class="error-message">{{ $message }}</p>
            @enderror

            
            <button type="submit" class="submit-button">Update Item</button>
        </form>
    </section>

</body>
</html>
