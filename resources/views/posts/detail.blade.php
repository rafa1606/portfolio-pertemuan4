@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="page-shell">
    <article class="form-card post-detail">
        <p class="eyebrow">Journal / {{ ucfirst($post->status) }}</p>
        <h1>{{ $post->title }}</h1>
        <p class="post-detail-content">{{ $post->content }}</p>
        <div class="post-detail-actions">
            <a href="{{ route('posts.edit', $post->id) }}" class="button">Edit Post</a>
            <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="button button-danger">Hapus</button>
            </form>
            <a href="{{ route('posts.index') }}" class="button button-outline">Kembali ke Daftar</a>
        </div>
    </article>
</div>
@endsection