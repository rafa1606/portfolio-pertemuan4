<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index()
    {
        return view('admin.projects.index', [
            'projects' => Project::with('category')->withCount('images')->latest()->get(),
        ]);
    }

    public function create()
    {
        return view('admin.projects.create', [
            'categories' => Category::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());
        unset($validated['thumbnail']); // jangan ikut tersimpan sebagai null/objek file

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')
                ->store('projects/thumbnails', 'public');
        }

        Project::create($validated);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project berhasil ditambahkan.');
    }

    public function edit(Project $project)
    {
        return view('admin.projects.edit', [
            'project' => $project,
            'categories' => Category::all(),
        ]);
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate($this->rules());
        unset($validated['thumbnail']); // tanpa ini, thumbnail lama bisa terhapus jadi null

        if ($request->hasFile('thumbnail')) {
            if ($project->thumbnail) {
                Storage::disk('public')->delete($project->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')
                ->store('projects/thumbnails', 'public');
        }

        $project->update($validated);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project berhasil diperbarui.');
    }

    public function destroy(Project $project)
    {
        if ($project->thumbnail) {
            Storage::disk('public')->delete($project->thumbnail);
        }

        foreach ($project->images as $image) {
            Storage::disk('public')->delete($image->image);
        }

        $project->delete(); // baris project_images ikut hilang (cascadeOnDelete)

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project dihapus.');
    }

    private function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'status' => 'required|in:draft,published',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
                . '|dimensions:min_width=400,min_height=300',
        ];
    }
}
