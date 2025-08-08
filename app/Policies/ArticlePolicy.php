<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ArticlePolicy
{
    public function create(User $user): bool
    {
        return $user->hasRole('redacteur');
    }

    public function update(User $user, Article $article): bool
    {
        return $user->hasRole('redacteur') && $user->id === $article->user_id;
    }

    public function delete(User $user, Article $article): bool
    {
        return $user->hasRole('redacteur') && $user->id === $article->user_id;
    }
}