<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $category = $request->query('category');

        $projects = Project::with(['category', 'technologies'])
            ->where('status', 'published')
            ->when(is_string($search) && trim($search) !== '', function ($query) use ($search) {
                $search = trim($search);
                // orWhere dibungkus satu grup supaya filter status tidak bocor
                $query->where(fn ($w) => $w->where('name', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%"));
            })
            ->when(is_string($category) && $category !== '', fn ($query) => $query
                ->whereHas('category', fn ($w) => $w->where('slug', $category)))
            ->latest()
            ->orderByDesc('id')
            ->paginate(9)
            ->withQueryString(); // link halaman berikutnya tetap membawa filter

        return ProjectResource::collection($projects);
    }

    public function show(Project $project)
    {
        // project draft tidak boleh bocor lewat API
        abort_if($project->status !== 'published', 404);

        return new ProjectResource($project->load(['category', 'technologies']));
    }
}