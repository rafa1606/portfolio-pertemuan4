@extends('layouts.app')

@section('title', 'Kontak - Portfolio')

@section('content')
<div class="page-shell">
    <div class="form-card">
        <p class="eyebrow">Kontak</p>
        <h1>Hubungi Saya</h1>

        @if (session('success'))
        <div class="alert alert-success" role="status">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
        @foreach ($errors->all() as $error)
        <div class="alert" role="alert">{{ $error }}</div>
        @endforeach
        @endif

        <form action="{{ route('contact.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label" for="name">Nama</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-input">
            </div>
            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-input">
            </div>
            <div class="form-group">
                <label class="form-label" for="subject">Subjek</label>
                <input type="text" name="subject" id="subject" value="{{ old('subject') }}" class="form-input">
            </div>
            <div class="form-group">
                <label class="form-label" for="message">Pesan</label>
                <textarea name="message" id="message" rows="5" class="form-input">{{ old('message') }}</textarea>
            </div>
            <div class="form-actions">
                <button type="submit" class="button">Kirim Pesan</button>
            </div>
        </form>
    </div>
</div>
@endsection