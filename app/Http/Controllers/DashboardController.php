<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Carregar dados globais para todos os usuários autenticados
            $totalProjects = Project::count();
            $totalTasks = Task::count();
            $completedTasks = Task::where('status', 'completed')->count();
            $blockedTasks = Task::where('status', 'blocked')->count();
            $inProgressTasks = Task::where('status', 'in_progress')->count();
            $pendingTasks = Task::where('status', 'pending')->count();
            
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
