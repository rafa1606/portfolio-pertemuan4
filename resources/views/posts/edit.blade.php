@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
<div class="max-w-2xl mx-auto p-6">
    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Edit Post</h1>

        @if ($errors->any())
        @foreach ($errors->all() as $error)
        <div class="bg-red-500 text-white p-4 rounded mb-4">{{ $error }}</div>
        @endforeach
        @endif

        <form action="{{ route('posts.update', $post->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div>
                <label for="title">Title</label>
            </div>
            <div>
                <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}" required
                    class="border border-gray-300 p-2 rounded w-full">
            </div>
            <div>
                <label for="content">Content</label>
            </div>
            <div>
                <textarea name="content" id="content" class="border border-gray-300 p-2 rounded w-full"
                    required>{{ old('content', $post->content) }}</textarea>
            </div>
            <button type="submit"
                class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Submit</button>
        </form>
    </div>
</div>
@endsection