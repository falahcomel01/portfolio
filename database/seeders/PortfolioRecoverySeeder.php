<?php

namespace Database\Seeders;

use App\Models\About;
use App\Models\Certificate;
use App\Models\Project;
use App\Models\Setting;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PortfolioRecoverySeeder extends Seeder
{
    public function run(): void
    {
        if (User::count() === 0) {
            User::create([
                'name' => 'Admin Portfolio',
                'email' => 'admin@portfolio.local',
                'email_verified_at' => now(),
                'password' => Hash::make('Admin12345!'),
            ]);
        }

        if (Setting::count() === 0) {
            $settings = [
                'name' => 'Ahmad Badrul Falah',
                'title' => 'Ahmad Badrul Falah — Frontend Developer',
                'hero_badge' => 'Available for work',
                'hero_desc' => 'Frontend Developer yang berfokus pada UI modern, performa yang baik, dan pengalaman pengguna yang rapi.',
                'contact_desc' => 'Terbuka untuk freelance, kolaborasi, dan peluang full-time.',
                'hero_card_title' => 'Services',
                'hero_card_subtitle' => 'What I Build',
                'hero_card_items' => 'Web Development, UI Design, Mobile App Design',
                'avatar' => 'image/cX09cNKVCF2liJ8kuApKc5i4HVbVVdYUzWXquqIt.png',
                'avatar_link' => '#',
                'favicon' => 'image/6VjNnSqz30T1bDKVw4FTT6D3XMJ0bzUkrorjIEXn.png',
                'whatsapp' => '',
                'wa_message' => 'Halo! Saya tertarik dengan layanan Anda.',
                'github' => '',
                'linkedin' => '',
                'twitter' => '',
                'role' => 'Frontend Developer',
            ];

            foreach ($settings as $key => $value) {
                Setting::updateOrCreate(['key' => $key], ['value' => $value]);
            }
        }

        if (About::count() === 0) {
            About::updateOrCreate(
                ['id' => 1],
                [
                    'name' => 'Ahmad Badrul Falah',
                    'title' => 'Frontend Developer',
                    'summary' => 'Frontend Developer yang suka membangun antarmuka modern, cepat, dan mudah dipakai.',
                    'soft_skills' => 'Communication, Problem Solving, Teamwork',
                    'hard_skills' => 'Laravel, PHP, JavaScript, Tailwind CSS, Figma',
                    'content' => '<p>Halo! Saya <strong>Ahmad Badrul Falah</strong>, seorang Frontend Developer dengan passion yang dalam terhadap pengembangan antarmuka yang tidak hanya berfungsi - tapi juga terasa luar biasa digunakan.</p><p>Saya percaya bahwa <strong>desain dan kode adalah dua sisi yang sama</strong>. Setiap komponen yang saya buat mempertimbangkan performa, aksesibilitas, dan estetika secara bersamaan.</p><p>Ketika tidak sedang coding, saya suka mengeksplorasi design system baru, berkontribusi ke open source, dan mencari inspirasi dari dunia seni dan arsitektur.</p>',
                ]
            );
        }

        if (Skill::count() === 0) {
            $skills = [
                [
                    'name' => 'Node.js',
                    'description' => 'Runtime JavaScript untuk tooling dan backend ringan.',
                    'tags' => 'JavaScript, Backend, Tooling',
                    'icon_image' => 'skills/dIbJIGpCEzz1mH2CwoyTHTlijrlNhsqdvVeTAdfa.webp',
                    'sort_order' => 1,
                ],
                [
                    'name' => 'Tailwind CSS',
                    'description' => 'Utility-first CSS framework untuk UI yang cepat dan konsisten.',
                    'tags' => 'CSS, Utility First, Responsive',
                    'icon_image' => 'skills/ZGhlnLVGbxQZHBOzSVFTQ2cSLffRmp8GXy52iBis.webp',
                    'sort_order' => 2,
                ],
                [
                    'name' => 'Figma',
                    'description' => 'Desain interface dan prototyping untuk workflow produk modern.',
                    'tags' => 'UI Design, Prototype, Design System',
                    'icon_image' => 'skills/zi9hEAjQQo05OR2K2HhpowDo2FRCg5aNRXVPzIBb.png',
                    'sort_order' => 3,
                ],
            ];

            foreach ($skills as $skill) {
                Skill::create($skill);
            }
        }

        if (Project::count() === 0) {
            $projects = [
                [
                    'title' => 'Brawijaya Hospital App',
                    'description' => 'UI mobile untuk layanan rumah sakit, pencarian dokter, dan booking janji.',
                    'tags' => 'Mobile UI, Healthcare, UX',
                    'thumbnail' => 'projects/UYQxG6n6xCSbtEIms36NmBErghB4W6fps51b6uPJ.png',
                    'icon' => '🏥',
                    'url' => null,
                    'sort_order' => 1,
                ],
                [
                    'title' => 'Mamikos Boarding App',
                    'description' => 'Konsep aplikasi pencarian kos dengan nuansa dark UI dan listing properti.',
                    'tags' => 'Mobile UI, Property, App Design',
                    'thumbnail' => 'projects/ygv3d5ieq50yX4s2Kli8uPckpEhXLaMrBdR2pXPB.png',
                    'icon' => '🏠',
                    'url' => null,
                    'sort_order' => 2,
                ],
                [
                    'title' => 'Kenangan VIP Loyalty App',
                    'description' => 'Aplikasi loyalty program untuk reward, voucher, dan redeem benefit pengguna.',
                    'tags' => 'Loyalty, Mobile UI, Product Design',
                    'thumbnail' => 'projects/XEAXi5yjj4xmwERxeIZUmm6Bmg6MYRhl2VYHt1Mh.png',
                    'icon' => '☕',
                    'url' => null,
                    'sort_order' => 3,
                ],
            ];

            foreach ($projects as $project) {
                Project::create($project);
            }
        }

        if (Certificate::count() === 0) {
            $certificates = [
                [
                    'title' => 'Full Stack Web Developer',
                    'issuer' => 'Recovered Asset',
                    'issued_date' => '2026-04-08',
                    'image' => 'certificates/full-stack-web-developer-1775624617.png',
                    'url' => null,
                    'sort_order' => 1,
                ],
                [
                    'title' => 'Belajar Dasar AI',
                    'issuer' => 'Recovered Asset',
                    'issued_date' => '2026-04-08',
                    'image' => 'certificates/belajar-dasar-ai-1775626381.png',
                    'url' => null,
                    'sort_order' => 2,
                ],
                [
                    'title' => 'Certified Ethical Hacker',
                    'issuer' => 'Recovered Asset',
                    'issued_date' => '2026-04-13',
                    'image' => 'certificates/certified-ethical-hacker-1776057434.png',
                    'url' => null,
                    'sort_order' => 3,
                ],
            ];

            foreach ($certificates as $certificate) {
                Certificate::create($certificate);
            }
        }
    }
}
