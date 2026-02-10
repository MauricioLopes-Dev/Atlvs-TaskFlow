<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-white leading-tight tracking-tight">
                Quadro Kanban
            </h2>
            <div class="flex space-x-4 items-center">
                <div class="text-[10px] text-gray-500 font-black uppercase tracking-widest">
                    Total de Tarefas: <span class="text-atlvs-cyan">{{ $tasksByStatus['pending']->count() + $tasksByStatus['in_progress']->count() + $tasksByStatus['blocked']->count() + $tasksByStatus['completed']->count() }}</span>
                </div>
                <a href="{{ route('projects.index') }}" class="bg-white/5 border border-white/10 text-gray-400 hover:text-white hover:bg-white/10 font-black py-2.5 px-6 rounded-full text-[10px] uppercase tracking-widest transition-all">
                    Voltar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Coluna Pendente -->
                <div class="flex flex-col">
                    <div class="mb-6">
                        <div class="flex items-center space-x-3 mb-2">
                            <div class="w-3 h-3 rounded-full bg-gray-500 shadow-[0_0_8px_rgba(107,114,128,0.5)]"></div>
                            <h3 class="text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">Pendente</h3>
                            <span class="bg-gray-500/10 border border-gray-500/20 text-gray-400 px-2 py-0.5 rounded-full text-[9px] font-black">{{ $tasksByStatus['pending']->count() }}</span>
                        </div>
                        <p class="text-[9px] text-gray-700 font-medium">Aguardando início</p>
                    </div>

                    <div class="kanban-column flex-1 bg-gray-900/30 border border-white/5 rounded-2xl p-4 min-h-[600px] overflow-y-auto" data-status="pending">
                        @forelse($tasksByStatus['pending'] as $task)
                            <div class="kanban-card bg-white/5 border border-white/10 rounded-xl p-4 mb-3 cursor-move hover:border-gray-500/30 transition-all shadow-sm hover:shadow-md" draggable="true" data-task-id="{{ $task->id }}">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="text-xs font-bold text-white flex-1 break-words">{{ $task->title }}</h4>
                                    @php
                                        $priorityColors = [
                                            'low' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
                                            'medium' => 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20',
                                            'high' => 'bg-red-500/10 text-red-500 border-red-500/20',
                                        ];
                                    @endphp
                                    <span class="ml-2 px-2 py-0.5 text-[8px] font-black uppercase tracking-tighter rounded border {{ $priorityColors[$task->priority] }}">
                                        {{ substr($task->priority, 0, 1) }}
                                    </span>
                                </div>
                                
                                <p class="text-[9px] text-gray-500 mb-3 line-clamp-2">{{ $task->description ?: 'Sem descrição' }}</p>
                                
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        @if($task->assignee)
                                            <div class="w-6 h-6 rounded-full bg-gradient-to-br from-atlvs-cyan to-white flex items-center justify-center text-black text-[9px] font-black shadow-sm">
                                                {{ strtoupper(substr($task->assignee->name, 0, 1)) }}
                                            </div>
                                        @else
                                            <div class="w-6 h-6 rounded-full bg-gray-700 flex items-center justify-center text-gray-500 text-[9px] font-black">
                                                ?
                                            </div>
                                        @endif
                                    </div>
                                    <a href="{{ route('projects.show', $task->project_id) }}" class="text-atlvs-cyan hover:text-white transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                    </a>
                                </div>

                                @if($task->due_date)
                                    <div class="mt-2 text-[8px] text-gray-600 font-black uppercase tracking-tighter">
                                        📅 {{ $task->due_date->format('d/m') }}
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="text-center text-gray-700 text-[10px] font-black uppercase tracking-widest py-12">
                                Nenhuma tarefa
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Coluna Em Andamento -->
                <div class="flex flex-col">
                    <div class="mb-6">
                        <div class="flex items-center space-x-3 mb-2">
                            <div class="w-3 h-3 rounded-full bg-blue-500 shadow-[0_0_8px_rgba(59,130,246,0.5)]"></div>
                            <h3 class="text-[10px] font-black text-blue-500 uppercase tracking-[0.2em]">Em Andamento</h3>
                            <span class="bg-blue-500/10 border border-blue-500/20 text-blue-400 px-2 py-0.5 rounded-full text-[9px] font-black">{{ $tasksByStatus['in_progress']->count() }}</span>
                        </div>
                        <p class="text-[9px] text-gray-700 font-medium">Sendo desenvolvido</p>
                    </div>

                    <div class="kanban-column flex-1 bg-blue-900/10 border border-blue-500/20 rounded-2xl p-4 min-h-[600px] overflow-y-auto" data-status="in_progress">
                        @forelse($tasksByStatus['in_progress'] as $task)
                            <div class="kanban-card bg-white/5 border border-white/10 rounded-xl p-4 mb-3 cursor-move hover:border-blue-500/30 transition-all shadow-sm hover:shadow-md" draggable="true" data-task-id="{{ $task->id }}">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="text-xs font-bold text-white flex-1 break-words">{{ $task->title }}</h4>
                                    <span class="ml-2 px-2 py-0.5 text-[8px] font-black uppercase tracking-tighter rounded border {{ $priorityColors[$task->priority] }}">
                                        {{ substr($task->priority, 0, 1) }}
                                    </span>
                                </div>
                                
                                <p class="text-[9px] text-gray-500 mb-3 line-clamp-2">{{ $task->description ?: 'Sem descrição' }}</p>
                                
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        @if($task->assignee)
                                            <div class="w-6 h-6 rounded-full bg-gradient-to-br from-atlvs-cyan to-white flex items-center justify-center text-black text-[9px] font-black shadow-sm">
                                                {{ strtoupper(substr($task->assignee->name, 0, 1)) }}
                                            </div>
                                        @else
                                            <div class="w-6 h-6 rounded-full bg-gray-700 flex items-center justify-center text-gray-500 text-[9px] font-black">
                                                ?
                                            </div>
                                        @endif
                                    </div>
                                    <a href="{{ route('projects.show', $task->project_id) }}" class="text-atlvs-cyan hover:text-white transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                    </a>
                                </div>

                                @if($task->due_date)
                                    <div class="mt-2 text-[8px] text-gray-600 font-black uppercase tracking-tighter">
                                        📅 {{ $task->due_date->format('d/m') }}
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="text-center text-gray-700 text-[10px] font-black uppercase tracking-widest py-12">
                                Nenhuma tarefa
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Coluna Travado -->
                <div class="flex flex-col">
                    <div class="mb-6">
                        <div class="flex items-center space-x-3 mb-2">
                            <div class="w-3 h-3 rounded-full bg-red-500 shadow-[0_0_8px_rgba(239,68,68,0.5)]"></div>
                            <h3 class="text-[10px] font-black text-red-500 uppercase tracking-[0.2em]">Travado</h3>
                            <span class="bg-red-500/10 border border-red-500/20 text-red-400 px-2 py-0.5 rounded-full text-[9px] font-black">{{ $tasksByStatus['blocked']->count() }}</span>
                        </div>
                        <p class="text-[9px] text-gray-700 font-medium">Bloqueado por impedimento</p>
                    </div>

                    <div class="kanban-column flex-1 bg-red-900/10 border border-red-500/20 rounded-2xl p-4 min-h-[600px] overflow-y-auto" data-status="blocked">
                        @forelse($tasksByStatus['blocked'] as $task)
                            <div class="kanban-card bg-white/5 border border-white/10 rounded-xl p-4 mb-3 cursor-move hover:border-red-500/30 transition-all shadow-sm hover:shadow-md" draggable="true" data-task-id="{{ $task->id }}">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="text-xs font-bold text-white flex-1 break-words">{{ $task->title }}</h4>
                                    <span class="ml-2 px-2 py-0.5 text-[8px] font-black uppercase tracking-tighter rounded border {{ $priorityColors[$task->priority] }}">
                                        {{ substr($task->priority, 0, 1) }}
                                    </span>
                                </div>
                                
                                <p class="text-[9px] text-gray-500 mb-3 line-clamp-2">{{ $task->description ?: 'Sem descrição' }}</p>
                                
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        @if($task->assignee)
                                            <div class="w-6 h-6 rounded-full bg-gradient-to-br from-atlvs-cyan to-white flex items-center justify-center text-black text-[9px] font-black shadow-sm">
                                                {{ strtoupper(substr($task->assignee->name, 0, 1)) }}
                                            </div>
                                        @else
                                            <div class="w-6 h-6 rounded-full bg-gray-700 flex items-center justify-center text-gray-500 text-[9px] font-black">
                                                ?
                                            </div>
                                        @endif
                                    </div>
                                    <a href="{{ route('projects.show', $task->project_id) }}" class="text-atlvs-cyan hover:text-white transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                    </a>
                                </div>

                                @if($task->due_date)
                                    <div class="mt-2 text-[8px] text-gray-600 font-black uppercase tracking-tighter">
                                        📅 {{ $task->due_date->format('d/m') }}
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="text-center text-gray-700 text-[10px] font-black uppercase tracking-widest py-12">
                                Nenhuma tarefa
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Coluna Concluído -->
                <div class="flex flex-col">
                    <div class="mb-6">
                        <div class="flex items-center space-x-3 mb-2">
                            <div class="w-3 h-3 rounded-full bg-green-500 shadow-[0_0_8px_rgba(34,197,94,0.5)]"></div>
                            <h3 class="text-[10px] font-black text-green-500 uppercase tracking-[0.2em]">Concluído</h3>
                            <span class="bg-green-500/10 border border-green-500/20 text-green-400 px-2 py-0.5 rounded-full text-[9px] font-black">{{ $tasksByStatus['completed']->count() }}</span>
                        </div>
                        <p class="text-[9px] text-gray-700 font-medium">Finalizado com sucesso</p>
                    </div>

                    <div class="kanban-column flex-1 bg-green-900/10 border border-green-500/20 rounded-2xl p-4 min-h-[600px] overflow-y-auto" data-status="completed">
                        @forelse($tasksByStatus['completed'] as $task)
                            <div class="kanban-card bg-white/5 border border-white/10 rounded-xl p-4 mb-3 cursor-move hover:border-green-500/30 transition-all shadow-sm hover:shadow-md" draggable="true" data-task-id="{{ $task->id }}">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="text-xs font-bold text-white flex-1 break-words">{{ $task->title }}</h4>
                                    <span class="ml-2 px-2 py-0.5 text-[8px] font-black uppercase tracking-tighter rounded border {{ $priorityColors[$task->priority] }}">
                                        {{ substr($task->priority, 0, 1) }}
                                    </span>
                                </div>
                                
                                <p class="text-[9px] text-gray-500 mb-3 line-clamp-2">{{ $task->description ?: 'Sem descrição' }}</p>
                                
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        @if($task->assignee)
                                            <div class="w-6 h-6 rounded-full bg-gradient-to-br from-atlvs-cyan to-white flex items-center justify-center text-black text-[9px] font-black shadow-sm">
                                                {{ strtoupper(substr($task->assignee->name, 0, 1)) }}
                                            </div>
                                        @else
                                            <div class="w-6 h-6 rounded-full bg-gray-700 flex items-center justify-center text-gray-500 text-[9px] font-black">
                                                ?
                                            </div>
                                        @endif
                                    </div>
                                    <a href="{{ route('projects.show', $task->project_id) }}" class="text-atlvs-cyan hover:text-white transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                    </a>
                                </div>

                                @if($task->due_date)
                                    <div class="mt-2 text-[8px] text-gray-600 font-black uppercase tracking-tighter">
                                        📅 {{ $task->due_date->format('d/m') }}
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="text-center text-gray-700 text-[10px] font-black uppercase tracking-widest py-12">
                                Nenhuma tarefa
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const columns = document.querySelectorAll('.kanban-column');
            
            columns.forEach(column => {
                Sortable.create(column, {
                    group: 'tasks',
                    animation: 150,
                    ghostClass: 'opacity-50 bg-atlvs-cyan/20',
                    dragClass: 'opacity-75',
                    onEnd: function(evt) {
                        const taskId = evt.item.dataset.taskId;
                        const newStatus = evt.to.dataset.status;
                        
                        // Enviar requisição PATCH para atualizar o status
                        fetch(`{{ url('/kanban/tasks') }}/${taskId}/status`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({ status: newStatus })
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log('Tarefa atualizada:', data);
                        })
                        .catch(error => {
                            console.error('Erro ao atualizar tarefa:', error);
                            // Revert the change if there's an error
                            evt.from.insertBefore(evt.item, evt.item.nextSibling);
                        });
                    }
                });
            });
        });
    </script>
</x-app-layout>
