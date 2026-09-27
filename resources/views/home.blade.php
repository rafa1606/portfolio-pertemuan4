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
    </div>
@endsection