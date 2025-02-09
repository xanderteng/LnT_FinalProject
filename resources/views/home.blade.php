<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChipiChapa Shop</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>
<body>

    <!-- NavBar -->
    <nav>
        <div class="nav-left">
            <a href="{{ route('home') }}">Home</a>
            <a href="#">Items</a>
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

    <!-- Hero -->
    <section class="hero">
        <h1>Welcome to ChipiChapa Shop</h1>
        <p>Your shop service that brings web-based items to life.</p>
        <a href="{{ route('getLogin') }}">
            <button>Get Started</button>
        </a>
    </section>

    <!-- Contact Us -->
    <section class="contact-section">
        <h2>Got any questions? Contact Us!</h2>
        <form class="contact-form">
            <input type="text" name="name" placeholder="Enter your name" required>
            <input type="text" name="subject" placeholder="What's the subject?" required>
            <textarea name="message" rows="5" placeholder="Write your message here..." required></textarea>
            <button type="submit">Send Message</button>
        </form>
    </section>

</body>
</html>
