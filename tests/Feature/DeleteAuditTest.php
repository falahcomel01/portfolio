<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\Project;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DeleteAuditTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_bulk_delete_only_unread_contacts(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);

        $unreadOne = Contact::create([
            'nama' => 'Unread One',
            'email' => 'unread1@example.com',
            'pesan' => 'First unread contact',
            'is_read' => false,
        ]);

        $unreadTwo = Contact::create([
            'nama' => 'Unread Two',
            'email' => 'unread2@example.com',
            'pesan' => 'Second unread contact',
            'is_read' => false,
        ]);

        $readContact = Contact::create([
            'nama' => 'Read Contact',
            'email' => 'read@example.com',
            'pesan' => 'Already read contact',
            'is_read' => true,
        ]);

        $response = $this
            ->actingAs($user)
            ->delete(route('admin.contacts.bulk-destroy'));

        $response->assertRedirect(route('admin.contacts'));

        $this->assertDatabaseMissing('contacts', ['id' => $unreadOne->id]);
        $this->assertDatabaseMissing('contacts', ['id' => $unreadTwo->id]);
        $this->assertDatabaseHas('contacts', ['id' => $readContact->id]);
        $this->assertDatabaseCount('contacts', 1);
    }

    public function test_project_delete_removes_database_row(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);

        $project = Project::create([
            'title' => 'Audit Project',
            'description' => 'Delete me safely',
            'tags' => 'laravel,testing',
            'thumbnail' => 'projects/audit-project.jpg',
            'sort_order' => 1,
        ]);

        $response = $this
            ->actingAs($user)
            ->delete(route('admin.projects.destroy', $project));

        $response->assertRedirect(route('admin.projects'));

        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }

    public function test_skill_delete_removes_database_row(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);

        $skill = Skill::create([
            'name' => 'Laravel',
            'description' => 'Delete icon and row',
            'tags' => 'php,backend',
            'icon_image' => 'skills/laravel.png',
            'sort_order' => 1,
        ]);

        $response = $this
            ->actingAs($user)
            ->delete(route('admin.skills.destroy', $skill));

        $response->assertRedirect(route('admin.skills'));

        $this->assertDatabaseMissing('skills', ['id' => $skill->id]);
    }

    public function test_profile_delete_cleans_user_sessions_and_reset_tokens(): void
    {
        $user = User::factory()->create();

        DB::table('password_reset_tokens')->insert([
            'email' => $user->email,
            'token' => 'hashed-token',
            'created_at' => now(),
        ]);

        DB::table('sessions')->insert([
            'id' => 'delete-audit-session',
            'user_id' => $user->id,
            'ip_address' => '127.0.0.1',
            'user_agent' => 'PHPUnit',
            'payload' => 'test-payload',
            'last_activity' => now()->timestamp,
        ]);

        $response = $this
            ->actingAs($user)
            ->delete('/profile', [
                'password' => 'password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/');

        $this->assertGuest();
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
        $this->assertDatabaseMissing('password_reset_tokens', ['email' => $user->email]);
        $this->assertDatabaseMissing('sessions', ['user_id' => $user->id]);
    }
}
