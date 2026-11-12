@extends('layouts.app')

@section('title', 'Kelola Project')

@section('content')
<div class="page-shell post-page">
    @if (session('success'))
    <div class="alert alert-success" role="status">{{ session('success') }}</div>
    @endif

    <div class="page-heading">
        <div>
            <p class="eyebrow">Admin / Projects</p>
            <h1>Kelola Project</h1>
        </div>
        <div class="post-heading-actions">
            <a href="{{ route('admin.dashboard.index') }}" class="button button-outline">Dashboard</a>
            <a href="{{ route('admin.projects.create') }}" class="button">Tambah Project</a>
        </div>
    </div>

    <form action="{{ route('admin.projects.index') }}" method="GET" class="filter-bar" role="search">
        <input type="search" name="search" value="{{ $search }}" placeholder="Cari nama atau deskripsi singkat" aria-label="Cari project" class="form-input">
        <select name="status" aria-label="Filter status" class="form-input">
            <option value="">Semua status</option>
            <option value="published" @selected(request('status') === 'published')>Published</option>
            <option value="draft" @selected(request('status') === 'draft')>Draft</option>
        </select>
        <button type="submit" class="button">Cari</button>
        <a href="{{ route('admin.projects.index') }}" class="button button-outline">Reset</a>
    </form>

    @if ($projects->isEmpty())
    <div class="empty-state">{{ request()->anyFilled(['search', 'status']) ? 'Tidak ada project yang cocok.' : 'Belum ada project.' }}</div>
    @else
    <div class="post-list">
        @foreach ($projects as $project)
        <article class="post-card">
            <div class="post-card-content" style="display:flex; align-items:center; gap:16px;">
                @if ($project->thumbnail)
                <img class="thumb-small" src="{{ asset('storage/' . $project->thumbnail) }}" alt="{{ $project->name }}">
                @endif
                <div>
                    <h2>{{ $project->name }}</h2>
                    <p class="post-card-meta">{{ $project->category->name }} &middot; {{ $project->images_count }} gambar gallery @if ($project->is_featured)&middot; Unggulan @endif</p>
                </div>
            </div>
            <div class="post-card-actions">
                <span @class(['status-badge', 'status-published' => $project->status === 'published', 'status-draft' => $project->status !== 'published'])>{{ ucfirst($project->status) }}</span>
                <a href="{{ route('admin.projects.edit', $project) }}" class="button button-outline button-small">Edit</a>
                <form action="{{ route('admin.projects.destroy', $project) }}" method="POST"
                    onsubmit="return confirm('Hapus project ini beserta semua gambarnya?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="button button-danger button-small">Hapus</button>
                </form>
            </div>
        </article>
        @endforeach
    </div>

    <div class="pagination-wrap">
        {{ $projects->links() }}
    </div>
    @endif
</div>
@endsection
