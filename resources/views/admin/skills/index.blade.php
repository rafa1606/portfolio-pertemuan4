@extends('layouts.app')

@section('title', 'Kelola Skill')

@section('content')
<div class="page-shell post-page">
    @if (session('success'))
    <div class="alert alert-success" role="status">{{ session('success') }}</div>
    @endif

    <div class="page-heading">
        <div>
            <p class="eyebrow">Admin / Skills</p>
            <h1>Kelola Skill</h1>
        </div>
        <div class="post-heading-actions">
            <a href="{{ route('admin.dashboard.index') }}" class="button button-outline">Dashboard</a>
        </div>
    </div>

    @if ($skills->isEmpty())
    <div class="empty-state">Belum ada skill.</div>
    @else
    <div class="post-list">
        @foreach ($skills as $skill)
        <article class="post-card">
            <div class="post-card-content">
                <h2>{{ $skill->name }}</h2>
                <p class="post-card-meta">Level {{ $skill->level }}%</p>
            </div>
            <div class="post-card-actions">
                <a href="{{ route('admin.skills.edit', $skill) }}" class="button button-outline button-small">Edit</a>
            </div>
        </article>
        @endforeach
    </div>
    @endif
</div>
@endsection
