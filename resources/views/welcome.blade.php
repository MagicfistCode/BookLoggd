<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        body {
            background-color: #121212;
            color: white;
        }

        .info-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color:#212529;
            border-radius: 8px;
            margin-top: 40px;
            text-align: center;
        }
    </style>
    <title>BookLoggd</title>
</head>

<body>
    <nav class="navbar bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#" style="color: white; font-size:22px; width:90px">
                <img src="{{ asset('storage/' . 'logos/B-Logo-2.png') }}" alt="Logo" width="50%" height="50%"
                    class="align-text-top">
                BookLoggd
            </a>
            <ul class="nav">
                <li class="nav-item">
                    <a href="{{ route('login') }}">
                        @csrf
                        <button type="submit" class="btn btn-dark mx-2">Login</button>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('register') }}">
                        @csrf
                        <button type="submit" class="btn btn-dark">Register</button>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="info-container">
        <img src="{{ asset('storage/' . 'logos/B-Logo-2.png') }}" alt="Logo" width="20%" height="20%"
                    class="align-text-top">
        <h2>Welcome to BookLoggd!</h2>
        <p>This is your personalized book management platform. Organize, track, and discover your reading journey.</p>
    </div>
    <div class="info-container">
        <h3>Why use BookLoggd?</h3>
        <p>By using BookLoggd, not only can you track what you read, but you can also leave rating, reviews, earn badges and interact with a community of like-minded readers!</p>
    </div>
    <div class="info-container">
        <h3>How can I get started?</h3>
        <p>You can start simply by signing up for free and logging in! Start your reading journey now!</p>
        <a href="{{ route('register') }}">
            @csrf
            <button type="submit" class="btn btn-primary">Get Started!</button>
        </a>
    </div>
</body>

</html>
