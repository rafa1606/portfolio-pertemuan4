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
                <label class="form-label" for="short_description">Deskripsi singkat</label>
                <input type="text" name="short_description" id="short_description" value="{{ old('short_description') }}" maxlength="255" class="form-input">
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
                <label class="form-label" for="project_date">Tanggal project</label>
                <input type="date" name="project_date" id="project_date" value="{{ old('project_date') }}" class="form-input">
            </div>
            <div class="form-group">
                <label class="check-row" for="is_featured">
                    <input type="checkbox" name="is_featured" id="is_featured" value="1" @checked(old('is_featured'))>
                    <span class="form-label" style="margin:0;">Tampilkan sebagai project unggulan</span>
                </label>
            </div>
            <div class="form-group">
                <label class="form-label" for="project_url">URL project</label>
                <input type="url" name="project_url" id="project_url" value="{{ old('project_url') }}" placeholder="https://" class="form-input">
            </div>
            <div class="form-group">
                <label class="form-label" for="repository_url">URL repository</label>
                <input type="url" name="repository_url" id="repository_url" value="{{ old('repository_url') }}" placeholder="https://" class="form-input">
            </div>
            <div class="form-group">
                <span class="form-label">Technologies</span>
                <div class="check-grid">
                    @foreach ($technologies as $technology)
                    <label class="check-row">
                        <input type="checkbox" name="technologies[]" value="{{ $technology->id }}" @checked(in_array($technology->id, array_map('intval', (array) old('technologies', []))))>
                        <span>{{ $technology->name }}</span>
                    </label>
                    @endforeach
                </div>
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
