<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::orderBy('sort_order')->get();
        return view('admin.skills', compact('skills'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'tags' => 'nullable|string',
            'icon_image' => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:512',
            'sort_order' => 'nullable|integer',
        ]);

        if ($request->hasFile('icon_image')) {
            $validated['icon_image'] = $request->file('icon_image')->store('skills', 'public');
        }

        Skill::create($validated);

        return redirect()->route('admin.skills')->with('success', 'Skill berhasil ditambahkan!');
    }

    public function update(Request $request, Skill $skill)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'tags' => 'nullable|string',
            'icon_image' => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:512',
            'sort_order' => 'nullable|integer',
        ]);

        if ($request->hasFile('icon_image')) {
            // Hapus gambar lama
            if ($skill->icon_image && Storage::disk('public')->exists($skill->icon_image)) {
                Storage::disk('public')->delete($skill->icon_image);
            }
            $validated['icon_image'] = $request->file('icon_image')->store('skills', 'public');
        }

        $skill->update($validated);

        return redirect()->route('admin.skills')->with('success', 'Skill berhasil diperbarui!');
    }

    public function destroy(Skill $skill)
    {
        if ($skill->icon_image && Storage::disk('public')->exists($skill->icon_image)) {
            Storage::disk('public')->delete($skill->icon_image);
        }
        $skill->delete();

        return redirect()->route('admin.skills')->with('success', 'Skill berhasil dihapus!');
    }
}