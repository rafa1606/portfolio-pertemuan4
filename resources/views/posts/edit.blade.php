@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
<div class="page-shell">
    <div class="form-card">
        <p class="eyebrow">Journal / Edit</p>
        <h1>Edit Post</h1>

        @if ($errors->any())
        @foreach ($errors->all() as $error)
        <div class="alert" role="alert">{{ $error }}</div>
        @endforeach
        @endif

        <form action="{{ route('posts.update', $post->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label class="form-label" for="title">Judul</label>
                <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}" required
                    class="form-input">
            </div>
            <div class="form-group">
                <label class="form-label" for="content">Isi post</label>
                <textarea name="content" id="content" class="form-input"
                    required>{{ old('content', $post->content) }}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label" for="status">Status</label>
                <select name="status" id="status" class="form-input" required>
                    <option value="draft" {{ old('status', $post->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status', $post->status) === 'published' ? 'selected' : '' }}>Published</option>
                </select>
            </div>
            <div class="form-actions">
                <button type="submit" class="button">Simpan Perubahan</button>
                <a href="{{ route('posts.show', $post->id) }}" class="button button-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection