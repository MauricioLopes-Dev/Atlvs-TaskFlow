<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Dashboard de Controle") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 border-l-4 border-atlvs-primary">
                    <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total de Projetos</div>
                    <div class="text-3xl font-extrabold text-atlvs-primary mt-1">{{ $totalProjects }}</div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 border-l-4 border-atlvs-accent">
                    <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">Tarefas Concluídas</div>
                    <div class="text-3xl font-extrabold text-atlvs-primary mt-1">{{ $completedTasks }}<span class="text-lg text-gray-400 font-normal">/{{ $totalTasks }}</span></div>
                    <div class="mt-2 w-full bg-gray-100 rounded-full h-1.5">
                        <div class="bg-atlvs-accent h-1.5 rounded-full" style="width: {{ $completionPercentage }}%"></div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 border-l-4 border-red-500">
                    <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">Tarefas Travadas</div>
                    <div class="text-3xl font-extrabold text-red-600 mt-1">{{ $blockedTasks }}</div>
                    <div class="text-xs text-red-400 mt-1 font-medium">Requerem atenção imediata</div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 border-l-4 border-atlvs-secondary">
                    <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">Equipe Ativa</div>
                    <div class="text-3xl font-extrabold text-atlvs-primary mt-1">{{ $teamWorkload->count() }}</div>
                    <div class="text-xs text-gray-400 mt-1 font-medium">Membros no projeto</div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Projects Progress -->
                <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-atlvs-primary">Progresso dos Sites</h3>
                        <a href="{{ route('projects.index') }}" class="text-sm font-bold text-atlvs-accent hover:underline">Ver todos</a>
                    </div>
                    <div class="space-y-6">
                        @foreach($projectsProgress as $project)
                            <div>
                                <div class="flex justify-between mb-2">
                                    <span class="text-sm font-bold text-gray-700">{{ $project->name }}</span>
                                    <span class="text-sm font-bold text-atlvs-accent">{{ $project->progress }}%</span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-3">
                                    <div class="bg-atlvs-primary h-3 rounded-full transition-all duration-500" style="width: {{ $project->progress }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Team Workload -->
                <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold mb-6 text-atlvs-primary">Carga de Trabalho da Equipe</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b border-gray-100">
                                    <th class="pb-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Membro</th>
                                    <th class="pb-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Tarefas Ativas</th>
                                    <th class="pb-3 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($teamWorkload as $user)
                                    <tr>
                                        <td class="py-4 text-sm text-atlvs-primary font-bold">{{ $user->name }}</td>
                                        <td class="py-4 text-sm text-gray-500">{{ $user->tasks_count }} pendentes</td>
                                        <td class="py-4 text-right">
                                            @if($user->tasks_count > 5)
                                                <span class="px-3 py-1 text-xs font-bold rounded-full bg-red-50 text-red-600 border border-red-100">Sobrecarregado</span>
                                            @else
                                                <span class="px-3 py-1 text-xs font-bold rounded-full bg-green-50 text-green-600 border border-green-100">Disponível</span>
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
