@extends('layouts.app')

@section('title', 'Trash')

@section('content')
<div class="page-shell post-page">
    @if (session('success'))
    <div class="alert alert-success" role="status">{{ session('success') }}</div>
    @endif

    <div class="page-heading">
        <div>
            <p class="eyebrow">Journal / Archive</p>
            <h1>Trash</h1>
        </div>
        <a href="{{ route('posts.index') }}" class="button button-outline">Kembali ke Post</a>
    </div>

    @if ($posts->isEmpty())
    <div class="empty-state">Trash masih kosong.</div>
    @else
    <div class="post-list">
        @foreach ($posts as $post)
        <article class="post-card">
            <div class="post-card-content">
                <h2>{{ $post->title }}</h2>
                <p class="post-card-meta">Dihapus {{ $post->deleted_at->format('d M Y, H:i') }}</p>
            </div>
            <div class="post-card-actions">
                <span class="status-badge status-deleted">Dihapus</span>
                <form action="{{ route('posts.restore', $post->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="button button-outline button-small">Pulihkan</button>
                </form>
                <form action="{{ route('posts.forceDelete', $post->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="button button-danger button-small">Hapus Permanen</button>
                </form>
            </div>
        </article>
        @endforeach
    </div>
    @endif
</div>
@endsection