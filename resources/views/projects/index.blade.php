<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center animate-fade-in">
            <h2 class="font-bold text-2xl text-white leading-tight tracking-tight">
                {{ __('Projetos Ativos') }}
            </h2>
            <a href="{{ route('projects.create') }}" class="btn-cyan font-black py-3 px-10 rounded-full shadow-2xl text-[10px] uppercase tracking-[0.2em]">
                + Novo Projeto
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-atlvs-cyan/10 border border-atlvs-cyan/20 text-atlvs-cyan px-8 py-5 rounded-3xl relative mb-10 flex items-center backdrop-blur-xl animate-fade-in" role="alert">
                    <div class="w-2 h-2 rounded-full bg-atlvs-cyan mr-4 shadow-[0_0_10px_rgba(6,182,212,1)]"></div>
                    <span class="block sm:inline font-black text-[10px] uppercase tracking-widest">{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @forelse($projects as $index => $project)
                    <a href="{{ route('projects.show', $project) }}" class="glass-card overflow-hidden rounded-[2.5rem] group animate-fade-in hover:border-atlvs-cyan/50 transition-all duration-300 transform hover:scale-105" style="animation-delay: {{ ($index + 1) * 0.1 }}s">
                        <!-- Banner do Projeto -->
                        @if($project->image_path)
                            <div class="relative h-40 overflow-hidden bg-gradient-to-br from-atlvs-cyan/20 to-blue-500/20">
                                <img src="{{ asset('storage/' . $project->image_path) }}" alt="{{ $project->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            </div>
                        @else
                            <div class="h-40 bg-gradient-to-br from-atlvs-cyan/20 to-blue-500/20 flex items-center justify-center">
                                <svg class="w-16 h-16 text-atlvs-cyan/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif

                        <!-- Conteúdo do Card -->
                        <div class="p-8">
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-xl font-extrabold text-white group-hover:text-atlvs-cyan transition-colors tracking-tighter line-clamp-2">{{ $project->name }}</h3>
                                <div class="bg-white/5 p-2 rounded-lg border border-white/5 group-hover:border-atlvs-cyan/30 transition-all flex-shrink-0 ml-2">
                                    <svg class="w-5 h-5 text-atlvs-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                </div>
                            </div>
                            
                            <p class="text-gray-500 mb-6 line-clamp-2 text-sm leading-relaxed font-medium">{{ $project->description ?: 'Sem descrição estratégica definida.' }}</p>
                            
                            <div class="flex justify-between items-center pt-6 border-t border-white/5">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-atlvs-cyan/60" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 1 1 0 000 2H3a1 1 0 00-1 1v10a1 1 0 001 1h14a1 1 0 001-1V6a1 1 0 00-1-1h-3a1 1 0 000-2 2 2 0 00-2 2v2H4V5zm12 4H4v5h12V9z"></path></svg>
                                    <span class="text-[10px] font-black text-gray-600 uppercase tracking-[0.2em]">{{ $project->tasks_count }} Tarefas</span>
                                </div>
                                <span class="text-white hover:text-atlvs-cyan font-black text-[10px] uppercase tracking-[0.2em] flex items-center transition-all group-hover:translate-x-1">
                                    Abrir
                                    <svg class="w-3 h-3 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full glass-card rounded-[3rem] p-24 text-center border-2 border-dashed border-white/5 animate-fade-in">
                        <div class="bg-white/5 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-8 border border-white/5">
                            <svg class="w-10 h-10 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-500 tracking-tight">Nenhum projeto no radar</h3>
                        <p class="text-gray-600 text-sm mt-3 font-medium max-w-xs mx-auto">Inicie o desenvolvimento de um novo site para começar o rastreamento.</p>
                        <a href="{{ route('projects.create') }}" class="mt-10 inline-block btn-cyan font-black py-4 px-12 rounded-full text-[10px] uppercase tracking-[0.2em] shadow-2xl">Criar Primeiro Projeto</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
