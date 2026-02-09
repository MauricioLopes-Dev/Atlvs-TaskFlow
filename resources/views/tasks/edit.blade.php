<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Tarefa: {{ $task->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('tasks.update', $task) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">Título da Tarefa</label>
                        <input type="text" name="title" id="title" value="{{ $task->title }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Descrição</label>
                        <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ $task->description }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label for="priority" class="block text-sm font-medium text-gray-700">Prioridade</label>
                            <select name="priority" id="priority" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="low" {{ $task->priority == 'low' ? 'selected' : '' }}>Baixa</option>
                                <option value="medium" {{ $task->priority == 'medium' ? 'selected' : '' }}>Média</option>
                                <option value="high" {{ $task->priority == 'high' ? 'selected' : '' }}>Alta</option>
                            </select>
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pendente</option>
                                <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>Em Andamento</option>
                                <option value="blocked" {{ $task->status == 'blocked' ? 'selected' : '' }}>Travado</option>
                                <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Concluído</option>
                            </select>
                        </div>

                        <div>
                            <label for="assigned_to" class="block text-sm font-medium text-gray-700">Atribuir a</label>
                            <select name="assigned_to" id="assigned_to" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Ninguém (Livre)</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ $task->assigned_to == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="due_date" class="block text-sm font-medium text-gray-700">Data de Vencimento</label>
                        <input type="date" name="due_date" id="due_date" value="{{ $task->due_date ? $task->due_date->format('Y-m-d') : '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('projects.show', $task->project_id) }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancelar</a>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Atualizar Tarefa
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
