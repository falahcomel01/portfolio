<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::orderBy('sort_order')->get();
        return view('admin.projects', compact('projects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'tags' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'icon' => 'nullable|string|max:10',
            'url' => 'nullable|url',
            'sort_order' => 'nullable|integer',
        ]);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('projects', 'public');
        }

        Project::create($validated);

        return redirect()->route('admin.projects')->with('success', 'Project berhasil ditambahkan!');
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'tags' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'icon' => 'nullable|string|max:10',
            'url' => 'nullable|url',
            'sort_order' => 'nullable|integer',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($project->thumbnail && Storage::disk('public')->exists($project->thumbnail)) {
                Storage::disk('public')->delete($project->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('projects', 'public');
        }

        $project->update($validated);

        return redirect()->route('admin.projects')->with('success', 'Project berhasil diperbarui!');
    }

    public function destroy(Project $project)
    {
        $thumbnailPath = $project->thumbnail;

        try {
            DB::transaction(function () use ($project) {
                $project->delete();
            });

            if ($thumbnailPath && Storage::disk('public')->exists($thumbnailPath)) {
                Storage::disk('public')->delete($thumbnailPath);
            }

            return redirect()->route('admin.projects')->with('success', 'Project berhasil dihapus!');
        } catch (Throwable $e) {
            report($e);

            return redirect()->route('admin.projects')->with('error', 'Project gagal dihapus. Silakan coba lagi.');
        }
    }
}
