<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Contact;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Technology;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index', [
            'totalProjects' => Project::count(),
            'publishedProjects' => Project::where('status', 'published')->count(),
            'draftProjects' => Project::where('status', 'draft')->count(),
            'totalCategories' => Category::count(),
            'totalTechnologies' => Technology::count(),
            'totalSkills' => Skill::count(),
            'totalMessages' => Contact::count(),
            'unreadMessages' => Contact::where('is_read', false)->count(),
            'topSkills' => Skill::orderByDesc('level')->take(3)->get(),
            'categories' => Category::withCount('projects')->get(),
            'latestProjects' => Project::with('category')->latest()->take(5)->get(),
        ]);
    }
}