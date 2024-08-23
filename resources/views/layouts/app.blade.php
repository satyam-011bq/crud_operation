<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Default Title')</title>
    <!-- Add Bootstrap CSS CDN -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Optionally, add custom CSS here -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <header>
        <!-- Include your navigation bar or header here -->
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <!-- Include your footer here -->
    </footer>

    <!-- Add Bootstrap JS and Popper.js CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/js/bootstrap.min.js"></script>
    <!-- Optionally, add custom JS here -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
