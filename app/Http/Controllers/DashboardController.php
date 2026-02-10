<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::user();
            
            // Carregar apenas os projetos do usuário logado
            $projects = $user->projects; 
            $totalProjects = $projects->count();
            
            // Contar tarefas por projeto (de forma simples)
            $projectIds = $projects->pluck('id')->toArray();
            $totalTasks = 0;
            $completedTasks = 0;
            $blockedTasks = 0;
            $inProgressTasks = 0;
            $pendingTasks = 0;
            
            if (!empty($projectIds)) {
                $totalTasks = Task::whereIn('project_id', $projectIds)->count();
                $completedTasks = Task::whereIn('project_id', $projectIds)->where('status', 'completed')->count();
                $blockedTasks = Task::whereIn('project_id', $projectIds)->where('status', 'blocked')->count();
                $inProgressTasks = Task::whereIn('project_id', $projectIds)->where('status', 'in_progress')->count();
                $pendingTasks = Task::whereIn('project_id', $projectIds)->where('status', 'pending')->count();
            }
            
            $completionPercentage = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;

            // Retornar uma view com dados básicos
            return view('dashboard', [
                'totalProjects' => $totalProjects,
                'totalTasks' => $totalTasks,
                'completedTasks' => $completedTasks,
                'blockedTasks' => $blockedTasks,
                'inProgressTasks' => $inProgressTasks,
                'pendingTasks' => $pendingTasks,
                'completionPercentage' => $completionPercentage,
                'projectsProgress' => collect(),
                'teamWorkload' => collect(),
                'overdueTasks' => collect(),
                'todayTasks' => collect(),
                'upcomingTasks' => collect()
            ]);
        } catch (\Exception $e) {
            Log::error('Dashboard Error: ' . $e->getMessage());
            // Em caso de erro, retornar uma view com dados mínimos para evitar o 500
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
    }
}
