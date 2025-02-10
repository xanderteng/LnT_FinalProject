<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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

    <!-- Register Form  -->
    <div class="login-container">
        <h1>Register</h1>
        <form class="login-form" action="{{ route('register') }}" method="POST" novalidate>
            @csrf

            <input type="text" name="full_name" placeholder="Enter your full name" value="{{ old('full_name') }}">
            @error('full_name')
                <p class="error-message">{{ $message }}</p>
            @enderror

            <input type="email" name="email" placeholder="Enter your email" value="{{ old('email') }}">
            @error('email')
                <p class="error-message">{{ $message }}</p>
            @enderror

            <input type="password" name="password" placeholder="Enter your password">
            @error('password')
                <p class="error-message">{{ $message }}</p>
            @enderror

            <input type="text" name="phone_number" placeholder="Enter your phone number" value="{{ old('phone_number') }}">
            @error('phone_number')
                <p class="error-message">{{ $message }}</p>
            @enderror

            <button type="submit">Register</button>
        </form>

        <div class="register-link">
            <p>Already have an account? <a href="{{ route('getLogin') }}">Login here</a></p>
        </div>
    </div>

</body>
</html>
