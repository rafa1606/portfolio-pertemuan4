@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="page-shell">
    <div class="page-heading">
        <div>
            <p class="eyebrow">Admin / Dashboard</p>
            <h1>Dashboard</h1>
        </div>
        <div class="post-heading-actions">
            <a href="{{ route('admin.contacts.index') }}" class="button button-outline">Messages</a>
            <a href="{{ route('admin.skills.index') }}" class="button button-outline">Kelola Skill</a>
            <a href="{{ route('admin.projects.index') }}" class="button">Kelola Project</a>
        </div>
    </div>

    <div class="stat-grid">
        <x-stat-card label="Projects" :value="$totalProjects" />
        <x-stat-card label="Published" :value="$publishedProjects" color="text-green-600" />
        <x-stat-card label="Draft" :value="$draftProjects" color="text-amber-600" />
        <x-stat-card label="Categories" :value="$totalCategories" color="text-purple-600" />
        <x-stat-card label="Technologies" :value="$totalTechnologies" color="text-teal-600" />
        <x-stat-card label="Skills" :value="$totalSkills" color="text-orange-600" />
        <x-stat-card label="Messages" :value="$totalMessages" color="text-rose-600" />
        <x-stat-card label="Belum Dibaca" :value="$unreadMessages" color="text-indigo-600" />
    </div>

    <div class="panel-grid">
        <section class="info-card">
            <h3>Project Terbaru</h3>
            <ul class="mini-list">
                @forelse ($latestProjects as $project)
                <li>
                    <span>{{ $project->name }} <span class="muted">&middot; {{ $project->category->name }}</span></span>
                    <span @class(['status-badge', 'status-published' => $project->status === 'published', 'status-draft' => $project->status !== 'published'])>{{ ucfirst($project->status) }}</span>
                </li>
                @empty
                <li class="muted">Belum ada project.</li>
                @endforelse
            </ul>
        </section>

        <section class="info-card">
            <h3>Skill Teratas</h3>
            <ul class="mini-list">
                @forelse ($topSkills as $skill)
                <li><span>{{ $skill->name }}</span><strong>{{ $skill->level }}%</strong></li>
                @empty
                <li class="muted">Belum ada skill.</li>
                @endforelse
            </ul>
        </section>

        <section class="info-card">
            <h3>Project per Kategori</h3>
            <ul class="mini-list">
                @forelse ($categories as $category)
                <li><span>{{ $category->name }}</span><strong>{{ $category->projects_count }}</strong></li>
                @empty
                <li class="muted">Belum ada kategori.</li>
                @endforelse
            </ul>
        </section>
    </div>
</div>
@endsection
