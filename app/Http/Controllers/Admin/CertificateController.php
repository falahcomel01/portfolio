<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CertificateController extends Controller
{
    public function index(Request $request)
    {
        $query = Certificate::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('issuer', 'like', "%{$search}%");
            });
        }

        $certificates = $query->orderBy('sort_order', 'asc')
                              ->orderBy('issued_date', 'desc')
                              ->paginate(10)
                              ->withQueryString();

        $totalCertificates = Certificate::count();
        $withUrl = Certificate::whereNotNull('url')->where('url', '!=', '')->count();

        try {
            $latestDate = Certificate::orderBy('issued_date', 'desc')->value('issued_date');
            $latestLabel = $latestDate ? \Carbon\Carbon::parse($latestDate)->format('M Y') : '-';
        } catch (\Exception $e) {
            $latestLabel = '-';
        }

        return view('admin.certificate', compact('certificates', 'totalCertificates', 'withUrl', 'latestLabel'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'issuer'       => 'required|string|max:255',
            'issued_date'  => 'required|date',
            'image'        => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'url'          => 'nullable|url|max:500',
            'sort_order'   => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = Str::slug($validated['title']) . '-' . time() . '.' . $file->getClientOriginalExtension();
            $validated['image'] = $file->storeAs('certificates', $filename, 'public');
        }

        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        Certificate::create($validated);

        return redirect()
            ->route('admin.certificates.index')
            ->with('success', 'Sertifikat berhasil ditambahkan.');
    }

    public function update(Request $request, Certificate $certificate)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'issuer'       => 'required|string|max:255',
            'issued_date'  => 'required|date',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'url'          => 'nullable|url|max:500',
            'sort_order'   => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('image')) {
            if ($certificate->image && Storage::disk('public')->exists($certificate->image)) {
                Storage::disk('public')->delete($certificate->image);
            }
            $file = $request->file('image');
            $filename = Str::slug($validated['title']) . '-' . time() . '.' . $file->getClientOriginalExtension();
            $validated['image'] = $file->storeAs('certificates', $filename, 'public');
        }

        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $certificate->update($validated);

        return redirect()
            ->route('admin.certificates.index')
            ->with('success', 'Sertifikat berhasil diperbarui.');
    }

    public function destroy(Certificate $certificate)
    {
        if ($certificate->image && Storage::disk('public')->exists($certificate->image)) {
            Storage::disk('public')->delete($certificate->image);
        }

        $certificate->delete();

        return redirect()
            ->route('admin.certificates.index')
            ->with('success', 'Sertifikat berhasil dihapus.');
    }
}