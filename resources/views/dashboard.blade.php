<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __("Dashboard de Controle") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="glass-card p-6 rounded-2xl border-l-4 border-atlvs-cyan">
                    <div class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Total de Projetos</div>
                    <div class="text-3xl font-extrabold text-white mt-1">{{ $totalProjects }}</div>
                </div>
                <div class="glass-card p-6 rounded-2xl border-l-4 border-atlvs-cyan">
                    <div class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Tarefas Concluídas</div>
                    <div class="text-3xl font-extrabold text-white mt-1">{{ $completedTasks }}<span class="text-lg text-gray-600 font-normal">/{{ $totalTasks }}</span></div>
                    <div class="mt-2 w-full bg-white/5 rounded-full h-1">
                        <div class="bg-atlvs-cyan h-1 rounded-full shadow-[0_0_10px_rgba(6,182,212,0.5)]" style="width: {{ $completionPercentage }}%"></div>
                    </div>
                </div>
                <div class="glass-card p-6 rounded-2xl border-l-4 border-red-500">
                    <div class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Tarefas Travadas</div>
                    <div class="text-3xl font-extrabold text-red-500 mt-1">{{ $blockedTasks }}</div>
                    <div class="text-[10px] text-red-400/50 mt-1 font-bold uppercase tracking-tighter">Ação imediata necessária</div>
                </div>
                <div class="glass-card p-6 rounded-2xl border-l-4 border-white/20">
                    <div class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Equipe Ativa</div>
                    <div class="text-3xl font-extrabold text-white mt-1">{{ $teamWorkload->count() }}</div>
                    <div class="text-[10px] text-gray-600 mt-1 font-bold uppercase tracking-tighter">Membros integrados</div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Projects Progress -->
                <div class="glass-card p-8 rounded-2xl">
                    <div class="flex justify-between items-center mb-8">
                        <h3 class="text-lg font-bold text-white tracking-tight">Progresso dos Sites</h3>
                        <a href="{{ route('projects.index') }}" class="text-xs font-black text-atlvs-cyan hover:text-white uppercase tracking-widest transition-colors">Ver todos</a>
                    </div>
                    <div class="space-y-8">
                        @foreach($projectsProgress as $project)
                            <div>
                                <div class="flex justify-between mb-3">
                                    <span class="text-sm font-bold text-gray-300">{{ $project->name }}</span>
                                    <span class="text-sm font-black text-atlvs-cyan">{{ $project->progress }}%</span>
                                </div>
                                <div class="w-full bg-white/5 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-atlvs-cyan to-white h-2 rounded-full transition-all duration-1000 shadow-[0_0_15px_rgba(6,182,212,0.3)]" style="width: {{ $project->progress }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Team Workload -->
                <div class="glass-card p-8 rounded-2xl">
                    <h3 class="text-lg font-bold mb-8 text-white tracking-tight">Carga de Trabalho da Equipe</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b border-white/5">
                                    <th class="pb-4 text-left text-[10px] font-black text-gray-500 uppercase tracking-widest">Membro</th>
                                    <th class="pb-4 text-left text-[10px] font-black text-gray-500 uppercase tracking-widest">Tarefas Ativas</th>
                                    <th class="pb-4 text-right text-[10px] font-black text-gray-500 uppercase tracking-widest">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @foreach($teamWorkload as $user)
                                    <tr>
                                        <td class="py-5 text-sm text-white font-bold">{{ $user->name }}</td>
                                        <td class="py-5 text-sm text-gray-400">{{ $user->tasks_count }} pendentes</td>
                                        <td class="py-5 text-right">
                                            @if($user->tasks_count > 5)
                                                <span class="px-3 py-1 text-[10px] font-black rounded-full bg-red-500/10 text-red-500 border border-red-500/20 uppercase tracking-tighter">Sobrecarregado</span>
                                            @else
                                                <span class="px-3 py-1 text-[10px] font-black rounded-full bg-atlvs-cyan/10 text-atlvs-cyan border border-atlvs-cyan/20 uppercase tracking-tighter">Disponível</span>
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
