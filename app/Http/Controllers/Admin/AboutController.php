<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $about = About::first();
        return view('admin.about', compact('about'));
    }

       public function update(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        About::updateOrCreate(['id' => 1], $validated);

        // --- PERBAIKAN DI SINI ---
        // Kembalikan respons JSON agar bisa dibaca oleh JavaScript
        return response()->json([
            'success' => true,
            'message' => 'About berhasil diperbarui!'
        ]);
    }
}