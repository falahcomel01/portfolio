<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Experience;
use App\Models\Education;
use App\Models\Organization;
use App\Models\Project;
use Barryvdh\DomPDF\Facade\Pdf;

class FrontendController extends Controller
{
    public function index()
    {
        // Fungsi index jika diperlukan
    }

    public function downloadCv()
    {
        // 1. Ambil data dari Database
        $profile = About::first();

        // 2. Mapping data agar aman dan siap dikirim ke view
        $data = [
            'name' => $profile->name ?? 'Nama Anda',
            'title' => $profile->title ?? 'Job Title',
            'contact' => [
                'phone' => $profile->phone ?? '',
                'email' => $profile->email ?? '',
                'linkedin' => $profile->linkedin ?? '',
                'website' => $profile->website ?? '',
                'address' => $profile->address ?? '',
            ],
            'summary' => $profile->summary ?? '',
            
            // Ambil data dari tabel Experiences
            'work_experiences' => Experience::latest()->get()->map(function($item) {
                return [
                    'company' => $item->company,
                    'location' => $item->location,
                    'period' => $item->period,
                    'role' => $item->role,
                    'details' => $item->details
                ];
            })->toArray(),

            // Ambil data dari tabel Education
            'education' => Education::latest()->get()->map(function($item) {
                return [
                    'school' => $item->school,
                    'degree' => $item->degree,
                    'period' => $item->period,
                    'gpa' => $item->gpa
                ];
            })->toArray(),

            // Ambil data dari tabel Organizations
            'organizational' => Organization::latest()->get()->map(function($item) {
                return [
                    'org' => $item->org,
                    'period' => $item->period,
                    'role' => $item->role
                ];
            })->toArray(),
            
            'skills' => [
                'soft' => $profile->soft_skills ?? '',
                'hard' => $profile->hard_skills ?? '',
            ],
            
            // Ambil data dari tabel Projects
            'projects' => Project::orderBy('sort_order')->get(['title', 'description'])->toArray(),
        ];

        // 3. Generate PDF
        // Pastikan file resources/views/cv_template.blade.php sudah ada
        $pdf = PDF::loadView('cv_template', $data);
        
        return $pdf->download(($profile->name ?? 'CV') . '.pdf');
    }
}
