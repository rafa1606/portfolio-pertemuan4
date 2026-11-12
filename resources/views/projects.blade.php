@extends('layouts.app')

@section('title', 'Projects - Portfolio')

@section('content')
<div class="page-shell">
    <p class="eyebrow">03 / Selected work</p>
    <h1>Projects</h1>

    <form action="{{ route('projects') }}" method="GET" class="filter-bar filter-bar-public" role="search">
        <input type="search" name="search" value="{{ $search }}" placeholder="Cari project" aria-label="Cari project" class="form-input">
        <select name="category" aria-label="Filter kategori" class="form-input">
            <option value="">Semua kategori</option>
            @foreach ($categories as $c)
            <option value="{{ $c->slug }}" @selected(request('category') === $c->slug)>{{ $c->name }}</option>
            @endforeach
        </select>
        <select name="technology" aria-label="Filter technology" class="form-input">
            <option value="">Semua technology</option>
            @foreach ($technologies as $t)
            <option value="{{ $t->slug }}" @selected(request('technology') === $t->slug)>{{ $t->name }}</option>
            @endforeach
        </select>
        <select name="sort" aria-label="Urutkan" class="form-input">
            <option value="">Terbaru</option>
            <option value="terlama" @selected(request('sort') === 'terlama')>Terlama</option>
            <option value="az" @selected(in_array(request('sort'), ['az', 'judul'], true))>A-Z</option>
            <option value="tanggal" @selected(request('sort') === 'tanggal')>Tanggal project</option>
        </select>
        <button type="submit" class="button">Cari</button>
        <a href="{{ route('projects') }}" class="button button-outline">Reset</a>
    </form>

    <p class="muted result-count">{{ $projects->total() }} hasil ditemukan</p>

    <div class="project-grid">
        @forelse ($projects as $project)
        <a class="info-card project-card" href="{{ route('projects.show', $project) }}">
            @if ($project->thumbnail)
            <img class="thumb" src="{{ asset('storage/' . $project->thumbnail) }}" alt="{{ $project->name }}">
            @else
            <div class="thumb"></div>
            @endif
            <div class="project-card-body">
                <p class="eyebrow">{{ $project->category->name }}</p>
                <h3>{{ $project->name }}</h3>
                <p>{{ $project->short_description ?: \Illuminate\Support\Str::limit((string) $project->description, 100) }}</p>
                @if ($project->technologies->isNotEmpty())
                <div class="tech-list">
                    @foreach ($project->technologies as $technology)
                    <span class="tech-badge">{{ $technology->name }}</span>
                    @endforeach
                </div>
                @endif
            </div>
        </a>
        @empty
        <div class="empty-state" style="grid-column: 1 / -1;">Tidak ada project yang cocok.</div>
        @endforelse
    </div>

    <div class="pagination-wrap">
        {{ $projects->links() }}
    </div>
</div>
@endsection
