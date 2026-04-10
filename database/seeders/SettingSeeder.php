<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;
use App\Models\About;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'name' => 'Ahmad Badrul Falah',
            'title' => 'Ahmad Badrul Falah — Frontend Developer',
            'meta_description' => 'Frontend Developer passionate about creating beautiful and functional web experiences.',
            'favicon' => '',
            'avatar' => 'image/fotosaya.png',
            'avatar_link' => '#',
            'hero_desc' => 'Frontend Developer passionate about creating beautiful, responsive, and user-friendly web experiences.',
            'contact_desc' => 'Punya project menarik? Saya selalu terbuka untuk kolaborasi, freelance, maupun full-time opportunity.',
            'whatsapp' => '6281234567890',
            'github' => 'https://github.com/',
            'linkedin' => 'https://linkedin.com/in/',
            'twitter' => '',
            'dribbble' => '',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        About::updateOrCreate(['id' => 1], [
            'content' => '<p>Halo! Saya <strong>Ahmad Badrul Falah</strong>, seorang Frontend Developer dengan passion yang dalam terhadap pengembangan antarmuka yang tidak hanya berfungsi — tapi juga terasa luar biasa digunakan.</p><p>Saya percaya bahwa <strong>desain dan kode adalah dua sisi yang sama</strong>. Setiap komponen yang saya buat mempertimbangkan performa, aksesibilitas, dan estetika secara bersamaan.</p><p>Ketika tidak sedang coding, saya suka mengeksplorasi design system baru, berkontribusi ke open source, dan mencari inspirasi dari dunia seni dan arsitektur.</p>'
        ]);
    }
}