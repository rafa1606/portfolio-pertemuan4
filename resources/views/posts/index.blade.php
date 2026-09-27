@extends('layouts.app')

@section('title', 'Daftar Post')

@section('content')

@if (session('success'))
    <div class="bg-green-500 text-white p-4 rounded mb-4">{{ session('success') }}</div>
@endif

<div class="max-w-3xl mx-auto p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Daftar Post</h1>
        <a href="{{ route('posts.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Create New Post</a>
    </div>

    @if ($posts->isEmpty())
        <p class="text-gray-500">Belum ada post.</p>
    @else
        <div class="space-y-4">
            @foreach ($posts as $post)
                <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-200">
                    <a href="{{ route('posts.show', $post->id) }}" class="text-lg font-semibold text-gray-900 hover:underline">{{ $post->title }}</a>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection