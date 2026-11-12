@extends('layouts.app')

@section('title', 'Edit Skill')

@section('content')
<div class="page-shell">
    <div class="form-card">
        <p class="eyebrow">Admin / Skills</p>
        <h1>Edit Skill</h1>

        @if ($errors->any())
        @foreach ($errors->all() as $error)
        <div class="alert" role="alert">{{ $error }}</div>
        @endforeach
        @endif

        <form action="{{ route('admin.skills.update', $skill) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label class="form-label" for="name">Nama skill</label>
                <input type="text" name="name" id="name" value="{{ old('name', $skill->name) }}" required class="form-input">
            </div>
            <div class="form-group">
                <label class="form-label" for="level">Level (0-100)</label>
                <input type="number" name="level" id="level" value="{{ old('level', $skill->level) }}" min="0" max="100" required class="form-input">
            </div>
            <div class="form-actions">
                <button type="submit" class="button">Simpan Perubahan</button>
                <a href="{{ route('admin.skills.index') }}" class="button button-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
