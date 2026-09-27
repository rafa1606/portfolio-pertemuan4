@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="max-w-2xl mx-auto p-6">
    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
        <h2 class="text-xl font-bold text-gray-900">{{ $post->title }}</h2>
        <p class="text-gray-600 mt-2">{{ $post->content }}</p>
        <div class="mt-4 space-x-3">
            <a href="{{ route('posts.edit', $post->id) }}" class="text-blue-600 hover:underline">Edit</a>
            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:underline">Delete</button>
            </form>
            <a href="{{ route('posts.index') }}" class="text-blue-600 hover:underline">Back to List</a>
        </div>
    </div>
</div>
@endsection