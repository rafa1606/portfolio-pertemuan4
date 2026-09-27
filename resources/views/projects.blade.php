@extends('layouts.app')

@section('title', 'Projects - Portfolio')

@section('content')
    <div class="page-shell">
        <p class="eyebrow">03 / Selected work</p>
        <h1>Projects</h1>
        <div class="section-grid">
            <article class="info-card"><p class="eyebrow">PPWL / 03</p><h3>Laravel Exploration</h3><p>Eksplorasi dasar Laravel dalam laporan praktikum PPWL Pertemuan 3.</p></article>
            <article class="info-card"><p class="eyebrow">PPWL / 04</p><h3>Portfolio Website</h3><p>Website portfolio personal dengan Laravel, Blade, dan desain antarmuka yang berkarakter.</p></article>
            <article class="info-card"><p class="eyebrow">Next / 05</p><h3>More in progress</h3><p>Eksperimen berikutnya sedang tumbuh. Catatan prosesnya akan segera hadir.</p></article>
        </div>
    </div>
@endsection