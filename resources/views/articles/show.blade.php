@extends('layouts.app')

@section('title', $article->title)

@section('content')
<div class="max-w-4xl mx-auto">
    <article-view 
        :article="{{ json_encode($article->load('user')) }}"
        :content="{{ json_encode($content) }}"
    ></article-view>
</div>
@endsection