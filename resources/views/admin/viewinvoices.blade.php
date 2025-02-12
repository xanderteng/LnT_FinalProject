<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Invoices</title>
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

    <section class="invoice-section">
        <h2>All Invoices</h2>

        @if($invoices->isEmpty())
            <p>No invoices found.</p>
        @else
            <table class="invoice-table">
                <thead>
                    <tr>
                        <th>User Name</th>
                        <th>User Email</th>
                        <th>Invoice ID</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoices as $invoice)
                        <tr>
                            <td>{{ $invoice->user->full_name }}</td>
                            <td>{{ $invoice->user->email }}</td>
                            <td>{{ $invoice->id }}</td>
                            <td>
                                <a href="{{ route('invoice.show', ['id' => $invoice->id]) }}" class="view-button">View Invoice</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </section>

</body>
</html>
