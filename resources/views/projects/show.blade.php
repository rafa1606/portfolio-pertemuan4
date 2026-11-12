@extends('layouts.app')

@section('title', $project->name . ' - Portfolio')

@section('content')
<div class="page-shell">
    <p class="eyebrow">{{ $project->category->name }}</p>
    <h1>{{ $project->name }}</h1>

    @if ($project->description)
    <p class="lead">{{ $project->description }}</p>
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
