<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index(): View
    {
        $articles = Article::with('user')
            ->whereNotNull('published_at')
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        return view('articles.index', compact('articles'));
    }

    public function show(Article $article): View
    {
        // Injecter les variables dynamiques
        $content = $this->injectVariables($article->content);
        
        return view('articles.show', compact('article', 'content'));
    }

    public function create(): View
    {
        $this->authorize('create', Article::class);
        return view('articles.create');
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', Article::class);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        $article = Article::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'user_id' => Auth::id(),
            'published_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'redirect' => route('home'),
            'message' => 'Article créé avec succès!'
        ]);
    }

    public function edit(Article $article): View
    {
        $this->authorize('update', $article);
        return view('articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article): JsonResponse
    {
        $this->authorize('update', $article);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'publish' => 'boolean'
        ]);

        $article->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'published_at' => now()  // Toujours publier
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Article modifié avec succès!',
            'redirect' => route('home')
        ]);
    }

    public function destroy(Article $article): JsonResponse
    {
        $this->authorize('delete', $article);
        
        $article->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Article supprimé avec succès!'
        ]);
    }

    private function injectVariables(string $content): string
    {
        $variables = [
            '{{nom_utilisateur}}' => Auth::user()->name ?? 'Visiteur',
            '{{date_lecture}}' => now()->format('d/m/Y')
        ];

        return str_replace(array_keys($variables), array_values($variables), $content);
    }
}