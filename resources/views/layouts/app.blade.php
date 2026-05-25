<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'V2T Bookstore')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased min-h-screen flex flex-col bg-[var(--color-v2t-bg)] text-[var(--color-v2t-text)]">
    
    @include('partials.header')

    <main class="flex-grow container mx-auto px-4 py-8">
        @if(session('success'))
            <div class="container mx-auto px-4 mt-4">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative shadow-sm" role="alert">
                    <span class="block sm:inline-block font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif
        @yield('content')
    </main>

    @include('partials.footer')
    
</body>
</html>