<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Projetos') }}
            </h2>
            <a href="{{ route('projects.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                + Novo Projeto
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($projects as $project)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-b border-gray-200">
                        <h3 class="text-lg font-bold mb-2">{{ $project->name }}</h3>
                        <p class="text-gray-600 mb-4 line-clamp-3">{{ $project->description }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">{{ $project->tasks_count }} tarefas</span>
                            <a href="{{ route('projects.show', $project) }}" class="text-blue-600 hover:text-blue-900 font-medium">
                                Ver Detalhes →
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white overflow-hidden shadow-sm sm:rounded-lg p-12 text-center">
                        <p class="text-gray-500 text-lg">Nenhum projeto encontrado. Comece criando um!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
