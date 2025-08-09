@extends('layouts.app')

@section('title', 'Modifier l\'article')

@section('content')
<div class="max-w-4xl mx-auto">
    <article-form :article='@json($article)' :is-editing="true"></article-form>
</div>
@endsection