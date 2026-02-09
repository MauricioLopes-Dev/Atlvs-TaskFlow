<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $project->name }}
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('tasks.create', ['project_id' => $project->id]) }}" class="btn-atlvs text-white font-bold py-2 px-4 rounded-lg text-sm shadow-sm">
                    + Nova Tarefa
                </a>
                <a href="{{ route('projects.edit', $project) }}" class="bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 font-bold py-2 px-4 rounded-lg text-sm shadow-sm transition-colors">
                    Editar Projeto
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-50 border border-green-100 text-green-700 px-4 py-3 rounded-xl relative mb-6 flex items-center" role="alert">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <span class="block sm:inline font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100 p-8 mb-8">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Descrição do Projeto</h3>
                <p class="text-gray-700 leading-relaxed">{{ $project->description ?: 'Sem descrição detalhada.' }}</p>
                <div class="mt-6 flex items-center text-xs text-gray-400 font-medium">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Criado por: <span class="text-atlvs-primary ml-1">{{ $project->owner->name }}</span>
                </div>
            </div>

            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-atlvs-primary">Fluxo de Tarefas</h3>
                <span class="text-sm text-gray-400 font-medium">{{ $project->tasks->count() }} tarefas no total</span>
            </div>
            
            <div class="space-y-6">
                @forelse($project->tasks as $task)
                    <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100 hover:border-atlvs-accent transition-colors duration-300">
                        <div class="p-8 border-b border-gray-50">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center mb-1">
                                        <h4 class="text-lg font-bold text-atlvs-primary">{{ $task->title }}</h4>
                                        @php
                                            $priorityColors = [
                                                'low' => 'bg-blue-50 text-blue-600 border-blue-100',
                                                'medium' => 'bg-yellow-50 text-yellow-600 border-yellow-100',
                                                'high' => 'bg-red-50 text-red-600 border-red-100',
                                            ];
                                        @endphp
                                        <span class="ml-3 px-2.5 py-0.5 text-[10px] font-black uppercase tracking-wider rounded-full border {{ $priorityColors[$task->priority] }}">
                                            {{ $task->priority }}
                                        </span>
                                    </div>
                                    <p class="text-gray-500 text-sm leading-relaxed">{{ $task->description }}</p>
                                </div>
                                
                                <div class="ml-6">
                                    <form action="{{ route('tasks.updateStatus', $task) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" class="text-xs font-bold rounded-lg border-gray-200 shadow-sm focus:border-atlvs-accent focus:ring focus:ring-atlvs-accent focus:ring-opacity-20 transition-all">
                                            <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>PENDENTE</option>
                                            <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>EM ANDAMENTO</option>
                                            <option value="blocked" {{ $task->status == 'blocked' ? 'selected' : '' }}>TRAVADO</option>
                                            <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>CONCLUÍDO</option>
                                        </select>
                                    </form>
                                </div>
                            </div>
                            
                            <div class="mt-6 flex justify-between items-center">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-atlvs-primary flex items-center justify-center text-white text-[10px] font-bold mr-2">
                                        {{ strtoupper(substr($task->assignee ? $task->assignee->name : '?', 0, 2)) }}
                                    </div>
                                    <div class="text-xs">
                                        <p class="text-gray-400 font-medium uppercase tracking-tighter">Responsável</p>
                                        <p class="text-atlvs-primary font-bold">{{ $task->assignee ? $task->assignee->name : 'Livre para assumir' }}</p>
                                    </div>
                                </div>
                                <div class="flex space-x-4">
                                    <a href="{{ route('tasks.edit', $task) }}" class="text-gray-400 hover:text-atlvs-accent transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors" onclick="return confirm('Tem certeza que deseja excluir esta tarefa?')">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Comments Section -->
                        <div class="bg-gray-50 p-8">
                            <div class="flex items-center mb-6">
                                <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                                <h5 class="text-xs font-black text-gray-400 uppercase tracking-widest">Discussão Técnica ({{ $task->comments->count() }})</h5>
                            </div>
                            
                            <div class="space-y-4 mb-6">
                                @foreach($task->comments as $comment)
                                    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="text-xs font-black text-atlvs-primary">{{ $comment->user->name }}</span>
                                            <span class="text-[10px] font-bold text-gray-300">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-sm text-gray-600 leading-relaxed">{{ $comment->content }}</p>
                                        @if($comment->user_id === Auth::id())
                                            <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="mt-3 pt-3 border-t border-gray-50">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-[10px] font-bold text-red-400 hover:text-red-600 uppercase tracking-tighter">Remover comentário</button>
                                            </form>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <form action="{{ route('comments.store', $task) }}" method="POST">
                                @csrf
                                <div class="flex space-x-3">
                                    <input type="text" name="content" placeholder="Escreva uma atualização técnica..." class="flex-1 text-sm rounded-xl border-gray-200 shadow-sm focus:border-atlvs-accent focus:ring focus:ring-atlvs-accent focus:ring-opacity-20 transition-all" required>
                                    <button type="submit" class="btn-atlvs text-white text-xs font-black uppercase tracking-widest py-2 px-6 rounded-xl shadow-sm">
                                        Enviar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-2xl p-16 text-center border-2 border-dashed border-gray-100">
                        <p class="text-gray-400 font-bold">Nenhuma tarefa ativa para este site.</p>
                        <a href="{{ route('tasks.create', ['project_id' => $project->id]) }}" class="text-atlvs-accent text-sm font-bold mt-2 inline-block hover:underline">Adicionar primeira tarefa</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
