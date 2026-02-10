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

            // Retornar uma view básica com o total de projetos
            return view('dashboard', [
                'totalProjects' => $totalProjects,
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
        } catch (\Exception $e) {
            Log::error('Dashboard Error (Simplified): ' . $e->getMessage());
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
