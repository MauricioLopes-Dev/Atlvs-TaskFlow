<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Projetos Ativos') }}
            </h2>
            <a href="{{ route('projects.create') }}" class="btn-cyan font-black py-2.5 px-8 rounded-full shadow-lg text-[10px] uppercase tracking-widest">
                + Novo Projeto
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-atlvs-cyan/10 border border-atlvs-cyan/20 text-atlvs-cyan px-6 py-4 rounded-2xl relative mb-8 flex items-center backdrop-blur-sm" role="alert">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <span class="block sm:inline font-bold text-sm uppercase tracking-tight">{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($projects as $project)
                    <div class="glass-card overflow-hidden rounded-3xl hover:border-atlvs-cyan/50 transition-all duration-500 group">
                        <div class="p-10">
                            <div class="flex justify-between items-start mb-6">
                                <h3 class="text-2xl font-bold text-white group-hover:text-atlvs-cyan transition-colors">{{ $project->name }}</h3>
                                <div class="bg-white/5 p-2 rounded-lg">
                                    <svg class="w-5 h-5 text-atlvs-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                                </div>
                            </div>
                            <p class="text-gray-500 mb-8 line-clamp-2 text-sm leading-relaxed font-medium">{{ $project->description ?: 'Sem descrição definida para este projeto.' }}</p>
                            
                            <div class="flex justify-between items-center pt-8 border-t border-white/5">
                                <div class="flex items-center text-gray-600">
                                    <span class="text-[10px] font-black uppercase tracking-widest">{{ $project->tasks_count }} Tarefas</span>
                                </div>
                                <a href="{{ route('projects.show', $project) }}" class="text-white hover:text-atlvs-cyan font-black text-[10px] uppercase tracking-widest flex items-center transition-all group-hover:translate-x-1">
                                    Gerenciar
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full glass-card rounded-3xl p-20 text-center border-2 border-dashed border-white/5">
                        <div class="bg-white/5 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-500">Nenhum projeto encontrado</h3>
                        <p class="text-gray-600 text-sm mt-2 font-medium">Comece criando o primeiro site da equipe.</p>
                        <a href="{{ route('projects.create') }}" class="mt-8 inline-block btn-cyan font-black py-3 px-10 rounded-full text-[10px] uppercase tracking-widest shadow-xl">Criar Projeto Agora</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
