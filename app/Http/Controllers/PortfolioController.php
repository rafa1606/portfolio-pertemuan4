<?php

namespace App\Http\Controllers;

use App\Models\Project;

class PortfolioController extends Controller
{
    public function projects()
    {
        return view('projects', [
            'projects' => Project::with('category')
                ->where('status', 'published')
                ->latest()
                ->get(),
        ]);
    }

    public function show(Project $project)
    {
        abort_if($project->status !== 'published', 404); // draft tidak tampil di publik

        $project->load(['category', 'images']);

        return view('projects.show', compact('project'));
    }
}
