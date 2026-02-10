<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KanbanController extends Controller
{
    public function index()
    {
        $projects = Auth::user()->projects; // Ou todos os projetos que o usuário tem acesso
        $tasksByStatus = [];

        foreach (["pending", "in_progress", "blocked", "completed"] as $status) {
            $tasksByStatus[$status] = Task::whereIn(
                'project_id',
                $projects->pluck('id')
            )->where('status', $status)->orderBy('priority', 'desc')->get();
        }

        return view('kanban.index', compact('tasksByStatus', 'projects'));
    }

    public function updateTaskStatus(Request $request, Task $task)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,blocked,completed',
        ]);

        $oldStatus = $task->status;
        $task->update(['status' => $request->status]);

        if ($oldStatus != $task->status) {
            ActivityLog::create([
                'task_id' => $task->id,
                'user_id' => Auth::id(),
                'action' => 'status_change',
                'description' => "alterou o status para " . $this->translateStatus($task->status),
                'changes' => ['from' => $oldStatus, 'to' => $task->status]
            ]);
        }

        return response()->json(['message' => 'Status da tarefa atualizado com sucesso!']);
    }

    private function translateStatus($status)
    {
        $map = [
            'pending' => 'Pendente',
            'in_progress' => 'Em Andamento',
            'blocked' => 'Travado',
            'completed' => 'Concluído'
        ];
        return $map[$status] ?? $status;
    }
}
