<?php

namespace Tests\Feature;

use App\Models\About;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ReleaseSmokeTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_and_cv_download_are_accessible(): void
    {
        About::query()->create([
            'name' => 'Ahmad Badrul Falah',
            'title' => 'Frontend Developer',
            'summary' => 'Portfolio summary',
            'content' => '<p>About content</p>',
        ]);

        $this->get('/')
            ->assertOk();

        $this->get('/forgot-password')
            ->assertOk();

        $this->get('/download-cv')
            ->assertOk()
            ->assertHeader('content-type', 'application/pdf');
    }

    public function test_admin_can_upload_settings_assets(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $response = $this
            ->actingAs($user)
            ->post(route('admin.settings.update'), [
                'name' => 'Ahmad Badrul Falah',
                'title' => 'Frontend Developer',
                'hero_desc' => 'Release smoke test description',
                'contact_desc' => 'Contact description',
                'hero_card_title' => 'Services',
                'hero_card_subtitle' => 'What I Build',
                'hero_card_items' => 'Web Development, UI Design',
                'hero_photo' => UploadedFile::fake()->image('hero-photo.jpg'),
                'avatar' => UploadedFile::fake()->image('avatar.jpg'),
                'favicon' => UploadedFile::fake()->image('favicon.png', 64, 64),
            ]);

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
            ]);

        $this->assertDatabaseHas('settings', ['key' => 'name', 'value' => 'Ahmad Badrul Falah']);
        $this->assertDatabaseHas('settings', ['key' => 'title', 'value' => 'Frontend Developer']);
        $this->assertDatabaseHas('settings', ['key' => 'hero_desc', 'value' => 'Release smoke test description']);

        $heroPath = \App\Models\Setting::where('key', 'hero_photo')->value('value');
        $avatarPath = \App\Models\Setting::where('key', 'avatar')->value('value');
        $faviconPath = \App\Models\Setting::where('key', 'favicon')->value('value');

        $this->assertNotNull($heroPath);
        $this->assertNotNull($avatarPath);
        $this->assertNotNull($faviconPath);

        Storage::disk('public')->assertExists($heroPath);
        Storage::disk('public')->assertExists($avatarPath);
        Storage::disk('public')->assertExists($faviconPath);
    }
}
