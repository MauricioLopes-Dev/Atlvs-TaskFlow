<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProjectImagePersistenceTest extends TestCase
{
    use RefreshDatabase;

    public function test_project_image_upload_persists_using_configured_disk(): void
    {
        config(['filesystems.disks.projects' => [
            'driver' => 'local',
            'root' => storage_path('framework/testing/disks/projects'),
            'url' => 'http://localhost/storage/projects',
            'visibility' => 'public',
            'throw' => false,
        ]]);

        Storage::fake('projects');
        config(['taskflow.project_images_disk' => 'projects']);

        $user = User::factory()->create(['email_verified_at' => now()]);

        $response = $this->actingAs($user)->post(route('projects.store'), [
            'name' => 'Projeto com Capa Persistente',
            'description' => 'Desc',
            'image' => UploadedFile::fake()->image('capa.png'),
        ]);

        $response->assertRedirect(route('projects.index'));

        $project = Project::query()->latest('id')->first();

        $this->assertNotNull($project);
        $this->assertSame('projects', $project->image_disk);
        $this->assertNotNull($project->image_path);
        Storage::disk('projects')->assertExists($project->image_path);
    }

    public function test_updating_cover_replaces_file_on_same_disk(): void
    {
        config(['filesystems.disks.projects' => [
            'driver' => 'local',
            'root' => storage_path('framework/testing/disks/projects'),
            'url' => 'http://localhost/storage/projects',
            'visibility' => 'public',
            'throw' => false,
        ]]);

        Storage::fake('projects');
        config(['taskflow.project_images_disk' => 'projects']);

        $owner = User::factory()->create(['email_verified_at' => now()]);

        $project = Project::create([
            'name' => 'Projeto X',
            'description' => null,
            'owner_id' => $owner->id,
            'image_path' => UploadedFile::fake()->image('old.png')->store('projects', 'projects'),
            'image_disk' => 'projects',
        ]);

        $oldImagePath = $project->image_path;

        $response = $this->actingAs($owner)->patch(route('projects.update', $project), [
            'name' => 'Projeto X',
            'description' => 'Atualizado',
            'image' => UploadedFile::fake()->image('new.png'),
        ]);

        $response->assertRedirect(route('projects.index'));

        $project->refresh();

        $this->assertSame('projects', $project->image_disk);
        $this->assertNotEquals($oldImagePath, $project->image_path);
        Storage::disk('projects')->assertMissing($oldImagePath);
        Storage::disk('projects')->assertExists($project->image_path);
    }
}