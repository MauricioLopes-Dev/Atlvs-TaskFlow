<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $project->name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('tasks.create', ['project_id' => $project->id]) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    + Nova Tarefa
                </a>
                <a href="{{ route('projects.edit', $project) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Editar Projeto
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-bold mb-2">Descrição do Projeto</h3>
                <p class="text-gray-700">{{ $project->description ?: 'Sem descrição.' }}</p>
                <p class="mt-4 text-sm text-gray-500">Criado por: {{ $project->owner->name }}</p>
            </div>

            <h3 class="text-xl font-bold mb-4">Tarefas</h3>
            
            <div class="space-y-6">
                @forelse($project->tasks as $task)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                        <div class="p-6 border-b border-gray-200">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="text-lg font-bold text-gray-900">{{ $task->title }}</h4>
                                    <p class="text-gray-600 mt-1">{{ $task->description }}</p>
                                </div>
                                <div class="flex items-center space-x-4">
                                    @php
                                        $priorityColors = [
                                            'low' => 'bg-blue-100 text-blue-800',
                                            'medium' => 'bg-yellow-100 text-yellow-800',
                                            'high' => 'bg-red-100 text-red-800',
                                        ];
                                    @endphp
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $priorityColors[$task->priority] }}">
                                        {{ ucfirst($task->priority) }}
                                    </span>
                                    
                                    <form action="{{ route('tasks.updateStatus', $task) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" class="text-sm rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pendente</option>
                                            <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>Em Andamento</option>
                                            <option value="blocked" {{ $task->status == 'blocked' ? 'selected' : '' }}>Travado</option>
                                            <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Concluído</option>
                                        </select>
                                    </form>
                                </div>
                            </div>
                            
                            <div class="mt-4 flex justify-between items-center text-sm text-gray-500">
                                <div>Responsável: <span class="font-medium text-gray-900">{{ $task->assignee ? $task->assignee->name : 'Não atribuído' }}</span></div>
                                <div class="flex space-x-3">
                                    <a href="{{ route('tasks.edit', $task) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Tem certeza?')">Excluir</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Comments Section -->
                        <div class="bg-gray-50 p-6">
                            <h5 class="text-sm font-bold text-gray-700 mb-4">Comentários ({{ $task->comments->count() }})</h5>
                            
                            <div class="space-y-4 mb-4">
                                @foreach($task->comments as $comment)
                                    <div class="bg-white p-3 rounded shadow-sm border border-gray-100">
                                        <div class="flex justify-between items-start">
                                            <span class="text-xs font-bold text-gray-900">{{ $comment->user->name }}</span>
                                            <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-sm text-gray-700 mt-1">{{ $comment->content }}</p>
                                        @if($comment->user_id === Auth::id())
                                            <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="mt-2">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs text-red-500 hover:text-red-700">Excluir</button>
                                            </form>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <form action="{{ route('comments.store', $task) }}" method="POST">
                                @csrf
                                <div class="flex space-x-2">
                                    <input type="text" name="content" placeholder="Adicionar um comentário técnico..." class="flex-1 text-sm rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded">
                                        Enviar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-12 text-center border border-gray-200">
                        <p class="text-gray-500 text-lg">Nenhuma tarefa cadastrada para este projeto.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
