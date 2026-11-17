@extends('layouts.app')

@section('title', 'Detail Pesan')

@section('content')
<div class="page-shell">
    <div class="form-card">
        <p class="eyebrow">Admin / Messages</p>
        <h1>{{ $contact->subject ?: '(Tanpa subjek)' }}</h1>
        <p class="muted">Dari {{ $contact->name }} ({{ $contact->email }}) &middot; {{ $contact->created_at->format('d M Y, H:i') }}</p>

        <p style="white-space:pre-line; margin-top:20px;">{{ $contact->message }}</p>

        <div class="form-actions">
            <a href="{{ route('admin.contacts.index') }}" class="button button-outline">Kembali</a>
        </div>
    </div>
</div>
@endsection