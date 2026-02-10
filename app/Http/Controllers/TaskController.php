<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use App\Models\ActivityLog;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    public function create(Request $request)
    {
        $project = Project::findOrFail($request->project_id);
        $users = User::all();
        return view('tasks.create', compact('project', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in_progress,blocked,completed',
            'project_id' => 'required|exists:projects,id',
            'assigned_to' => 'nullable|exists:users,id',
            'due_date' => 'nullable|date',
            'figma_link' => 'nullable|url',
            'repo_link' => 'nullable|url',
            'staging_link' => 'nullable|url',
        ]);

        $task = Task::create($validated);

        // Log de criação
        ActivityLog::create([
            'task_id' => $task->id,
            'user_id' => Auth::id(),
            'action' => 'created',
            'description' => 'criou a tarefa',
        ]);

        // Notificar responsável
        if ($task->assigned_to && $task->assigned_to != Auth::id()) {
            $this->notifyUser($task->assigned_to, "Você foi atribuído à tarefa: {$task->title}", route('projects.show', $task->project_id));
        }

        return redirect()->route('projects.show', $request->project_id)->with('success', 'Tarefa criada com sucesso!');
    }

    public function edit(Task $task)
    {
        $users = User::all();
        return view('tasks.edit', compact('task', 'users'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in_progress,blocked,completed',
            'assigned_to' => 'nullable|exists:users,id',
            'due_date' => 'nullable|date',
            'figma_link' => 'nullable|url',
            'repo_link' => 'nullable|url',
            'staging_link' => 'nullable|url',
        ]);

        $oldStatus = $task->status;
        $oldAssignee = $task->assigned_to;

        $task->update($validated);

        // Log de mudança de status
        if ($oldStatus != $task->status) {
            ActivityLog::create([
                'task_id' => $task->id,
                'user_id' => Auth::id(),
                'action' => 'status_change',
                'description' => "alterou o status para " . $this->translateStatus($task->status),
                'changes' => ['from' => $oldStatus, 'to' => $task->status]
            ]);

            if ($task->assigned_to && $task->assigned_to != Auth::id()) {
                $this->notifyUser($task->assigned_to, "O status da tarefa '{$task->title}' mudou para " . $this->translateStatus($task->status), route('projects.show', $task->project_id));
            }
        }

        // Log de mudança de responsável
        if ($oldAssignee != $task->assigned_to) {
            $newAssigneeName = $task->assignee ? $task->assignee->name : 'Ninguém';
            ActivityLog::create([
                'task_id' => $task->id,
                'user_id' => Auth::id(),
                'action' => 'assigned',
                'description' => "atribuiu a tarefa a {$newAssigneeName}",
            ]);

            if ($task->assigned_to && $task->assigned_to != Auth::id()) {
                $this->notifyUser($task->assigned_to, "Você foi atribuído à tarefa: {$task->title}", route('projects.show', $task->project_id));
            }
        }

        return redirect()->route('projects.show', $task->project_id)->with('success', 'Tarefa atualizada com sucesso!');
    }

    public function destroy(Task $task)
    {
        $projectId = $task->project_id;
        $task->delete();
        return redirect()->route('projects.show', $projectId)->with('success', 'Tarefa excluída com sucesso!');
    }

    public function updateStatus(Request $request, Task $task)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,blocked,completed',
        ]);

        $oldStatus = $task->status;
        $task->update($validated);

        if ($oldStatus != $task->status) {
            ActivityLog::create([
                'task_id' => $task->id,
                'user_id' => Auth::id(),
                'action' => 'status_change',
                'description' => "alterou o status para " . $this->translateStatus($task->status),
                'changes' => ['from' => $oldStatus, 'to' => $task->status]
            ]);

            if ($task->assigned_to && $task->assigned_to != Auth::id()) {
                $this->notifyUser($task->assigned_to, "O status da tarefa '{$task->title}' mudou para " . $this->translateStatus($task->status), route('projects.show', $task->project_id));
            }
        }

        return back()->with('success', 'Status da tarefa atualizado!');
    }

    public function uploadAttachment(Request $request, Task $task)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // 10MB max
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('attachments/' . $task->id, 'public');

            Attachment::create([
                'task_id' => $task->id,
                'user_id' => Auth::id(),
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_type' => $file->getClientMimeType(),
                'file_size' => $file->getSize(),
            ]);

            ActivityLog::create([
                'task_id' => $task->id,
                'user_id' => Auth::id(),
                'action' => 'attachment_added',
                'description' => "adicionou um anexo: " . $file->getClientOriginalName(),
            ]);

            return back()->with('success', 'Arquivo enviado com sucesso!');
        }

        return back()->with('error', 'Falha ao enviar arquivo.');
    }

    public function deleteAttachment(Attachment $attachment)
    {
        $task = $attachment->task;
        Storage::disk('public')->delete($attachment->file_path);
        
        ActivityLog::create([
            'task_id' => $task->id,
            'user_id' => Auth::id(),
            'action' => 'attachment_removed',
            'description' => "removeu o anexo: " . $attachment->file_name,
        ]);

        $attachment->delete();

        return back()->with('success', 'Anexo removido com sucesso!');
    }

    private function notifyUser($userId, $message, $link)
    {
        $user = User::find($userId);
        if ($user) {
            $user->notify(new \App\Notifications\InternalNotification($message, $link, Auth::user()->name));
        }
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
