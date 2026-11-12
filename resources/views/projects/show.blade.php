@extends('layouts.app')

@section('title', $project->name . ' - Portfolio')

@section('content')
<div class="page-shell">
    <p class="eyebrow">{{ $project->category->name }}</p>
    <h1>{{ $project->name }}</h1>

    @if ($project->description)
    <p class="lead">{{ $project->description }}</p>
    @endif

    @if ($project->technologies->isNotEmpty())
    <div class="tech-list" style="margin-top:22px;">
        @foreach ($project->technologies as $technology)
        <span class="tech-badge">{{ $technology->name }}</span>
        @endforeach
    </div>
    @endif

    @if ($project->project_url || $project->repository_url)
    <div class="project-links">
        @if ($project->project_url)
        <a href="{{ $project->project_url }}" class="button" target="_blank" rel="noopener">Lihat Project</a>
        @endif
        @if ($project->repository_url)
        <a href="{{ $project->repository_url }}" class="button button-outline" target="_blank" rel="noopener">Repository</a>
        @endif
    </div>
    @endif

    @if ($project->thumbnail)
    <img class="hero-image" src="{{ asset('storage/' . $project->thumbnail) }}" alt="{{ $project->name }}">
    @endif

    @if ($project->images->isNotEmpty())
    <div class="gallery-grid" style="margin-top:32px;">
        @foreach ($project->images as $img)
        <figure class="gallery-item" style="margin:0;">
            <img src="{{ asset('storage/' . $img->image) }}" alt="{{ $img->caption ?: $project->name }}">
            @if ($img->caption)
            <figcaption class="muted" style="margin-top:8px; font-size:.88rem;">{{ $img->caption }}</figcaption>
            @endif
        </figure>
        @endforeach
    </div>
    @endif

    <a href="{{ route('projects') }}" class="button button-outline" style="margin-top:32px;">&larr; Kembali ke Projects</a>
</div>
@endsection
