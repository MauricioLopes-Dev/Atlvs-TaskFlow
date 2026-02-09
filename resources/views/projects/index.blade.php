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
                    <div class="glass-card overflow-hidden rounded-[2.5rem] group animate-fade-in" style="animation-delay: {{ ($index + 1) * 0.1 }}s">
                        <div class="p-12">
                            <div class="flex justify-between items-start mb-8">
                                <h3 class="text-2xl font-extrabold text-white group-hover:text-atlvs-cyan transition-colors tracking-tighter">{{ $project->name }}</h3>
                                <div class="bg-white/5 p-3 rounded-2xl border border-white/5 group-hover:border-atlvs-cyan/30 transition-all">
                                    <svg class="w-6 h-6 text-atlvs-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                                </div>
                            </div>
                            <p class="text-gray-500 mb-10 line-clamp-2 text-sm leading-relaxed font-medium">{{ $project->description ?: 'Sem descrição estratégica definida.' }}</p>
                            
                            <div class="flex justify-between items-center pt-10 border-t border-white/5">
                                <div class="flex items-center">
                                    <span class="text-[10px] font-black text-gray-600 uppercase tracking-[0.2em]">{{ $project->tasks_count }} Tasks</span>
                                </div>
                                <a href="{{ route('projects.show', $project) }}" class="text-white hover:text-atlvs-cyan font-black text-[10px] uppercase tracking-[0.2em] flex items-center transition-all group-hover:translate-x-2">
                                    Gerenciar
                                    <svg class="w-4 h-4 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                            </div>
                        </div>
                    </div>
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
