<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>

    <!-- NavBar -->
    <nav>
        <div class="nav-left">
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('product') }}">Our Products</a>
        </div>
    </nav>

    <!-- Login Form -->
    <div class="login-container">
        <h1>Login</h1>
        {{-- Error Handling --}}
        @if ($errors->any())
            <div style="color: red; margin-bottom: 1rem;">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        @if (session('success'))
            <div style="color: green; margin-bottom: 1rem;">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <p style="color: red;">{{ session('error') }}</p>
        @endif

        <form class="login-form" action="{{ route('login') }}" method="POST">
            @csrf
            <input type="email" name="email" placeholder="Enter your email" required>
            <input type="password" name="password" placeholder="Enter your password" required>
            <button type="submit">Login</button>
        </form>
        <div class="register-link">
            <p>Don't have an account? <a href="{{ route('getRegister') }}">Register here</a></p>
        </div>
    </div>

</body>
</html>
