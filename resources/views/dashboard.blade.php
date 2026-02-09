<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Dashboard de Controle") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-blue-500">
                    <div class="text-sm font-medium text-gray-500 uppercase">Total de Projetos</div>
                    <div class="text-2xl font-bold text-gray-900">{{ $totalProjects }}</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-green-500">
                    <div class="text-sm font-medium text-gray-500 uppercase">Tarefas Concluídas</div>
                    <div class="text-2xl font-bold text-gray-900">{{ $completedTasks }} / {{ $totalTasks }}</div>
                    <div class="text-xs text-gray-500">{{ $completionPercentage }}% de conclusão total</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-red-500">
                    <div class="text-sm font-medium text-gray-500 uppercase">Tarefas Travadas</div>
                    <div class="text-2xl font-bold text-red-600">{{ $blockedTasks }}</div>
                    <div class="text-xs text-gray-500">Requerem atenção imediata</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-indigo-500">
                    <div class="text-sm font-medium text-gray-500 uppercase">Equipe Ativa</div>
                    <div class="text-2xl font-bold text-gray-900">{{ $teamWorkload->count() }}</div>
                    <div class="text-xs text-gray-500">Membros no projeto</div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Projects Progress -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-bold mb-4 text-gray-800">Progresso dos Sites</h3>
                    <div class="space-y-4">
                        @foreach($projectsProgress as $project)
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700">{{ $project->name }}</span>
                                    <span class="text-sm font-medium text-gray-700">{{ $project->progress }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $project->progress }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Team Workload -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-bold mb-4 text-gray-800">Carga de Trabalho da Equipe</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Membro</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tarefas Ativas</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($teamWorkload as $user)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-900 font-medium">{{ $user->name }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-600">{{ $user->tasks_count }} pendentes</td>
                                        <td class="px-4 py-3 text-right">
                                            @if($user->tasks_count > 5)
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Sobrecarregado</span>
                                            @else
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Disponível</span>
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
