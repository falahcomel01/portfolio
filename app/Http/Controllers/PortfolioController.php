<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\About;
use App\Models\Skill;
use App\Models\Project;
use App\Models\Contact;
class PortfolioController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        $about = About::first();
        $skills = Skill::orderBy('sort_order')->get();
        $projects = Project::orderBy('sort_order')->get();
         $certificates = \App\Models\Certificate::orderBy('sort_order', 'asc')
    ->orderBy('issued_date', 'desc')
    ->get();

    return view('portfolio', compact(
    'settings',
    'about',
    'skills',
    'projects',
    'certificates'
));
    }

    public function contactSend(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'pesan' => 'required|string|min:10',
        ]);

        Contact::create($validated);

        return redirect()->route('portfolio')->with('success', 'Pesan berhasil dikirim! Saya akan segera merespons.');
    }
}