<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Experience;
use App\Models\Education;
use App\Models\Organization;
use Illuminate\Http\Request;

class CvBuilderController extends Controller
{
    public function index()
    {
        $profile = About::firstOrNew();
        return view('admin.cv_builder', compact('profile'));
    }

    public function updateProfile(Request $request)
    {
        About::updateOrCreate(
            ['id' => 1], // Asumsikan hanya ada 1 profil
            $request->only(['name', 'title', 'phone', 'email', 'linkedin', 'website', 'address', 'summary', 'soft_skills', 'hard_skills'])
        );
        return back()->with('success', 'Profile updated!');
    }
}