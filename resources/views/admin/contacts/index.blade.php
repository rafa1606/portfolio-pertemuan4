@extends('layouts.app')

@section('title', 'Pesan Masuk')

@section('content')
<div class="page-shell post-page">
    <div class="page-heading">
        <div>
            <p class="eyebrow">Admin / Messages</p>
            <h1>Pesan Masuk</h1>
        </div>
        <div class="post-heading-actions">
            <a href="{{ route('admin.dashboard.index') }}" class="button button-outline">Dashboard</a>
        </div>
    </div>

    @if ($contacts->isEmpty())
    <div class="empty-state">Belum ada pesan masuk.</div>
    @else
    <div class="post-list">
        @foreach ($contacts as $contact)
        <article class="post-card">
            <div class="post-card-content">
                <h2>{{ $contact->subject ?: '(Tanpa subjek)' }}</h2>
                <p class="post-card-meta">{{ $contact->name }} &middot; {{ $contact->email }} &middot; {{ $contact->created_at->format('d M Y, H:i') }}</p>
            </div>
            <div class="post-card-actions">
                <span @class(['status-badge', 'status-published' => $contact->is_read, 'status-draft' => ! $contact->is_read])>{{ $contact->is_read ? 'Sudah dibaca' : 'Belum dibaca' }}</span>
                <a href="{{ route('admin.contacts.show', $contact) }}" class="button button-outline button-small">Buka</a>
            </div>
        </article>
        @endforeach
    </div>

    {{ $contacts->links() }}
    @endif
</div>
@endsection