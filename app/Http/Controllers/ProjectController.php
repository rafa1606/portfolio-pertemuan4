<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Project;
use App\Models\Technology;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        // abaikan parameter kosong atau berbentuk array
        $search = is_string($request->query('search')) && trim($request->query('search')) !== ''
            ? trim($request->query('search'))
            : null;
        $status = in_array($request->query('status'), ['draft', 'published'], true)
            ? $request->query('status')
            : null;

        $projects = Project::with('category')
            ->withCount('images')
            ->when($search, function ($query, $search) {
                // orWhere dibungkus supaya filter status tidak ikut terbypass
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('short_description', 'like', "%{$search}%");
                });
            })
            ->when($status, fn ($query, $status) => $query->where('status', $status))
            ->latest()
            ->orderByDesc('id') // pembeda urutan kalau created_at sama, supaya paginasi stabil
            ->paginate(10)
            ->withQueryString();

        return view('admin.projects.index', compact('projects', 'search'));
    }

    public function create()
    {
        return view('admin.projects.create', [
            'categories' => Category::all(),
            'technologies' => Technology::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $technologies = $validated['technologies'] ?? [];
        unset($validated['thumbnail'], $validated['technologies']); // thumbnail dan pivot ditangani terpisah

        $validated['slug'] = $this->buatSlug($validated['name']);
        $validated['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')
                ->store('projects/thumbnails', 'public');
        }

        $project = Project::create($validated);
        $project->technologies()->attach($technologies);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project berhasil ditambahkan.');
    }

    public function edit(Project $project)
    {
        return view('admin.projects.edit', [
            'project' => $project->load('technologies'),
            'categories' => Category::all(),
            'technologies' => Technology::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate($this->rules($project));

        $technologies = $validated['technologies'] ?? [];
        unset($validated['thumbnail'], $validated['technologies']); // tanpa ini, thumbnail lama bisa terhapus jadi null

        // slug hanya dibuat ulang kalau nama berubah
        if ($validated['name'] !== $project->name) {
            $validated['slug'] = $this->buatSlug($validated['name'], $project->id);
        }
        $validated['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('thumbnail')) {
            if ($project->thumbnail) {
                Storage::disk('public')->delete($project->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')
                ->store('projects/thumbnails', 'public');
        }

        $project->update($validated);
        $project->technologies()->sync($technologies); // kosong berarti semua relasi dilepas

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

        $project->delete(); // baris project_images dan pivot ikut hilang (cascadeOnDelete)

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project dihapus.');
    }

    private function rules(?Project $project = null): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('projects', 'name')->ignore($project),
            ],
            'category_id' => 'required|exists:categories,id',
            'short_description' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:draft,published',
            'project_date' => 'nullable|date',
            'project_url' => 'nullable|url|max:255',
            'repository_url' => 'nullable|url|max:255',
            'technologies' => 'nullable|array',
            'technologies.*' => 'exists:technologies,id',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
                .'|dimensions:min_width=400,min_height=300',
        ];
    }

    // slug dari nama, ditambah -2, -3, dst kalau sudah dipakai project lain
    private function buatSlug(string $name, ?int $abaikanId = null): string
    {
        $dasar = Str::slug($name) ?: 'project';
        $slug = $dasar;
        $urutan = 2;

        while (Project::where('slug', $slug)
            ->when($abaikanId, fn ($q) => $q->where('id', '!=', $abaikanId))
            ->exists()) {
            $slug = $dasar.'-'.$urutan++;
        }

        return $slug;
    }
}
