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
        try {
            $user = Auth::user();
            
            // Obter IDs dos projetos do usuário
            $userProjects = $user->projects; // Carrega os projetos do usuário
            $userProjectsIds = $userProjects->pluck(\'id\')->toArray();           
            // Se não houver projetos, retornar dados vazios
            if (empty($userProjectsIds)) {
                return view('dashboard', [
                    'totalProjects' => 0,
                    'totalTasks' => 0,
                    'completedTasks' => 0,
                    'blockedTasks' => 0,
                    'inProgressTasks' => 0,
                    'pendingTasks' => 0,
                    'completionPercentage' => 0,
                    'projectsProgress' => collect(),
                    'teamWorkload' => collect(),
                    'overdueTasks' => collect(),
                    'todayTasks' => collect(),
                    'upcomingTasks' => collect()
                ]);
            }

            // Contar tarefas por status
            $totalProjects = count($userProjectsIds);
            $totalTasks = Task::whereIn('project_id', $userProjectsIds)->count();
            $completedTasks = Task::whereIn('project_id', $userProjectsIds)->where("status", "completed")->count();
            $blockedTasks = Task::whereIn('project_id', $userProjectsIds)->where("status", "blocked")->count();
            $inProgressTasks = Task::whereIn('project_id', $userProjectsIds)->where("status", "in_progress")->count();
            $pendingTasks = Task::whereIn('project_id', $userProjectsIds)->where("status", "pending")->count();

            $completionPercentage = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;

            // Progresso dos projetos
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

            // Carga de trabalho da equipe
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
                ->whereRaw('due_date < NOW()')
                ->where("status", "!=", "completed")
                ->orderBy('due_date', 'asc')
                ->get();

            $todayTasks = Task::whereIn('project_id', $userProjectsIds)
                ->whereNotNull('due_date')
                ->whereDate("due_date", now()->toDateString())
                ->where("status", "!=", "completed")
                ->orderBy('due_date', 'asc')
                ->get();

            $upcomingTasks = Task::whereIn('project_id', $userProjectsIds)
                ->whereNotNull('due_date')
                ->whereRaw('due_date > NOW()')
                ->whereRaw('due_date <= DATE_ADD(NOW(), INTERVAL 3 DAY)')
                ->where("status", "!=", "completed")
                ->orderBy('due_date', 'asc')
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
        } catch (\Exception $e) {
            \Log::error('Dashboard Error: ' . $e->getMessage());
            return view("dashboard", [
                'totalProjects' => 0,
                'totalTasks' => 0,
                'completedTasks' => 0,
                'blockedTasks' => 0,
                'inProgressTasks' => 0,
                'pendingTasks' => 0,
                'completionPercentage' => 0,
                'projectsProgress' => collect(),
                'teamWorkload' => collect(),
                'overdueTasks' => collect(),
                'todayTasks' => collect(),
                'upcomingTasks' => collect()
            ]);
        }
    }
}
