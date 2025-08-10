<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><circle cx='50' cy='50' r='45' fill='%23ff8c00' stroke='%23000' stroke-width='2'/><path d='M5 50 Q25 30 50 50 Q75 70 95 50' stroke='%23000' stroke-width='2' fill='none'/><path d='M50 5 Q70 25 50 50 Q30 75 50 95' stroke='%23000' stroke-width='2' fill='none'/><path d='M15 20 Q35 40 50 50 Q65 60 85 80' stroke='%23000' stroke-width='2' fill='none'/><path d='M85 20 Q65 40 50 50 Q35 60 15 80' stroke='%23000' stroke-width='2' fill='none'/></svg>" type="image/svg+xml">
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