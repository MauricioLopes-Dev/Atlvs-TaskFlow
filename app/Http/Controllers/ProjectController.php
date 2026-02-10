<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Auth::user()->projects()->withCount('tasks')->get();
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $validated['owner_id'] = Auth::id();

        $project = Project::create($validated);
        $project->users()->attach(Auth::id()); // Adiciona o criador como membro do projeto

        return redirect()->route('projects.index')->with('success', 'Projeto criado com sucesso!');
    }

    public function show(Project $project)
    {
        if (!Auth::user()->projects->contains($project)) {
            abort(403, 'Acesso não autorizado a este projeto.');
        }
        $project->load(['tasks.assignee', 'tasks.comments.user', 'owner', 'tasks.attachments']);
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        if (!Auth::user()->projects->contains($project)) {
            abort(403, 'Acesso não autorizado a este projeto.');
        }
        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        if (!Auth::user()->projects->contains($project)) {
            abort(403, 'Acesso não autorizado a este projeto.');
        }
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $project->update($validated);

        return redirect()->route('projects.index')->with('success', 'Projeto atualizado com sucesso!');
    }

    public function destroy(Project $project)
    {
        if (!Auth::user()->projects->contains($project)) {
            abort(403, 'Acesso não autorizado a este projeto.');
        }
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Projeto excluído com sucesso!');
    }
}
