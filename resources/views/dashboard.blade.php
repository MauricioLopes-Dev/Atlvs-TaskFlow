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
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
                <!-- Total Projetos -->
                <div class="glass-card p-6 rounded-2xl border border-white/10 flex items-center space-x-4 animate-fade-in">
                    <div class="p-3 bg-blue-500/20 rounded-xl">
                        <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400 font-medium">Projetos</p>
                        <h3 class="text-2xl font-bold text-white">{{ $totalProjects ?? 0 }}</h3>
                    </div>
                </div>

                <!-- Total Tarefas -->
                <div class="glass-card p-6 rounded-2xl border border-white/10 flex items-center space-x-4 animate-fade-in" style="animation-delay: 100ms">
                    <div class="p-3 bg-cyan-500/20 rounded-xl">
                        <svg class="w-8 h-8 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400 font-medium">Total</p>
                        <h3 class="text-2xl font-bold text-white">{{ $totalTasks ?? 0 }}</h3>
                    </div>
                </div>

                <!-- Pendentes -->
                <div class="glass-card p-6 rounded-2xl border border-yellow-500/30 bg-yellow-500/5 flex items-center space-x-4 animate-fade-in" style="animation-delay: 200ms">
                    <div class="p-3 bg-yellow-500/20 rounded-xl">
                        <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm text-yellow-400 font-medium">Pendentes</p>
                        <h3 class="text-2xl font-bold text-white">{{ $pendingTasks ?? 0 }}</h3>
                    </div>
                </div>

                <!-- Em Andamento -->
                <div class="glass-card p-6 rounded-2xl border border-atlvs-cyan/30 bg-atlvs-cyan/5 flex items-center space-x-4 animate-fade-in" style="animation-delay: 300ms">
                    <div class="p-3 bg-atlvs-cyan/20 rounded-xl">
                        <svg class="w-8 h-8 text-atlvs-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm text-atlvs-cyan font-medium">Em Andamento</p>
                        <h3 class="text-2xl font-bold text-white">{{ $inProgressTasks ?? 0 }}</h3>
                    </div>
                </div>

                <!-- Concluídas -->
                <div class="glass-card p-6 rounded-2xl border border-green-500/30 bg-green-500/5 flex items-center space-x-4 animate-fade-in" style="animation-delay: 400ms">
                    <div class="p-3 bg-green-500/20 rounded-xl">
                        <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm text-green-400 font-medium">Concluídas</p>
                        <h3 class="text-2xl font-bold text-white">{{ $completedTasks ?? 0 }}</h3>
                    </div>
                </div>
            </div>

            <!-- Barra de Progresso Geral -->
            @if($totalTasks > 0)
            <div class="glass-card p-8 rounded-2xl border border-white/10 mb-8">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-white">Taxa de Conclusão Geral</h3>
                    <span class="text-2xl font-bold text-atlvs-cyan">{{ $completionPercentage ?? 0 }}%</span>
                </div>
                <div class="w-full bg-white/5 rounded-full h-3 border border-white/10">
                    <div class="bg-gradient-to-r from-atlvs-cyan to-cyan-400 h-3 rounded-full transition-all duration-500" style="width: {{ $completionPercentage ?? 0 }}%"></div>
                </div>
            </div>
            @endif

            <!-- Mensagem de Bem-vindo -->
            <div class="glass-card p-8 rounded-2xl border border-atlvs-cyan/30 bg-atlvs-cyan/5 text-center">
                <h2 class="text-2xl font-bold text-white mb-2">Bem-vindo ao Atlvs TaskFlow!</h2>
                <p class="text-gray-400">Você tem <strong class="text-atlvs-cyan">{{ $totalProjects }}</strong> projeto(s) e <strong class="text-atlvs-cyan">{{ $totalTasks }}</strong> tarefa(s). Acesse a aba de <strong class="text-atlvs-cyan">Projetos</strong> para gerenciar suas tarefas.</p>
            </div>

        </div>
    </div>
</x-app-layout>
