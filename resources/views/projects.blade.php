@extends('layouts.app')

@section('title', 'Projects - Portfolio')

@section('content')
<div class="page-shell">
    <p class="eyebrow">03 / Selected work</p>
    <h1>Projects</h1>

    @if ($projects->isEmpty())
    <div class="empty-state" style="margin-top:40px;">Belum ada project yang dipublikasikan.</div>
    @else
    <div class="project-grid">
        @foreach ($projects as $project)
        <a class="info-card project-card" href="{{ route('projects.show', $project) }}">
            @if ($project->thumbnail)
            <img class="thumb" src="{{ asset('storage/' . $project->thumbnail) }}" alt="{{ $project->name }}">
            @else
            <div class="thumb"></div>
            @endif
            <div class="project-card-body">
                <p class="eyebrow">{{ $project->category->name }}</p>
                <h3>{{ $project->name }}</h3>
                <p>{{ \Illuminate\Support\Str::limit((string) $project->description, 100) }}</p>
            </div>
        </a>
        @endforeach
    </div>
    @endif
</div>
@endsection
