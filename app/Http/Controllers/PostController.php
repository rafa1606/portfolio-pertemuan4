<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $perPage = in_array((int) $request->query('per_page'), [5, 10, 25])
            ? (int) $request->query('per_page')
            : 10;

        $query = Post::query();

        // Memakai scope published() kalau ada filter
        if ($request->query('filter') === 'published') {
            $query->published();
        }

        // Pencarian judul
        $search = trim((string) $request->query('q', ''));
        if ($search !== '') {
            $query->where('title', 'like', '%' . $search . '%');
        }

        $posts = $query->latest()->orderByDesc('id')
            ->paginate($perPage)
            ->withQueryString();

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
        ]);

        Post::create($validatedData);

        return redirect()->route('posts.index')
            ->with('success', 'Post berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $post = Post::findOrFail($id);
        return view('posts.detail', compact('post'));
    }

    public function edit(string $id)
    {
        $post = Post::findOrFail($id);
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
        ]);

        $post = Post::findOrFail($id);
        $post->update($validatedData);

        return redirect()->route('posts.index')
            ->with('success', 'Post berhasil diperbarui.');
    }

    // Karena model memakai SoftDeletes, delete() hanya mengisi kolom deleted_at
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('posts.index')
            ->with('success', 'Post dipindahkan ke Trash.');
    }

    public function trash()
    {
        $posts = Post::onlyTrashed()->latest('deleted_at')->get();
        return view('posts.trash', compact('posts'));
    }

    public function restore(string $id)
    {
        Post::onlyTrashed()->findOrFail($id)->restore();

        return redirect()->route('posts.trash')
            ->with('success', 'Post berhasil dipulihkan.');
    }

    public function forceDelete(string $id)
    {
        Post::onlyTrashed()->findOrFail($id)->forceDelete();

        return redirect()->route('posts.trash')
            ->with('success', 'Post dihapus permanen.');
    }
}
