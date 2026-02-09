<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white leading-tight tracking-tight animate-fade-in">
            {{ __("Dashboard de Controle") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
                <div class="glass-card p-8 rounded-[2rem] border-l-4 border-atlvs-cyan animate-fade-in" style="animation-delay: 0.1s">
                    <div class="text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">Total de Projetos</div>
                    <div class="text-4xl font-extrabold text-white mt-2 tracking-tighter">{{ $totalProjects }}</div>
                </div>
                <div class="glass-card p-8 rounded-[2rem] border-l-4 border-atlvs-cyan animate-fade-in" style="animation-delay: 0.2s">
                    <div class="text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">Tarefas Concluídas</div>
                    <div class="text-4xl font-extrabold text-white mt-2 tracking-tighter">{{ $completedTasks }}<span class="text-xl text-gray-600 font-normal">/{{ $totalTasks }}</span></div>
                    <div class="mt-4 w-full bg-white/5 rounded-full h-1.5 overflow-hidden">
                        <div class="bg-atlvs-cyan h-full rounded-full shadow-[0_0_15px_rgba(6,182,212,0.6)] transition-all duration-1000" style="width: {{ $completionPercentage }}%"></div>
                    </div>
                </div>
                <div class="glass-card p-8 rounded-[2rem] border-l-4 border-red-500 animate-fade-in" style="animation-delay: 0.3s">
                    <div class="text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">Tarefas Travadas</div>
                    <div class="text-4xl font-extrabold text-red-500 mt-2 tracking-tighter">{{ $blockedTasks }}</div>
                    <div class="text-[10px] text-red-400/40 mt-2 font-black uppercase tracking-widest">Ação Crítica</div>
                </div>
                <div class="glass-card p-8 rounded-[2rem] border-l-4 border-white/10 animate-fade-in" style="animation-delay: 0.4s">
                    <div class="text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">Equipe Ativa</div>
                    <div class="text-4xl font-extrabold text-white mt-2 tracking-tighter">{{ $teamWorkload->count() }}</div>
                    <div class="text-[10px] text-gray-600 mt-2 font-black uppercase tracking-widest">Colaboradores</div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                <!-- Projects Progress -->
                <div class="glass-card p-10 rounded-[2.5rem] animate-fade-in" style="animation-delay: 0.5s">
                    <div class="flex justify-between items-center mb-10">
                        <h3 class="text-xl font-bold text-white tracking-tight">Progresso dos Sites</h3>
                        <a href="{{ route('projects.index') }}" class="text-[10px] font-black text-atlvs-cyan hover:text-white uppercase tracking-[0.2em] transition-all">Explorar Todos</a>
                    </div>
                    <div class="space-y-10">
                        @foreach($projectsProgress as $project)
                            <div class="group">
                                <div class="flex justify-between mb-4">
                                    <span class="text-sm font-bold text-gray-300 group-hover:text-white transition-colors">{{ $project->name }}</span>
                                    <span class="text-sm font-black text-atlvs-cyan text-glow">{{ $project->progress }}%</span>
                                </div>
                                <div class="w-full bg-white/5 rounded-full h-2.5 p-0.5 border border-white/5">
                                    <div class="bg-gradient-to-r from-atlvs-cyan to-white h-full rounded-full transition-all duration-1000 shadow-[0_0_20px_rgba(6,182,212,0.4)]" style="width: {{ $project->progress }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Team Workload -->
                <div class="glass-card p-10 rounded-[2.5rem] animate-fade-in" style="animation-delay: 0.6s">
                    <h3 class="text-xl font-bold mb-10 text-white tracking-tight">Carga de Trabalho</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b border-white/5">
                                    <th class="pb-6 text-left text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">Membro</th>
                                    <th class="pb-6 text-left text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">Tasks</th>
                                    <th class="pb-6 text-right text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @foreach($teamWorkload as $user)
                                    <tr class="group hover:bg-white/[0.01] transition-colors">
                                        <td class="py-6 text-sm text-white font-bold">{{ $user->name }}</td>
                                        <td class="py-6 text-sm text-gray-400 font-medium">{{ $user->tasks_count }} pendentes</td>
                                        <td class="py-6 text-right">
                                            @if($user->tasks_count > 5)
                                                <span class="px-4 py-1.5 text-[9px] font-black rounded-full bg-red-500/10 text-red-500 border border-red-500/20 uppercase tracking-widest">Sobrecarregado</span>
                                            @else
                                                <span class="px-4 py-1.5 text-[9px] font-black rounded-full bg-atlvs-cyan/10 text-atlvs-cyan border border-atlvs-cyan/20 uppercase tracking-widest">Disponível</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
