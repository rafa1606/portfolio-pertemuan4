@extends('layouts.app')

@section('title', 'Home - Portfolio')

@section('content')
    <div class="page-shell">
        <section class="hero">
            <div>
                <p class="eyebrow">Portfolio / 2026</p>
                <h1>Merancang ide menjadi <span>produk digital.</span></h1>
                <p class="lead">Halo, saya Rafa Irhamniyansyah Achmad. Mahasiswa TRPL yang senang mengubah masalah sehari-hari menjadi pengalaman web yang sederhana dan bermakna.</p>
                <a class="button button-secondary" href="{{ route('projects') }}" style="margin-top: 26px;">Lihat proyek saya <span aria-hidden="true">&nbsp;↗</span></a>
            </div>
        </section>
        <section class="section-grid" aria-label="Ringkasan portfolio">
            <article class="info-card"><h3>01 / Tentang saya</h3><p>Kenali cerita, fokus studi, dan cara saya belajar.</p></article>
            <article class="info-card"><h3>02 / Pendidikan</h3><p>Perjalanan akademik di bidang rekayasa perangkat lunak.</p></article>
            <article class="info-card"><h3>03 / Catatan</h3><p>Temukan tulisan dan eksperimen terbaru di blog.</p></article>
        </section>

        <section aria-label="Project unggulan">
            <p class="eyebrow" style="margin-top: 54px;">Featured</p>
            <h2>Project unggulan</h2>
            <div class="project-grid">
                @forelse ($featured as $project)
                <a class="info-card project-card" href="{{ route('projects.show', $project) }}">
                    @if ($project->thumbnail)
                    <img class="thumb" src="{{ asset('storage/' . $project->thumbnail) }}" alt="{{ $project->name }}">
                    @else
                    <div class="thumb"></div>
                    @endif
                    <div class="project-card-body">
                        <p class="eyebrow">{{ $project->category->name }}</p>
                        <h3>{{ $project->name }}</h3>
                        <p>{{ $project->short_description }}</p>
                    </div>
                </a>
                @empty
                <div class="empty-state" style="grid-column: 1 / -1;">Belum ada project unggulan.</div>
                @endforelse
            </div>
        </section>

        <section aria-label="Skill">
            <p class="eyebrow" style="margin-top: 54px;">Skills</p>
            <h2>Skill utama</h2>
            <div class="tech-list" style="margin-top: 16px;">
                @foreach ($skills as $skill)
                <span class="tech-badge">{{ $skill->name }}</span>
                @endforeach
            </div>
        </section>
    </div>
@endsection