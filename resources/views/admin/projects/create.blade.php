@extends('layouts.app')

@section('title', 'Tambah Project')

@section('content')
<div class="page-shell">
    <div class="form-card">
        <p class="eyebrow">Admin / Projects</p>
        <h1>Tambah Project</h1>

        @if ($errors->any())
        @foreach ($errors->all() as $error)
        <div class="alert" role="alert">{{ $error }}</div>
        @endforeach
        @endif

        <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="form-label" for="name">Nama project</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required class="form-input">
            </div>
            <div class="form-group">
                <label class="form-label" for="category_id">Kategori</label>
                <select name="category_id" id="category_id" class="form-input" required>
                    <option value="">Pilih kategori</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label" for="description">Deskripsi</label>
                <textarea name="description" id="description" class="form-input">{{ old('description') }}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label" for="status">Status</label>
                <select name="status" id="status" class="form-input" required>
                    <option value="published" @selected(old('status', 'published') === 'published')>Published</option>
                    <option value="draft" @selected(old('status') === 'draft')>Draft</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label" for="thumbnail">Thumbnail</label>
                <input type="file" name="thumbnail" id="thumbnail" accept="image/*" class="form-input">
                <p class="muted" style="margin:6px 0 0; font-size:.85rem;">JPG, PNG, atau WEBP. Maksimal 2 MB, minimal 400 x 300 px.</p>
            </div>
            <div class="form-actions">
                <button type="submit" class="button">Simpan</button>
                <a href="{{ route('admin.projects.index') }}" class="button button-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
