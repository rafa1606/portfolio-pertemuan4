@extends('layouts.app')

@section('title', 'Daftar Post')

@section('content')
<div class="page-shell post-page">
    @if (session('success'))
    <div class="alert alert-success" role="status">{{ session('success') }}</div>
    @endif

    <div class="page-heading">
        <div>
            <p class="eyebrow">Journal / Posts</p>
            <h1>Daftar Post</h1>
        </div>
        <div class="post-heading-actions">
            <a href="{{ route('posts.trash') }}" class="button button-outline">Trash</a>
            <a href="{{ route('posts.create') }}" class="button">Buat Post</a>
        </div>
    </div>

    <nav class="post-filters" aria-label="Filter post">
        <a href="{{ route('posts.index', request()->only('q', 'per_page')) }}" @class(['post-filter', 'active' => request('filter') !== 'published']) aria-current="{{ request('filter') !== 'published' ? 'page' : 'false' }}">Semua</a>
        <a href="{{ route('posts.index', array_merge(request()->only('q', 'per_page'), ['filter' => 'published'])) }}" @class(['post-filter', 'active' => request('filter') === 'published']) aria-current="{{ request('filter') === 'published' ? 'page' : 'false' }}">Published</a>
    </nav>

    <form method="GET" action="{{ route('posts.index') }}" style="display:flex; flex-wrap:wrap; gap:0.5rem; align-items:center; margin-bottom:1rem;">
        @if (request('filter') === 'published')
        <input type="hidden" name="filter" value="published">
        @endif
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul post">
        <select name="per_page" onchange="this.form.submit()">
            @foreach ([5, 10, 25] as $size)
            <option value="{{ $size }}" @selected($posts->perPage() === $size)>{{ $size }} per halaman</option>
            @endforeach
        </select>
        <button type="submit" class="button button-small">Cari</button>
        @if (request('q'))
        <a href="{{ route('posts.index', request()->only('filter', 'per_page')) }}" class="button button-outline button-small">Reset</a>
        @endif
    </form>

    @if ($posts->isEmpty())
    <div class="empty-state">Tidak ada post yang ditemukan.</div>
    @else
    <div class="post-list">
        @foreach ($posts as $post)
        <article class="post-card">
            <div class="post-card-content">
                <h2><a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a></h2>
                <p class="post-card-meta">No. {{ $posts->firstItem() + $loop->index }} &middot; {{ $post->created_at->format('d M Y') }}</p>
            </div>
            <div class="post-card-actions">
                <span @class(['status-badge', 'status-published' => $post->status === 'published', 'status-draft' => $post->status !== 'published'])>{{ ucfirst($post->status) }}</span>
                <a href="{{ route('posts.edit', $post->id) }}" class="button button-outline button-small">Edit</a>
            </div>
        </article>
        @endforeach
    </div>
    @endif

    <div style="margin-top:1rem; font-size:0.875rem;">
        Halaman : {{ $posts->currentPage() }} dari {{ $posts->lastPage() }} <br>
        Jumlah Data : {{ $posts->total() }} <br>
        Data Per Halaman : {{ $posts->perPage() }}
    </div>

    <div style="margin-top:1rem;">
        {{ $posts->links() }}
    </div>
</div>
@endsection