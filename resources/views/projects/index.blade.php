<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Projetos Ativos') }}
            </h2>
            <a href="{{ route('projects.create') }}" class="btn-atlvs text-white font-bold py-2.5 px-6 rounded-lg shadow-sm text-sm">
                + Novo Projeto
            </a>
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

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($projects as $project)
                    <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100 hover:shadow-md transition-shadow duration-300">
                        <div class="p-8">
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-xl font-bold text-atlvs-primary">{{ $project->name }}</h3>
                                <span class="bg-gray-50 text-gray-400 text-xs font-bold px-2 py-1 rounded uppercase tracking-tighter">Site</span>
                            </div>
                            <p class="text-gray-500 mb-6 line-clamp-2 text-sm leading-relaxed">{{ $project->description ?: 'Sem descrição definida para este projeto.' }}</p>
                            
                            <div class="flex justify-between items-center pt-6 border-t border-gray-50">
                                <div class="flex items-center text-gray-400">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                    <span class="text-xs font-bold uppercase tracking-wider">{{ $project->tasks_count }} Tarefas</span>
                                </div>
                                <a href="{{ route('projects.show', $project) }}" class="text-atlvs-accent hover:text-atlvs-primary font-bold text-sm flex items-center transition-colors">
                                    Gerenciar
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white rounded-2xl p-16 text-center border-2 border-dashed border-gray-100">
                        <div class="bg-gray-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-400">Nenhum projeto encontrado</h3>
                        <p class="text-gray-400 text-sm mt-1">Comece criando o primeiro site da equipe.</p>
                        <a href="{{ route('projects.create') }}" class="mt-6 inline-block text-atlvs-accent font-bold hover:underline">Criar Projeto Agora</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
