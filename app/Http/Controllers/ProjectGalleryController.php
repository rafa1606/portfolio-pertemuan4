<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectGalleryController extends Controller
{
    private const MAX_IMAGES = 10;

    public function store(Request $request, Project $project)
    {
        $remaining = self::MAX_IMAGES - $project->images()->count();

        if ($remaining <= 0) {
            return back()->withErrors(['images' => 'Gallery sudah mencapai batas ' . self::MAX_IMAGES . ' gambar.']);
        }

        $request->validate([
            'images' => ['required', 'array', 'max:' . $remaining],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096', 'dimensions:min_width=800'],
        ], [
            'images.max' => "Sisa slot gallery hanya {$remaining} gambar.",
        ]);

        $order = (int) $project->images()->max('sort_order');

        foreach ($request->file('images') as $file) {
            $project->images()->create([
                'image' => $file->store('projects/gallery', 'public'),
                'sort_order' => ++$order,
            ]);
        }

        return back()->with('success', 'Gambar gallery berhasil ditambahkan.');
    }

    public function update(Request $request, Project $project, ProjectImage $image)
    {
        abort_if((int) $image->project_id !== (int) $project->id, 404);

        $validated = $request->validate([
            'caption' => 'nullable|string|max:255',
        ]);

        $image->update($validated);

        return back()->with('success', 'Caption diperbarui.');
    }

    public function destroy(Project $project, ProjectImage $image)
    {
        abort_if((int) $image->project_id !== (int) $project->id, 404);

        Storage::disk('public')->delete($image->image); // file fisik dulu
        $image->delete();                               // lalu baris database

        return back()->with('success', 'Gambar dihapus.');
    }
}
