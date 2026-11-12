@extends('layouts.app')

@section('title', 'Edit Project')

@section('content')
<div class="page-shell">
    @if (session('success'))
    <div class="alert alert-success" role="status">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
    @foreach ($errors->all() as $error)
    <div class="alert" role="alert">{{ $error }}</div>
    @endforeach
    @endif

    <div class="form-card" style="margin-top:24px;">
        <p class="eyebrow">Admin / Projects</p>
        <h1>Edit Project</h1>

        <form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label class="form-label" for="name">Nama project</label>
                <input type="text" name="name" id="name" value="{{ old('name', $project->name) }}" required class="form-input">
            </div>
            <div class="form-group">
                <label class="form-label" for="category_id">Kategori</label>
                <select name="category_id" id="category_id" class="form-input" required>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id', $project->category_id) == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label" for="short_description">Deskripsi singkat</label>
                <input type="text" name="short_description" id="short_description" value="{{ old('short_description', $project->short_description) }}" maxlength="255" class="form-input">
            </div>
            <div class="form-group">
                <label class="form-label" for="description">Deskripsi</label>
                <textarea name="description" id="description" class="form-input">{{ old('description', $project->description) }}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label" for="status">Status</label>
                <select name="status" id="status" class="form-input" required>
                    <option value="published" @selected(old('status', $project->status) === 'published')>Published</option>
                    <option value="draft" @selected(old('status', $project->status) === 'draft')>Draft</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label" for="project_date">Tanggal project</label>
                <input type="date" name="project_date" id="project_date" value="{{ old('project_date', $project->project_date?->format('Y-m-d')) }}" class="form-input">
            </div>
            <div class="form-group">
                {{-- checkbox yang tidak dicentang tidak terkirim, jadi old() kosong tidak boleh jatuh ke nilai lama --}}
                <label class="check-row" for="is_featured">
                    <input type="checkbox" name="is_featured" id="is_featured" value="1" @checked(session()->hasOldInput() ? old('is_featured') : $project->is_featured)>
                    <span class="form-label" style="margin:0;">Tampilkan sebagai project unggulan</span>
                </label>
            </div>
            <div class="form-group">
                <label class="form-label" for="project_url">URL project</label>
                <input type="url" name="project_url" id="project_url" value="{{ old('project_url', $project->project_url) }}" placeholder="https://" class="form-input">
            </div>
            <div class="form-group">
                <label class="form-label" for="repository_url">URL repository</label>
                <input type="url" name="repository_url" id="repository_url" value="{{ old('repository_url', $project->repository_url) }}" placeholder="https://" class="form-input">
            </div>
            <div class="form-group">
                @php
                    $dipilih = array_map('intval', session()->hasOldInput()
                        ? (array) old('technologies', [])
                        : $project->technologies->pluck('id')->all());
                @endphp
                <span class="form-label">Technologies</span>
                <div class="check-grid">
                    @foreach ($technologies as $technology)
                    <label class="check-row">
                        <input type="checkbox" name="technologies[]" value="{{ $technology->id }}" @checked(in_array($technology->id, $dipilih))>
                        <span>{{ $technology->name }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
            <div class="form-group">
                <label class="form-label" for="thumbnail">Thumbnail</label>
                @if ($project->thumbnail)
                <img class="thumb" style="max-width:240px; margin-bottom:10px;" src="{{ asset('storage/' . $project->thumbnail) }}" alt="{{ $project->name }}">
                @endif
                <input type="file" name="thumbnail" id="thumbnail" accept="image/*" class="form-input">
                <p class="muted" style="margin:6px 0 0; font-size:.85rem;">Kosongkan jika tidak ingin mengganti. Maksimal 2 MB, minimal 400 x 300 px.</p>
            </div>
            <div class="form-actions">
                <button type="submit" class="button">Simpan Perubahan</button>
                <a href="{{ route('admin.projects.index') }}" class="button button-outline">Kembali</a>
            </div>
        </form>
    </div>

    <div class="form-card" style="margin-top:24px;">
        <p class="eyebrow">Gallery</p>
        <h2>Gallery ({{ $project->images->count() }}/10)</h2>

        <form action="{{ route('admin.projects.images.store', $project) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="form-label" for="images">Tambah gambar</label>
                <input type="file" name="images[]" id="images" accept="image/*" multiple class="form-input">
                <p class="muted" style="margin:6px 0 0; font-size:.85rem;">Maksimal 10 gambar per project. Maksimal 4 MB per gambar, lebar minimal 800 px.</p>
            </div>
            <div class="form-actions">
                <button type="submit" class="button">Unggah</button>
            </div>
        </form>

        @if ($project->images->isNotEmpty())
        <div class="gallery-grid">
            @foreach ($project->images as $image)
            <div class="gallery-item">
                <img src="{{ asset('storage/' . $image->image) }}" alt="{{ $image->caption ?: $project->name }}">

                <form class="gallery-caption-form" action="{{ route('admin.projects.images.update', [$project, $image]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="text" name="caption" value="{{ $image->caption }}" class="form-input" placeholder="Caption" aria-label="Caption gambar">
                    <button type="submit" class="button button-outline button-small">Simpan</button>
                </form>

                <form action="{{ route('admin.projects.images.destroy', [$project, $image]) }}" method="POST"
                    onsubmit="return confirm('Hapus gambar ini?')" style="margin-top:8px;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="button button-danger button-small">Hapus</button>
                </form>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endsection
