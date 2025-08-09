<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Blog Sport')</title>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>
<body class="bg-gray-100">
    <div id="app">
        <navbar></navbar>
        <main class="container mx-auto px-4 py-8 pt-28">
            @yield('content')
        </main>
    </div>
</body>
</html>