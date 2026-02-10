<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-white leading-tight tracking-tight">
                {{ $project->name ?? 'Projeto sem nome' }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('tasks.create', ['project_id' => $project->id]) }}" class="btn-cyan font-black py-2.5 px-6 rounded-full text-[10px] uppercase tracking-widest shadow-lg">
                    + Nova Tarefa
                </a>
                    @if($project->owner_id === Auth::id())
                    <a href="{{ route('projects.edit', $project) }}" class="bg-white/5 border border-white/10 text-gray-400 hover:text-white hover:bg-white/10 font-black py-2.5 px-6 rounded-full text-[10px] uppercase tracking-widest transition-all">
                        Editar Projeto
                    </a>
                    <form action="{{ route('projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este projeto? Esta ação não pode ser desfeita.')">
                    @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500/10 border border-red-500/20 text-red-400 hover:text-red-300 hover:bg-red-500/20 font-black py-2.5 px-6 rounded-full text-[10px] uppercase tracking-widest transition-all">
                            Excluir Projeto
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-atlvs-cyan/10 border border-atlvs-cyan/20 text-atlvs-cyan px-6 py-4 rounded-2xl relative mb-8 flex items-center backdrop-blur-sm" role="alert">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <span class="block sm:inline font-bold text-sm uppercase tracking-tight">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Banner do Projeto -->
            @if($project->image_path)
                <div class="mb-8 rounded-3xl overflow-hidden border border-white/10">
                    <img src="{{ $project->image_url }}" alt="{{ $project->name }}" class="w-full h-64 object-cover">
                </div>
            @endif

            <div class="glass-card rounded-3xl p-10 mb-12">
                <h3 class="text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] mb-4">Descrição Estratégica</h3>
                <p class="text-gray-300 leading-relaxed text-lg font-medium">{{ $project->description ?: 'Sem descrição detalhada.' }}</p>
                <div class="mt-8 flex items-center text-[10px] text-gray-500 font-black uppercase tracking-widest">
                    <div class="w-6 h-6 rounded-full bg-atlvs-cyan/20 flex items-center justify-center mr-3">
                        <svg class="w-3 h-3 text-atlvs-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    Proprietário: <span class="text-white ml-2">{{ $project->owner->name ?? 'N/A' }}</span>
                </div>
            </div>

            <div class="flex items-center justify-between mb-8">
                <h3 class="text-xl font-bold text-white tracking-tight">Fluxo de Desenvolvimento</h3>
                <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest bg-white/5 px-4 py-2 rounded-full border border-white/5">{{ $project->tasks->count() }} Tarefas Ativas</span>
            </div>
            
            <div class="space-y-8">
                @forelse($project->tasks as $task)
                    <div class="glass-card rounded-3xl hover:border-atlvs-cyan/30 transition-all duration-500">
                        <div class="p-10 border-b border-white/5">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center mb-3">
                                        <h4 class="text-xl font-bold text-white">{{ $task->title ?? 'Tarefa sem título' }}</h4>
                                        @php
                                            $priorityColors = [
                                                'low' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
                                                'medium' => 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20',
                                                'high' => 'bg-red-500/10 text-red-500 border-red-500/20',
                                            ];
                                        @endphp
                                        <span class="ml-4 px-3 py-1 text-[9px] font-black uppercase tracking-[0.15em] rounded-full border {{ $priorityColors[$task->priority ?? 'low'] }}">
                                            {{ $task->priority ?? 'low' }}
                                        </span>
                                    </div>
                                    <p class="text-gray-500 text-sm leading-relaxed font-medium max-w-3xl">{{ $task->description ?: 'Sem descrição.' }}</p>
                                    
                                    <!-- Quick Links Display -->
                                    @if($task->figma_link || $task->repo_link || $task->staging_link)
                                        <div class="mt-6 flex flex-wrap gap-3">
                                            @if($task->figma_link)
                                                <a href="{{ $task->figma_link }}" target="_blank" class="flex items-center bg-purple-500/10 border border-purple-500/20 text-purple-400 px-3 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-purple-500/20 transition-all">
                                                    <svg class="w-3 h-3 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8z"/><path d="M12 6c-1.654 0-3 1.346-3 3s1.346 3 3 3 3-1.346 3-3-1.346-3-3-3zm0 4c-.551 0-1-.449-1-1s.449-1 1-1 1 .449 1 1-.449 1-1 1zm0 4c-1.654 0-3 1.346-3 3s1.346 3 3 3 3-1.346 3-3-1.346-3-3-3zm0 4c-.551 0-1-.449-1-1s.449-1 1-1 1 .449 1 1-.449 1-1 1z"/></svg>
                                                    Figma
                                                </a>
                                            @endif
                                            @if($task->repo_link)
                                                <a href="{{ $task->repo_link }}" target="_blank" class="flex items-center bg-gray-500/10 border border-gray-500/20 text-gray-400 px-3 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-gray-500/20 transition-all">
                                                    <svg class="w-3 h-3 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.042-1.416-4.042-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                                                    GitHub
                                                </a>
                                            @endif
                                            @if($task->staging_link)
                                                <a href="{{ $task->staging_link }}" target="_blank" class="flex items-center bg-atlvs-cyan/10 border border-atlvs-cyan/20 text-atlvs-cyan px-3 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-atlvs-cyan/20 transition-all">
                                                    <svg class="w-3 h-3 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                                                    Staging
                                                </a>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="ml-8">
                                    <form action="{{ route('tasks.updateStatus', $task) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" class="bg-black text-[10px] font-black text-white border-white/10 rounded-xl px-4 py-2 focus:border-atlvs-cyan focus:ring-0 transition-all uppercase tracking-widest cursor-pointer">
                                            <option value="pending" {{ ($task->status ?? 'pending') == 'pending' ? 'selected' : '' }}>PENDENTE</option>
                                            <option value="in_progress" {{ ($task->status ?? 'pending') == 'in_progress' ? 'selected' : '' }}>EM ANDAMENTO</option>
                                            <option value="blocked" {{ ($task->status ?? 'pending') == 'blocked' ? 'selected' : '' }}>TRAVADO</option>
                                            <option value="completed" {{ ($task->status ?? 'pending') == 'completed' ? 'selected' : '' }}>CONCLUÍDO</option>
                                        </select>
                                    </form>
                                </div>
                            </div>
                            
                            <div class="mt-10 flex justify-between items-center">
                                <div class="flex items-center bg-white/5 px-4 py-2 rounded-2xl border border-white/5">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-atlvs-cyan to-white flex items-center justify-center text-black text-[10px] font-black mr-3 shadow-lg">
                                        {{ strtoupper(substr($task->assignee->name ?? '?', 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="text-[9px] font-black text-gray-600 uppercase tracking-tighter">Responsável</p>
                                        <p class="text-xs text-white font-bold">{{ $task->assignee->name ?? 'Livre para assumir' }}</p>
                                    </div>
                                </div>
                                <div class="flex space-x-6">
                                    <a href="{{ route('tasks.edit', $task) }}" class="text-gray-600 hover:text-atlvs-cyan transition-all transform hover:scale-110">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-600 hover:text-red-500 transition-all transform hover:scale-110" onclick="return confirm('Tem certeza que deseja excluir esta tarefa?')">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Details Section (History, Comments & Resources) -->
                        <div x-data="{ activeTab: 'comments' }" class="bg-white/[0.02] p-10">
                            <div class="flex space-x-8 mb-8 border-b border-white/5">
                                <button @click="activeTab = 'comments'" :class="activeTab === 'comments' ? 'text-atlvs-cyan border-b-2 border-atlvs-cyan' : 'text-gray-500'" class="pb-4 text-[10px] font-black uppercase tracking-[0.2em] transition-all">
                                    Discussão Técnica ({{ $task->comments->count() ?? 0 }})
                                </button>
                                <button @click="activeTab = 'resources'" :class="activeTab === 'resources' ? 'text-atlvs-cyan border-b-2 border-atlvs-cyan' : 'text-gray-500'" class="pb-4 text-[10px] font-black uppercase tracking-[0.2em] transition-all">
                                    Recursos & Anexos ({{ $task->attachments->count() ?? 0 }})
                                </button>
                                <button @click="activeTab = 'history'" :class="activeTab === 'history' ? 'text-atlvs-cyan border-b-2 border-atlvs-cyan' : 'text-gray-500'" class="pb-4 text-[10px] font-black uppercase tracking-[0.2em] transition-all">
                                    Histórico
                                </button>
                            </div>
                            
                            <!-- Comments Tab -->
                            <div x-show="activeTab === 'comments'" class="space-y-6">
                                <div class="space-y-6 mb-10">
                                    @foreach($task->comments ?? [] as $comment)
                                        <div class="bg-white/5 p-6 rounded-2xl border border-white/5 hover:border-white/10 transition-all">
                                            <div class="flex justify-between items-center mb-3">
                                                <span class="text-[10px] font-black text-atlvs-cyan uppercase tracking-widest">{{ $comment->user->name ?? 'Usuário Desconhecido' }}</span>
                                                <span class="text-[9px] font-bold text-gray-600 uppercase">{{ $comment->created_at ? $comment->created_at->diffForHumans() : '' }}</span>
                                            </div>
                                            <p class="text-sm text-gray-400 leading-relaxed font-medium">{{ $comment->content }}</p>
                                            @if($comment->user_id === Auth::id())
                                                <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="mt-4 pt-4 border-t border-white/5">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-[9px] font-black text-red-500/50 hover:text-red-500 uppercase tracking-widest transition-colors">Remover comentário</button>
                                                </form>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>

                                <form action="{{ route('comments.store', $task) }}" method="POST">
                                    @csrf
                                    <div class="flex space-x-4">
                                        <input type="text" name="content" placeholder="Escreva uma atualização técnica..." class="flex-1 bg-black text-sm text-white rounded-2xl border-white/10 shadow-sm focus:border-atlvs-cyan focus:ring-0 transition-all placeholder-gray-700 font-medium" required>
                                        <button type="submit" class="btn-cyan font-black text-[9px] uppercase tracking-widest py-3 px-8 rounded-2xl shadow-xl">
                                            Enviar
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Resources Tab -->
                            <div x-show="activeTab === 'resources'" class="space-y-8">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <!-- Attachments List -->
                                    <div>
                                        <h5 class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-4">Arquivos Anexados</h5>
                                        <div class="space-y-3">
                                            @forelse($task->attachments ?? [] as $attachment)
                                                <div class="flex items-center justify-between bg-white/5 p-4 rounded-2xl border border-white/5">
                                                    <div class="flex items-center">
                                                        <svg class="w-5 h-5 text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                                        <div>
                                                            <p class="text-xs text-white font-bold truncate max-w-[150px]">{{ $attachment->file_name ?? 'Arquivo sem nome' }}</p>
                                                            <p class="text-[9px] text-gray-600 uppercase font-black">{{ number_format(($attachment->file_size ?? 0) / 1024, 1) }} KB</p>
                                                        </div>
                                                    </div>
                                                    <div class="flex space-x-3">
                                                        @if($attachment->file_path)
                                                            <a href="{{ route("storage.show", ["path" => $attachment->file_path]) }}" target="_blank" class="text-atlvs-cyan hover:text-white transition-colors">
                                                        @else
                                                            <a href="#" class="text-gray-500 cursor-not-allowed">
                                                        @endif
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                                        </a>
                                                        <form action="{{ route('attachments.destroy', $attachment) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-500/50 hover:text-red-500 transition-colors" onclick="return confirm('Remover este arquivo?')">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @empty
                                                <p class="text-[10px] text-gray-600 italic uppercase font-black">Nenhum arquivo enviado.</p>
                                            @endforelse
                                        </div>
                                        
                                        <form action="{{ route('tasks.attachments.store', $task) }}" method="POST" enctype="multipart/form-data" class="mt-6">
                                            @csrf
                                            <label for="attachment-{{ $task->id }}" class="flex items-center justify-center w-full px-4 py-6 bg-black border-2 border-dashed border-white/10 rounded-2xl cursor-pointer hover:bg-white/5 transition-all">
                                                <div class="text-center">
                                                    <svg class="mx-auto h-8 w-8 text-gray-600" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                                    <p class="mt-2 text-xs text-gray-500">Arraste e solte ou <span class="font-bold text-atlvs-cyan">clique para enviar</span></p>
                                                    <p class="mt-1 text-[9px] text-gray-700">PNG, JPG, PDF, etc. (Max 5MB)</p>
                                                </div>
                                                <input id="attachment-{{ $task->id }}" name="attachment" type="file" class="sr-only" onchange="this.form.submit()">
                                            </label>
                                        </form>
                                    </div>

                                    <!-- Quick Links Edit -->
                                    <div>
                                        <h5 class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-4">Links Rápidos</h5>
                                        <form action="{{ route('tasks.updateLinks', $task) }}" method="POST" class="space-y-4">
                                            @csrf
                                            @method('PATCH')
                                            <div>
                                                <label for="figma_link" class="text-xs font-bold text-gray-400">Figma</label>
                                                <input type="url" name="figma_link" value="{{ $task->figma_link }}" placeholder="https://figma.com/..." class="mt-1 block w-full bg-black text-sm text-white rounded-xl border-white/10 shadow-sm focus:border-atlvs-cyan focus:ring-0 transition-all placeholder-gray-700 font-medium">
                                            </div>
                                            <div>
                                                <label for="repo_link" class="text-xs font-bold text-gray-400">GitHub Repo</label>
                                                <input type="url" name="repo_link" value="{{ $task->repo_link }}" placeholder="https://github.com/..." class="mt-1 block w-full bg-black text-sm text-white rounded-xl border-white/10 shadow-sm focus:border-atlvs-cyan focus:ring-0 transition-all placeholder-gray-700 font-medium">
                                            </div>
                                            <div>
                                                <label for="staging_link" class="text-xs font-bold text-gray-400">Staging URL</label>
                                                <input type="url" name="staging_link" value="{{ $task->staging_link }}" placeholder="https://staging.site.com" class="mt-1 block w-full bg-black text-sm text-white rounded-xl border-white/10 shadow-sm focus:border-atlvs-cyan focus:ring-0 transition-all placeholder-gray-700 font-medium">
                                            </div>
                                            <button type="submit" class="w-full btn-cyan font-black text-[9px] uppercase tracking-widest py-3 rounded-xl shadow-xl mt-2">Salvar Links</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- History Tab -->
                            <div x-show="activeTab === 'history'" class="space-y-4">
                                @forelse($task->activityLogs ?? [] as $log)
                                    <div class="flex space-x-4 items-start text-xs text-gray-400">
                                        <div class="w-1.5 h-1.5 rounded-full bg-atlvs-cyan mt-1.5 shadow-[0_0_5px_rgba(6,182,212,0.5)]"></div>
                                        <div class="flex-1">
                                            <span class="text-white font-bold">{{ $log->user->name ?? 'Sistema' }}</span>
                                            <span class="text-gray-500">{{ $log->description }}</span>
                                            <span class="text-[9px] font-bold text-gray-600 uppercase">{{ $log->created_at ? $log->created_at->diffForHumans() : '' }}</span>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-xs text-gray-600 italic">Nenhuma atividade registrada ainda.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-16 glass-card rounded-3xl">
                        <svg class="mx-auto h-12 w-12 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                        </svg>
                        <h3 class="mt-4 text-lg font-bold text-white">Sem tarefas por aqui</h3>
                        <p class="mt-1 text-sm text-gray-500">Comece adicionando uma nova tarefa a este projeto.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
