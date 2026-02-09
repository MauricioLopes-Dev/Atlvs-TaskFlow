<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProjects = Project::count();
        $totalTasks = Task::count();
        $completedTasks = Task::where('status', 'completed')->count();
        $blockedTasks = Task::where('status', 'blocked')->count();
        
        $completionPercentage = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;

        $projectsProgress = Project::withCount(['tasks', 'tasks as completed_tasks_count' => function ($query) {
            $query->where('status', 'completed');
        }])->get()->map(function ($project) {
            $project->progress = $project->tasks_count > 0 
                ? round(($project->completed_tasks_count / $project->tasks_count) * 100) 
                : 0;
            return $project;
        });

        $teamWorkload = User::withCount(['tasks' => function ($query) {
            $query->where('status', '!=', 'completed');
        }])->get();

        return view('dashboard', compact(
            'totalProjects', 
            'totalTasks', 
            'completedTasks', 
            'blockedTasks', 
            'completionPercentage',
            'projectsProgress',
            'teamWorkload'
        ));
    }
}
