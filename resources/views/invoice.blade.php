<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">
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

    <section class="invoice-section">
        <h2>Invoice</h2>

        <p><strong>Invoice ID:</strong> {{ $invoice->id }}</p>
        <p><strong>Delivery Address:</strong> {{ $invoice->home_address }}</p>
        <p><strong>Postal Code:</strong> {{ $invoice->postal_code }}</p>
        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($invoice->created_at)->format('d M Y, H:i') }}</p>

        <h3>Order Details:</h3>
        <ul>
            @foreach(json_decode($invoice->items, true) as $item)
                <li>{{ $item['itemName'] }} - Quantity: {{ $item['quantity'] }} - Rp{{ number_format($item['itemPrice'], 0, ',', '.') }}</li>
            @endforeach
        </ul>

        <h3>Total: Rp{{ number_format($invoice->total_price, 0, ',', '.') }}</h3>
    </section>

</body>
</html>
