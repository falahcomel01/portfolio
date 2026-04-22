<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Experience;
use Tests\TestCase;

class ExperienceTest extends TestCase
{
    use RefreshDatabase; 

    /**
     * Test 1: Membuat Data (Functional Testing)
     */
    public function test_user_can_create_an_experience()
    {
        $data = [
            'company' => 'PT. Maju Jaya',
            'location' => 'Jakarta',
            'period'   => 'Jan 2023 - Sekarang',
            'role'     => 'Web Developer',
            'details'  => 'Membuat website keren.'
        ];

        Experience::create($data);

        $this->assertDatabaseHas('experiences', [
            'company' => 'PT. Maju Jaya',
        ]);
    }

    /**
     * Test 2: Keamanan (Authorization Testing)
     * Tamu tidak boleh akses halaman Admin
     */
    public function test_guest_cannot_access_experience_list()
    {
        $response = $this->get('/admin/experiences');

        // Pastikan redirect ke halaman login
        $response->assertRedirect('/login');
    }

    /**
     * Test 3: Tampilan Publik (Public View Testing)
     * Data dari admin harus muncul di halaman depan
     */
    public function test_experience_is_visible_on_homepage()
    {
        // 1. Buat data dummy di database
        $experience = Experience::create([
            'company' => 'Microsoft',
            'location' => 'Redmond, USA',
            'period'   => '2024',
            'role'     => 'Software Engineer',
            'details'  => 'Mengembangkan teknologi masa depan.'
        ]);

        // 2. Akses halaman utama portofolio
        // Pastikan '/' adalah URL halaman utamamu (biasanya begitu)
        $response = $this->get('/');

        // 3. Assertion: Pastikan nama perusahaan muncul di HTML halaman
        $response->assertSee('Microsoft');
        
        // (Opsional) Pastikan role juga muncul
        $response->assertSee('Software Engineer');
    }
}