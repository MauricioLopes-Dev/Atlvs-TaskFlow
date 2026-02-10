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

            <!-- Mensagem de Bem-vindo -->
            <div class="glass-card p-8 rounded-2xl border border-atlvs-cyan/30 bg-atlvs-cyan/5 text-center">
                <h2 class="text-2xl font-bold text-white mb-2">Bem-vindo ao Atlvs TaskFlow!</h2>
                <p class="text-gray-400">Você tem <strong class="text-atlvs-cyan">{{ $totalProjects }}</strong> projeto(s) ativo(s). Acesse a aba de <strong class="text-atlvs-cyan">Projetos</strong> para gerenciar suas tarefas.</p>
            </div>

        </div>
    </div>
</x-app-layout>
