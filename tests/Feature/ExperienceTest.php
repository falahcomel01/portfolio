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

        $response->assertRedirect('/login');
    }

    /**
     * Test 3: Data tersimpan di database (bukan cek tampilan)
     * Section experience tidak ditampilkan di publik,
     * tapi data tetap harus tersimpan dengan benar
     */
    public function test_experience_is_stored_in_database()
    {
        Experience::create([
            'company' => 'Microsoft',
            'location' => 'Redmond, USA',
            'period'   => '2024',
            'role'     => 'Software Engineer',
            'details'  => 'Mengembangkan teknologi masa depan.'
        ]);

        // Pastikan halaman publik tetap bisa diakses
        $response = $this->get('/');
        $response->assertStatus(200);

        // Pastikan data tersimpan di database
        $this->assertDatabaseHas('experiences', [
            'company' => 'Microsoft',
            'role'    => 'Software Engineer',
        ]);
    }

    /**
     * Test 4: Semua data tersimpan di database
     */
    public function test_all_experiences_stored_in_database()
    {
        Experience::create([
            'company' => 'Microsoft',
            'location' => 'USA',
            'period'   => '2024',
            'role'     => 'Software Engineer',
            'details'  => 'Detail Microsoft.'
        ]);

        Experience::create([
            'company' => 'Google',
            'location' => 'California',
            'period'   => '2023',
            'role'     => 'Backend Developer',
            'details'  => 'Detail Google.'
        ]);

        $this->assertDatabaseHas('experiences', ['company' => 'Microsoft']);
        $this->assertDatabaseHas('experiences', ['company' => 'Google']);
        $this->assertDatabaseCount('experiences', 2);
    }

    /**
     * Test 5: Database kosong ketika tidak ada data
     */
    public function test_experience_empty_when_no_data()
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $this->assertDatabaseCount('experiences', 0);
    }
}