<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// API pour récupérer l'utilisateur connecté
Route::get('/user', [AuthController::class, 'user'])->middleware('auth');

// API pour les articles
Route::get('/articles', function () {
    $articles = \App\Models\Article::with('user')
        // ->whereNotNull('published_at')  // Commentez cette ligne temporairement
        ->orderBy('created_at', 'desc')
        ->paginate(10);
    
    return response()->json($articles);
});