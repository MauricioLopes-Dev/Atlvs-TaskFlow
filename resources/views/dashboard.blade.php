<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Header com Título e Boas-vindas -->
            <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white tracking-tight">Dashboard de Gestão</h1>
                    <p class="text-gray-400 mt-1">Visão geral da saúde dos seus projetos e equipe.</p>
                </div>
                <div class="mt-4 md:mt-0 flex space-x-3">
                    <a href="{{ route('projects.create') }}" class="inline-flex items-center px-4 py-2 bg-cyan-600 hover:bg-cyan-500 text-white text-sm font-bold rounded-xl transition-all duration-300 shadow-lg shadow-cyan-900/20">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Novo Projeto
                    </a>
                </div>
            </div>

            <!-- Cards de KPIs Rápidos -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Projetos -->
                <div class="glass-card p-6 rounded-2xl border border-white/10 flex items-center space-x-4 animate-fade-in">
                    <div class="p-3 bg-blue-500/20 rounded-xl">
                        <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400 font-medium">Projetos Ativos</p>
                        <h3 class="text-2xl font-bold text-white">{{ $totalProjects ?? 0 }}</h3>
                    </div>
                </div>

                <!-- Total Tarefas -->
                <div class="glass-card p-6 rounded-2xl border border-white/10 flex items-center space-x-4 animate-fade-in" style="animation-delay: 100ms">
                    <div class="p-3 bg-cyan-500/20 rounded-xl">
                        <svg class="w-8 h-8 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400 font-medium">Total de Tarefas</p>
                        <h3 class="text-2xl font-bold text-white">{{ $totalTasks ?? 0 }}</h3>
                    </div>
                </div>

                <!-- Concluídas -->
                <div class="glass-card p-6 rounded-2xl border border-white/10 flex items-center space-x-4 animate-fade-in" style="animation-delay: 200ms">
                    <div class="p-3 bg-green-500/20 rounded-xl">
                        <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400 font-medium">Concluídas</p>
                        <h3 class="text-2xl font-bold text-white">{{ $completedTasks ?? 0 }}</h3>
                    </div>
                </div>

                <!-- Travadas (Gargalo) -->
                <div class="glass-card p-6 rounded-2xl border border-red-500/30 bg-red-500/5 flex items-center space-x-4 animate-fade-in" style="animation-delay: 300ms">
                    <div class="p-3 bg-red-500/20 rounded-xl">
                        <svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm text-red-400 font-bold">Travadas (Gargalo)</p>
                        <h3 class="text-2xl font-bold text-white">{{ $blockedTasks ?? 0 }}</h3>
                    </div>
                </div>
            </div>

            <!-- Alertas de Prazos -->
            @if(($overdueTasks && $overdueTasks->count() > 0) || ($todayTasks && $todayTasks->count() > 0) || ($upcomingTasks && $upcomingTasks->count() > 0))
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Tarefas Atrasadas -->
                <div class="glass-card p-6 rounded-2xl border border-red-500/30 bg-red-500/5 animate-fade-in">
                    <h3 class="text-sm font-bold text-red-400 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                        Atrasadas ({{ $overdueTasks ? $overdueTasks->count() : 0 }})
                    </h3>
                    <div class="space-y-2">
                        @forelse($overdueTasks as $task)
                            <a href="{{ route('projects.show', $task->project_id) }}" class="block bg-red-500/10 border border-red-500/20 rounded-xl p-3 hover:bg-red-500/20 transition-all">
                                <p class="text-xs font-bold text-white truncate">{{ $task->title }}</p>
                                <p class="text-[9px] text-red-400 mt-1">Vencimento: {{ $task->due_date ? $task->due_date->format('d/m/Y') : 'N/A' }}</p>
                            </a>
                        @empty
                            <p class="text-xs text-gray-600 italic">Nenhuma tarefa atrasada.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Tarefas Vencendo Hoje -->
                <div class="glass-card p-6 rounded-2xl border border-atlvs-cyan/30 bg-atlvs-cyan/5 animate-fade-in" style="animation-delay: 100ms">
                    <h3 class="text-sm font-bold text-atlvs-cyan mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        Vencem Hoje ({{ $todayTasks ? $todayTasks->count() : 0 }})
                    </h3>
                    <div class="space-y-2">
                        @forelse($todayTasks as $task)
                            <a href="{{ route('projects.show', $task->project_id) }}" class="block bg-atlvs-cyan/10 border border-atlvs-cyan/20 rounded-xl p-3 hover:bg-atlvs-cyan/20 transition-all">
                                <p class="text-xs font-bold text-white truncate">{{ $task->title }}</p>
                                <p class="text-[9px] text-atlvs-cyan mt-1">Vencimento: {{ $task->due_date ? $task->due_date->format('d/m/Y') : 'N/A' }}</p>
                            </a>
                        @empty
                            <p class="text-xs text-gray-600 italic">Nenhuma tarefa vencendo hoje.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Tarefas Próximas (3 dias) -->
                <div class="glass-card p-6 rounded-2xl border border-yellow-500/30 bg-yellow-500/5 animate-fade-in" style="animation-delay: 200ms">
                    <h3 class="text-sm font-bold text-yellow-400 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        Próximas ({{ $upcomingTasks ? $upcomingTasks->count() : 0 }})
                    </h3>
                    <div class="space-y-2">
                        @forelse($upcomingTasks as $task)
                            <a href="{{ route('projects.show', $task->project_id) }}" class="block bg-yellow-500/10 border border-yellow-500/20 rounded-xl p-3 hover:bg-yellow-500/20 transition-all">
                                <p class="text-xs font-bold text-white truncate">{{ $task->title }}</p>
                                <p class="text-[9px] text-yellow-400 mt-1">Vencimento: {{ $task->due_date ? $task->due_date->format('d/m/Y') : 'N/A' }}</p>
                            </a>
                        @empty
                            <p class="text-xs text-gray-600 italic">Nenhuma tarefa próxima.</p>
                        @endforelse
                    </div>
                </div>
            </div>
            @endif

            <!-- Seção de Gráficos -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Gráfico de Status Geral -->
                <div class="glass-card p-8 rounded-2xl border border-white/10">
                    <h3 class="text-lg font-bold text-white mb-6">Distribuição de Status</h3>
                    <div class="h-64">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>

                <!-- Carga de Trabalho da Equipe -->
                <div class="glass-card p-8 rounded-2xl border border-white/10">
                    <h3 class="text-lg font-bold text-white mb-6">Carga de Trabalho da Equipe</h3>
                    <div class="h-64">
                        <canvas id="teamChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Progresso por Projeto -->
            @if($projectsProgress && $projectsProgress->count() > 0)
            <div class="glass-card p-8 rounded-2xl border border-white/10 mb-8">
                <h3 class="text-lg font-bold text-white mb-6">Saúde dos Projetos (Sites)</h3>
                <div class="space-y-6">
                    @foreach($projectsProgress as $project)
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-white font-medium">{{ $project->name }}</span>
                            <span class="text-cyan-400 font-bold">{{ $project->progress ?? 0 }}%</span>
                        </div>
                        <div class="w-full bg-gray-800 rounded-full h-3 overflow-hidden">
                            <div class="bg-gradient-to-r from-cyan-600 to-blue-500 h-3 rounded-full transition-all duration-1000" style="width: {{ $project->progress ?? 0 }}%"></div>
                        </div>
                        <div class="flex justify-between mt-1">
                            <span class="text-xs text-gray-500">{{ $project->tasks_count ?? 0 }} tarefas totais</span>
                            <span class="text-xs text-gray-500">{{ $project->completed_tasks_count ?? 0 }} concluídas</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>

    <!-- Scripts para Gráficos -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Configuração Global do Chart.js para Tema Escuro
            Chart.defaults.color = '#9ca3af';
            Chart.defaults.font.family = "'Instrument Sans', sans-serif";

            // Gráfico de Status (Doughnut)
            const statusCtx = document.getElementById('statusChart');
            if (statusCtx) {
                new Chart(statusCtx.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Pendente', 'Em Andamento', 'Travado', 'Concluído'],
                        datasets: [{
                            data: [{{ $pendingTasks ?? 0 }}, {{ $inProgressTasks ?? 0 }}, {{ $blockedTasks ?? 0 }}, {{ $completedTasks ?? 0 }}],
                            backgroundColor: ['#4b5563', '#0ea5e9', '#ef4444', '#22c55e'],
                            borderWidth: 0,
                            hoverOffset: 10
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { position: 'right' }
                        },
                        cutout: '70%'
                    }
                });
            }

            // Gráfico de Equipe (Bar)
            const teamCtx = document.getElementById('teamChart');
            if (teamCtx) {
                new Chart(teamCtx.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($teamWorkload && $teamWorkload->count() > 0 ? $teamWorkload->pluck('name') : []) !!},
                        datasets: [
                            {
                                label: 'Em Andamento',
                                data: {!! json_encode($teamWorkload && $teamWorkload->count() > 0 ? $teamWorkload->pluck('in_progress_count') : []) !!},
                                backgroundColor: '#0ea5e9',
                                borderRadius: 6
                            },
                            {
                                label: 'Travado',
                                data: {!! json_encode($teamWorkload && $teamWorkload->count() > 0 ? $teamWorkload->pluck('blocked_count') : []) !!},
                                backgroundColor: '#ef4444',
                                borderRadius: 6
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: { stacked: true, grid: { display: false } },
                            y: { stacked: true, grid: { color: 'rgba(255,255,255,0.05)' } }
                        },
                        plugins: {
                            legend: { position: 'top' }
                        }
                    }
                });
            }
        });
    </script>

    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fade-in 0.5s ease-out forwards;
        }
    </style>
</x-app-layout>
