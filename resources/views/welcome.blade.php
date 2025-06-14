<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>UNIMAS Event Hub</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <!-- Styles -->
        <style>
            body {
                font-family: 'Poppins', sans-serif;
                margin: 0;
                padding: 0;
                background: #f8f9fa;
            }
            .container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 2rem;
            }
            .hero {
                background: linear-gradient(135deg, #1a237e, #0d47a1);
                color: white;
                padding: 4rem 0;
                text-align: center;
            }
            .hero h1 {
                font-size: 3rem;
                margin-bottom: 1rem;
            }
            .hero p {
                font-size: 1.2rem;
                opacity: 0.9;
            }
            .features {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 2rem;
                padding: 4rem 0;
            }
            .feature-card {
                background: white;
                padding: 2rem;
                border-radius: 10px;
                box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            }
            .feature-card h3 {
                color: #1a237e;
                margin-bottom: 1rem;
            }
            .cta-button {
                display: inline-block;
                background: #1a237e;
                color: white;
                padding: 1rem 2rem;
                border-radius: 5px;
                text-decoration: none;
                transition: background 0.3s;
            }
            .cta-button:hover {
                background: #0d47a1;
            }
            .navbar {
                background: white;
                padding: 1rem 0;
                box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            }
            .nav-content {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            .nav-logo {
                font-size: 1.5rem;
                font-weight: bold;
                color: #1a237e;
            }
            .nav-links a {
                color: #333;
                text-decoration: none;
                margin-left: 2rem;
            }
        </style>
    </head>
    <body>
        <nav class="navbar">
            <div class="container nav-content">
                <div class="nav-logo">UNIMAS Event Hub</div>
                <div class="nav-links">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}">Login</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}">Register</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </nav>

        <section class="hero">
            <div class="container">
                <h1>Welcome to UNIMAS Event Hub</h1>
                <p>Discover, Create, and Manage University Events All in One Place</p>
                <a href="{{ route('register') }}" class="cta-button">Get Started</a>
            </div>
        </section>

        <div class="container">
            <div class="features">
                <div class="feature-card">
                    <h3>Event Discovery</h3>
                    <p>Browse and discover upcoming events happening around UNIMAS campus.</p>
                </div>
                <div class="feature-card">
                    <h3>Easy Registration</h3>
                    <p>Register for events with just a few clicks and manage your attendance.</p>
                </div>
                <div class="feature-card">
                    <h3>Event Management</h3>
                    <p>Create and manage your own events with our intuitive tools.</p>
                </div>
            </div>
        </div>
    </body>
</html>
