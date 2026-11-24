<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Technology;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PortfolioController extends Controller
{
    public function home()
    {
        $featured = Cache::remember('portfolio.featured', 1800, fn () =>
            Project::with('category')
                ->where('status', 'published')
                ->where('is_featured', true)
                ->latest()->take(6)->get());

        $skills = Cache::remember('portfolio.skills', 3600, fn () =>
            Skill::orderBy('name')->get());

        return view('home', compact('featured', 'skills'));
    }

    public function projects(Request $request)
    {
        $search = $this->param($request, 'search');
        $category = $this->param($request, 'category');
        $technology = $this->param($request, 'technology');

        $query = Project::with('category', 'technologies')
            ->where('status', 'published')
            ->when($search, function ($query, $search) {
                // orWhere dibungkus satu grup supaya filter status tidak bocor
                $query->where(function ($w) use ($search) {
                    $w->where('name', 'like', "%{$search}%")
                        ->orWhere('short_description', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($category, fn ($q, $c) => $q->whereHas('category', fn ($w) => $w->where('slug', $c)))
            ->when($technology, fn ($q, $t) => $q->whereHas('technologies', fn ($w) => $w->where('slug', $t)));

        // orderBy('id') di akhir sebagai pembeda urutan supaya paginasi tetap stabil
        match ($this->param($request, 'sort')) {
            'terlama' => $query->oldest()->orderBy('id'),
            'az', 'judul' => $query->orderBy('name')->orderBy('id'),
            'tanggal' => $query->orderByRaw('project_date is null')->orderByDesc('project_date')->orderByDesc('id'),
            default => $query->latest()->orderByDesc('id'),
        };

        return view('projects', [
            'projects' => $query->paginate(9)->withQueryString(),
            'search' => $search,
            'categories' => Cache::remember('portfolio.categories', 3600, fn () =>
                Category::orderBy('name')->get()),
            'technologies' => Technology::orderBy('name')->get(),
        ]);
    }

    public function show(Project $project)
    {
        abort_if($project->status !== 'published', 404); // draft tidak tampil di publik

        $project->load(['category', 'technologies', 'images']);

        return view('projects.show', compact('project'));
    }

    // ambil query string sebagai teks, abaikan kalau kosong atau berbentuk array
    private function param(Request $request, string $key): ?string
    {
        $value = $request->query($key);

        return is_string($value) && trim($value) !== '' ? trim($value) : null;
    }
}