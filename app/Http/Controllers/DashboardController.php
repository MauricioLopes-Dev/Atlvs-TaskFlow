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
        $totalProjects = Project::count();
        $totalTasks = Task::count();
        $completedTasks = Task::where("status", "completed")->count();
        $blockedTasks = Task::where("status", "blocked")->count();
        $inProgressTasks = Task::where("status", "in_progress")->count();
        $pendingTasks = Task::where("status", "pending")->count();

        $completionPercentage = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;

        $projectsProgress = Project::withCount([
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
        $teamWorkload = User::withCount([
            "tasks as pending_count" => function ($query) {
                $query->where("status", "pending");
            },
            "tasks as in_progress_count" => function ($query) {
                $query->where("status", "in_progress");
            },
            "tasks as blocked_count" => function ($query) {
                $query->where("status", "blocked");
            },
            "tasks as completed_count" => function ($query) {
                $query->where("status", "completed");
            },
        ])->get();

        // Tarefas com prazos
        $overdueTasks = Task::where("due_date", "<", now())
            ->where("status", "!=", "completed")
            ->whereIn(
                "project_id",
                Auth::user()->projects->pluck("id")
            )
            ->get();

        $todayTasks = Task::whereDate("due_date", now()->toDateString())
            ->where("status", "!=", "completed")
            ->whereIn(
                "project_id",
                Auth::user()->projects->pluck("id")
            )
            ->get();

        $upcomingTasks = Task::where("due_date", ">", now())
            ->where("due_date", "<=", now()->addDays(3))
            ->where("status", "!=", "completed")
            ->whereIn(
                "project_id",
                Auth::user()->projects->pluck("id")
            )
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
