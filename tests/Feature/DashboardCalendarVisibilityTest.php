<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardCalendarVisibilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_counts_global_data_for_authenticated_user(): void
    {
        $owner = User::factory()->create(['email_verified_at' => now()]);
        $viewer = User::factory()->create(['email_verified_at' => now()]);

        $projectA = Project::create([
            'name' => 'Projeto A',
            'description' => null,
            'owner_id' => $owner->id,
        ]);

        $projectB = Project::create([
            'name' => 'Projeto B',
            'description' => null,
            'owner_id' => $owner->id,
        ]);

        Task::create([
            'title' => 'Task pending',
            'description' => null,
            'priority' => 'medium',
            'status' => 'pending',
            'project_id' => $projectA->id,
        ]);

        Task::create([
            'title' => 'Task completed',
            'description' => null,
            'priority' => 'medium',
            'status' => 'completed',
            'project_id' => $projectA->id,
        ]);

        Task::create([
            'title' => 'Task blocked',
            'description' => null,
            'priority' => 'medium',
            'status' => 'blocked',
            'project_id' => $projectB->id,
        ]);

        Task::create([
            'title' => 'Task in progress',
            'description' => null,
            'priority' => 'medium',
            'status' => 'in_progress',
            'project_id' => $projectB->id,
        ]);

        $response = $this->actingAs($viewer)->get(route('dashboard'));

        $response->assertOk();
        $response->assertViewHas('totalProjects', 2);
        $response->assertViewHas('totalTasks', 4);
        $response->assertViewHas('completedTasks', 1);
        $response->assertViewHas('blockedTasks', 1);
        $response->assertViewHas('inProgressTasks', 1);
        $response->assertViewHas('pendingTasks', 1);
    }

    public function test_calendar_returns_events_from_all_projects_for_authenticated_user(): void
    {
        $owner = User::factory()->create(['email_verified_at' => now()]);
        $viewer = User::factory()->create(['email_verified_at' => now()]);

        $project = Project::create([
            'name' => 'Projeto Compartilhado',
            'description' => null,
            'owner_id' => $owner->id,
        ]);

        $task = Task::create([
            'title' => 'Entrega geral',
            'description' => null,
            'priority' => 'high',
            'status' => 'pending',
            'project_id' => $project->id,
            'due_date' => now()->addDay(),
        ]);

        $response = $this->actingAs($viewer)->post(route('calendar.getEvents'), [
            'start' => now()->startOfMonth()->format('Y-m-d'),
            'end' => now()->endOfMonth()->format('Y-m-d'),
        ]);

        $response->assertOk();
        $response->assertJsonFragment([
            'id' => $task->id,
            'title' => 'Entrega geral',
            'url' => route('projects.show', $project->id),
        ]);
    }
}