@extends('layouts.app')

@section('title', 'Post')

@section('content')
<div class="page-shell">
    <div class="form-card">
        <p class="eyebrow">04 / Journal</p>
        <h1>Tulis Post</h1>

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert">{{ $error }}</div>
            @endforeach
        @endif

        <form action="{{ route('posts.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label" for="title">Judul</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                    class="form-input" placeholder="Judul yang ingin kamu bagikan">
            </div>
            <div class="form-group">
                <label class="form-label" for="content">Isi post</label>
                <textarea name="content" id="content" class="form-input" placeholder="Ceritakan proses, temuan, atau ide kamu..." required>{{ old('content') }}</textarea>
            </div>
            <button type="submit" class="button" style="margin-top: 24px;">Publikasikan</button>
        </form>
    </div>
</div>
@endsection