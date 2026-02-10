<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-white leading-tight tracking-tight">
                Calendário de Prazos
            </h2>
            <a href="{{ route('projects.index') }}" class="bg-white/5 border border-white/10 text-gray-400 hover:text-white hover:bg-white/10 font-black py-2.5 px-6 rounded-full text-[10px] uppercase tracking-widest transition-all">
                Voltar
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Legenda de Status -->
            <div class="glass-card rounded-3xl p-6 mb-8">
                <h3 class="text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] mb-4">Legenda de Status</h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-4 h-4 rounded bg-atlvs-cyan shadow-[0_0_8px_rgba(6,182,212,0.5)]"></div>
                        <span class="text-xs text-gray-300">Vence Hoje</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-4 h-4 rounded bg-yellow-500"></div>
                        <span class="text-xs text-gray-300">Próximo (3 dias)</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-4 h-4 rounded bg-red-500"></div>
                        <span class="text-xs text-gray-300">Atrasado</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-4 h-4 rounded bg-green-500"></div>
                        <span class="text-xs text-gray-300">Concluído</span>
                    </div>
                </div>
            </div>

            <!-- Calendário -->
            <div class="glass-card rounded-3xl p-8">
                <div id="calendar"></div>
            </div>

            <!-- Lista de Tarefas Próximas -->
            <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Atrasadas -->
                <div class="glass-card rounded-3xl p-6">
                    <h3 class="text-[10px] font-black text-red-500 uppercase tracking-[0.2em] mb-4 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                        Atrasadas
                    </h3>
                    <div id="overdue-tasks" class="space-y-3">
                        <p class="text-[9px] text-gray-600 italic">Carregando...</p>
                    </div>
                </div>

                <!-- Próximas (3 dias) -->
                <div class="glass-card rounded-3xl p-6">
                    <h3 class="text-[10px] font-black text-yellow-500 uppercase tracking-[0.2em] mb-4 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        Próximas (3 dias)
                    </h3>
                    <div id="upcoming-tasks" class="space-y-3">
                        <p class="text-[9px] text-gray-600 italic">Carregando...</p>
                    </div>
                </div>

                <!-- Vence Hoje -->
                <div class="glass-card rounded-3xl p-6">
                    <h3 class="text-[10px] font-black text-atlvs-cyan uppercase tracking-[0.2em] mb-4 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        Vence Hoje
                    </h3>
                    <div id="today-tasks" class="space-y-3">
                        <p class="text-[9px] text-gray-600 italic">Carregando...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet" />
    
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'pt-br',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,listMonth'
                },
                events: function(info, successCallback, failureCallback) {
                    fetch('{{ route("calendar.getEvents") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            start: info.startStr,
                            end: info.endStr
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        successCallback(data);
                        updateTaskLists(data);
                    })
                    .catch(error => {
                        console.error('Erro ao carregar eventos:', error);
                        failureCallback(error);
                    });
                },
                eventClick: function(info) {
                    window.location.href = info.event.url;
                },
                eventDisplay: 'block',
                eventClassNames: function(info) {
                    return [info.event.classNames[0] || 'bg-gray-500'];
                }
            });
            calendar.render();

            // Função para atualizar as listas de tarefas
            function updateTaskLists(events) {
                const today = new Date();
                today.setHours(0, 0, 0, 0);

                const overdueTasks = [];
                const upcomingTasks = [];
                const todayTasks = [];

                events.forEach(event => {
                    const eventDate = new Date(event.start);
                    eventDate.setHours(0, 0, 0, 0);
                    const daysUntil = Math.floor((eventDate - today) / (1000 * 60 * 60 * 24));

                    if (daysUntil < 0) {
                        overdueTasks.push(event);
                    } else if (daysUntil === 0) {
                        todayTasks.push(event);
                    } else if (daysUntil <= 3) {
                        upcomingTasks.push(event);
                    }
                });

                // Renderizar tarefas atrasadas
                const overdueContainer = document.getElementById('overdue-tasks');
                if (overdueTasks.length > 0) {
                    overdueContainer.innerHTML = overdueTasks.map(task => `
                        <a href="${task.url}" class="block bg-red-500/10 border border-red-500/20 rounded-xl p-3 hover:bg-red-500/20 transition-all">
                            <p class="text-xs font-bold text-white truncate">${task.title}</p>
                            <p class="text-[9px] text-red-400 mt-1">${new Date(task.start).toLocaleDateString('pt-BR')}</p>
                        </a>
                    `).join('');
                } else {
                    overdueContainer.innerHTML = '<p class="text-[9px] text-gray-600 italic">Nenhuma tarefa atrasada</p>';
                }

                // Renderizar tarefas próximas
                const upcomingContainer = document.getElementById('upcoming-tasks');
                if (upcomingTasks.length > 0) {
                    upcomingContainer.innerHTML = upcomingTasks.map(task => `
                        <a href="${task.url}" class="block bg-yellow-500/10 border border-yellow-500/20 rounded-xl p-3 hover:bg-yellow-500/20 transition-all">
                            <p class="text-xs font-bold text-white truncate">${task.title}</p>
                            <p class="text-[9px] text-yellow-400 mt-1">${new Date(task.start).toLocaleDateString('pt-BR')}</p>
                        </a>
                    `).join('');
                } else {
                    upcomingContainer.innerHTML = '<p class="text-[9px] text-gray-600 italic">Nenhuma tarefa próxima</p>';
                }

                // Renderizar tarefas de hoje
                const todayContainer = document.getElementById('today-tasks');
                if (todayTasks.length > 0) {
                    todayContainer.innerHTML = todayTasks.map(task => `
                        <a href="${task.url}" class="block bg-atlvs-cyan/10 border border-atlvs-cyan/20 rounded-xl p-3 hover:bg-atlvs-cyan/20 transition-all">
                            <p class="text-xs font-bold text-white truncate">${task.title}</p>
                            <p class="text-[9px] text-atlvs-cyan mt-1">${new Date(task.start).toLocaleDateString('pt-BR')}</p>
                        </a>
                    `).join('');
                } else {
                    todayContainer.innerHTML = '<p class="text-[9px] text-gray-600 italic">Nenhuma tarefa vencendo hoje</p>';
                }
            }
        });
    </script>

    <style>
        /* Customização do FullCalendar para tema Atlvs */
        .fc {
            --fc-border-color: rgba(255, 255, 255, 0.1);
            --fc-button-bg-color: rgba(6, 182, 212, 0.2);
            --fc-button-border-color: rgba(6, 182, 212, 0.3);
            --fc-button-hover-bg-color: rgba(6, 182, 212, 0.3);
            --fc-button-active-bg-color: rgba(6, 182, 212, 0.5);
            --fc-text-muted-color: #999;
        }

        .fc .fc-button-primary {
            background-color: rgba(6, 182, 212, 0.2);
            border-color: rgba(6, 182, 212, 0.3);
            color: #06b6d4;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.75rem;
        }

        .fc .fc-button-primary:hover {
            background-color: rgba(6, 182, 212, 0.3);
            border-color: rgba(6, 182, 212, 0.5);
        }

        .fc .fc-button-primary:not(:disabled).fc-button-active {
            background-color: rgba(6, 182, 212, 0.5);
            border-color: rgba(6, 182, 212, 0.7);
        }

        .fc th {
            background-color: rgba(255, 255, 255, 0.02);
            border-color: rgba(255, 255, 255, 0.05);
            color: #999;
            font-weight: 700;
            font-size: 0.75rem;
            text-transform: uppercase;
            padding: 12px 0;
        }

        .fc td {
            border-color: rgba(255, 255, 255, 0.05);
            background-color: rgba(0, 0, 0, 0.2);
        }

        .fc .fc-daygrid-day {
            background-color: rgba(0, 0, 0, 0.1);
        }

        .fc .fc-daygrid-day:hover {
            background-color: rgba(6, 182, 212, 0.05);
        }

        .fc .fc-daygrid-day.fc-day-other {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .fc .fc-daygrid-day-number {
            color: #999;
            font-size: 0.85rem;
            padding: 8px;
        }

        .fc .fc-daygrid-day.fc-day-today {
            background-color: rgba(6, 182, 212, 0.1);
        }

        .fc .fc-daygrid-day.fc-day-today .fc-daygrid-day-number {
            color: #06b6d4;
            font-weight: 700;
        }

        .fc .fc-event {
            background-color: rgba(6, 182, 212, 0.2);
            border-color: rgba(6, 182, 212, 0.3);
            color: #06b6d4;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 2px 4px;
            border-radius: 4px;
            cursor: pointer;
        }

        .fc .fc-event:hover {
            background-color: rgba(6, 182, 212, 0.3);
        }

        .fc .fc-event.bg-red-500 {
            background-color: rgba(239, 68, 68, 0.2) !important;
            border-color: rgba(239, 68, 68, 0.3) !important;
            color: #ef4444 !important;
        }

        .fc .fc-event.bg-yellow-500 {
            background-color: rgba(234, 179, 8, 0.2) !important;
            border-color: rgba(234, 179, 8, 0.3) !important;
            color: #eab308 !important;
        }

        .fc .fc-event.bg-green-500 {
            background-color: rgba(34, 197, 94, 0.2) !important;
            border-color: rgba(34, 197, 94, 0.3) !important;
            color: #22c55e !important;
        }

        .fc .fc-col-header-cell {
            background-color: rgba(255, 255, 255, 0.02);
        }

        .fc .fc-list-event-title {
            color: #fff;
            font-weight: 700;
        }

        .fc .fc-list-event-time {
            color: #999;
        }

        .fc-theme-standard td, .fc-theme-standard th {
            border-color: rgba(255, 255, 255, 0.05);
        }
    </style>
</x-app-layout>
