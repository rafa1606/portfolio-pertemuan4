<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SkillController extends Controller
{
    public function index()
    {
        return view('admin.skills.index', [
            'skills' => Skill::orderByDesc('level')->get(),
        ]);
    }

    public function edit(Skill $skill)
    {
        return view('admin.skills.edit', compact('skill'));
    }

    public function update(Request $request, Skill $skill)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|integer|min:0|max:100',
        ]);

        $skill->update($validated);

        Cache::forget('portfolio.skills');

        return redirect()->route('admin.skills.index')
            ->with('success', 'Skill berhasil diperbarui.');
    }
}
