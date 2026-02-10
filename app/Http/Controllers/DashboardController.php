<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userProjectsIds = Auth::user()->projects->pluck("id")->toArray();

        $totalProjects = Project::whereIn('id', $userProjectsIds)->count();
        $totalTasks = Task::whereIn('project_id', $userProjectsIds)->count();
        $completedTasks = Task::whereIn('project_id', $userProjectsIds)->where("status", "completed")->count();
        $blockedTasks = Task::whereIn('project_id', $userProjectsIds)->where("status", "blocked")->count();
        $inProgressTasks = Task::whereIn('project_id', $userProjectsIds)->where("status", "in_progress")->count();
        $pendingTasks = Task::whereIn('project_id', $userProjectsIds)->where("status", "pending")->count();

        $completionPercentage = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;

        $projectsProgress = Project::whereIn('id', $userProjectsIds)->withCount([
            "tasks",
            "tasks as completed_tasks_count" => function ($query) {
                $query->where("status", "completed");
            },
        ])
            ->get()
            ->map(function ($project) {
                $project->progress = $project->tasks_count > 0
                    ? round(($project->completed_tasks_count / $project->tasks_count) * 100)
                    : 0;
                return $project;
            });

        // Carga de trabalho detalhada por usuário
        $teamWorkload = User::whereHas('projects', function ($query) use ($userProjectsIds) {
            $query->whereIn('projects.id', $userProjectsIds);
        })->withCount([
            "tasks as pending_count" => function ($query) { $query->where("status", "pending"); },
            "tasks as in_progress_count" => function ($query) { $query->where("status", "in_progress"); },
            "tasks as blocked_count" => function ($query) { $query->where("status", "blocked"); },
            "tasks as completed_count" => function ($query) { $query->where("status", "completed"); }
        ])->get();

        // Tarefas com prazos
        $overdueTasks = Task::whereIn('project_id', $userProjectsIds)
            ->whereNotNull('due_date')
            ->where("due_date", "<", now())
            ->where("status", "!=", "completed")
            ->get();

        $todayTasks = Task::whereIn('project_id', $userProjectsIds)
            ->whereNotNull('due_date')
            ->whereDate("due_date", now()->toDateString())
            ->where("status", "!=", "completed")
            ->get();

        $upcomingTasks = Task::whereIn('project_id', $userProjectsIds)
            ->whereNotNull('due_date')
            ->where("due_date", ">", now())
            ->where("due_date", "<=", now()->addDays(3))
            ->where("status", "!=", "completed")
            ->get();

        return view("dashboard", compact(
            "totalProjects",
            "totalTasks",
            "completedTasks",
            "blockedTasks",
            "inProgressTasks",
            "pendingTasks",
            "completionPercentage",
            "projectsProgress",
            "teamWorkload",
            "overdueTasks",
            "todayTasks",
            "upcomingTasks"
        ));
    }
}
