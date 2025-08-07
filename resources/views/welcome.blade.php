@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
<div class="text-center">
    <h1 class="text-4xl font-bold text-gray-800 mb-4">Bienvenue sur notre plateforme de blog</h1>
    <p class="text-xl text-gray-600 mb-8">Créez et partagez vos articles avec le monde entier</p>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Ici seront affichés les articles -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-semibold mb-2">Article exemple</h3>
            <p class="text-gray-600">Contenu de l'article...</p>
        </div>
    </div>
</div>
@endsection
</body>
</html>
