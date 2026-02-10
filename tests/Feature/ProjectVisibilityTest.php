<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectVisibilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_see_projects_created_by_other_users_in_index(): void
    {
        $owner = User::factory()->create(['email_verified_at' => now()]);
        $viewer = User::factory()->create(['email_verified_at' => now()]);

        Project::create([
            'name' => 'Projeto Compartilhado',
            'description' => 'Projeto visível para todos',
            'owner_id' => $owner->id,
        ]);

        $response = $this->actingAs($viewer)->get(route('projects.index'));

        $response->assertOk();
        $response->assertSee('Projeto Compartilhado');
    }

    public function test_non_owner_cannot_edit_or_delete_project(): void
    {
        $owner = User::factory()->create(['email_verified_at' => now()]);
        $otherUser = User::factory()->create(['email_verified_at' => now()]);

        $project = Project::create([
            'name' => 'Projeto Privado de Edição',
            'description' => null,
            'owner_id' => $owner->id,
        ]);

        $this->actingAs($otherUser)
            ->get(route('projects.edit', $project))
            ->assertForbidden();

        $this->actingAs($otherUser)
            ->delete(route('projects.destroy', $project))
            ->assertForbidden();
    }

    public function test_user_can_update_status_of_task_from_project_created_by_other_user(): void
    {
        $owner = User::factory()->create(['email_verified_at' => now()]);
        $teammate = User::factory()->create(['email_verified_at' => now()]);

        $project = Project::create([
            'name' => 'Projeto Equipe',
            'description' => 'Projeto da equipe',
            'owner_id' => $owner->id,
        ]);

        $task = Task::create([
            'title' => 'Revisar fluxo',
            'description' => 'Descrição',
            'priority' => 'medium',
            'status' => 'pending',
            'project_id' => $project->id,
        ]);

        $response = $this->actingAs($teammate)
            ->patch(route('tasks.updateStatus', $task), [
                'status' => 'in_progress',
            ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'status' => 'in_progress',
        ]);
    }

    public function test_user_can_comment_on_task_from_project_created_by_other_user(): void
    {
        $owner = User::factory()->create(['email_verified_at' => now()]);
        $teammate = User::factory()->create(['email_verified_at' => now()]);

        $project = Project::create([
            'name' => 'Projeto Comentável',
            'description' => 'Projeto aberto para comentários',
            'owner_id' => $owner->id,
        ]);

        $task = Task::create([
            'title' => 'Ajustar dashboard',
            'description' => 'Descrição',
            'priority' => 'medium',
            'status' => 'pending',
            'project_id' => $project->id,
        ]);

        $response = $this->actingAs($teammate)
            ->post(route('comments.store', $task), [
                'content' => 'Posso assumir essa tarefa hoje.',
            ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('comments', [
            'task_id' => $task->id,
            'user_id' => $teammate->id,
            'content' => 'Posso assumir essa tarefa hoje.',
        ]);
    }
}