@extends('layouts.app')

@section('title', 'Profil Saya - Portfolio')

@section('content')
    <div class="page-shell">
        <p class="eyebrow">Akun / Profil</p>
        <h1>Profil Saya</h1>
        <div class="section-grid">
            <article class="info-card"><h3>Nama</h3><p>{{ Auth::user()->name }}</p></article>
            <article class="info-card"><h3>Email</h3><p>{{ Auth::user()->email }}</p></article>
            <article class="info-card"><h3>Peran</h3><p>{{ Auth::user()->role }}</p></article>
        </div>
    </div>
@endsection