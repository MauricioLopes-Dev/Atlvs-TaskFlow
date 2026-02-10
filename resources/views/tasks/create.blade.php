<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white leading-tight tracking-tight">
            Nova Tarefa: <span class="text-atlvs-cyan">{{ $project->name }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-card rounded-3xl p-10">
                <form action="{{ route('tasks.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="project_id" value="{{ $project->id }}">

                    <div class="mb-8">
                        <label for="title" class="block text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] mb-2">Título da Tarefa</label>
                        <input type="text" name="title" id="title" class="w-full bg-black border-white/10 rounded-2xl text-white focus:border-atlvs-cyan focus:ring-0 transition-all placeholder-gray-800 font-medium" placeholder="Ex: Implementar API de Pagamento" value="{{ old("title") }}" required>
                        @error("title")
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-8">
                        <label for="description" class="block text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] mb-2">Descrição Técnica</label>
                        <textarea name="description" id="description" rows="4" class="w-full bg-black border-white/10 rounded-2xl text-white focus:border-atlvs-cyan focus:ring-0 transition-all placeholder-gray-800 font-medium" placeholder="Descreva os requisitos e detalhes técnicos...">{{ old("description") }}</textarea>
                        @error("description")
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div>
                            <label for="priority" class="block text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] mb-2">Prioridade</label>
                            <select name="priority" id="priority" class="w-full bg-black border-white/10 rounded-2xl text-white focus:border-atlvs-cyan focus:ring-0 transition-all uppercase text-[10px] font-black tracking-widest cursor-pointer">
                                <option value="low" {{ old("priority") == "low" ? "selected" : "" }}>Baixa</option>
                                <option value="medium" {{ old("priority", "medium") == "medium" ? "selected" : "" }}>Média</option>
                                <option value="high" {{ old("priority") == "high" ? "selected" : "" }}>Alta</option>
                            </select>
                        </div>

                        <div>
                            <label for="status" class="block text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] mb-2">Status Inicial</label>
                            <select name="status" id="status" class="w-full bg-black border-white/10 rounded-2xl text-white focus:border-atlvs-cyan focus:ring-0 transition-all uppercase text-[10px] font-black tracking-widest cursor-pointer">
                                <option value="pending" {{ old("status", "pending") == "pending" ? "selected" : "" }}>Pendente</option>
                                <option value="in_progress" {{ old("status") == "in_progress" ? "selected" : "" }}>Em Andamento</option>
                                <option value="blocked" {{ old("status") == "blocked" ? "selected" : "" }}>Travado</option>
                                <option value="completed" {{ old("status") == "completed" ? "selected" : "" }}>Concluído</option>
                            </select>
                        </div>

                        <div>
                            <label for="assigned_to" class="block text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] mb-2">Atribuir a</label>
                            <select name="assigned_to" id="assigned_to" class="w-full bg-black border-white/10 rounded-2xl text-white focus:border-atlvs-cyan focus:ring-0 transition-all uppercase text-[10px] font-black tracking-widest cursor-pointer">
                                <option value="">Livre para assumir</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old("assigned_to") == $user->id ? "selected" : "" }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-8">
                        <label for="due_date" class="block text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] mb-2">Data de Entrega</label>
                        <input type="date" name="due_date" id="due_date" class="w-full bg-black border-white/10 rounded-2xl text-white focus:border-atlvs-cyan focus:ring-0 transition-all font-medium" value="{{ old("due_date") }}">
                        @error("due_date")
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="border-t border-white/5 pt-8 mb-8">
                        <h3 class="text-[10px] font-black text-atlvs-cyan uppercase tracking-[0.2em] mb-6">Links de Referência (Opcional)</h3>
                        <div class="space-y-4">
                            <div>
                                <label for="figma_link" class="block text-[9px] font-black text-gray-600 uppercase tracking-widest mb-1">Figma Design</label>
                                <input type="url" name="figma_link" id="figma_link" placeholder="https://figma.com/file/..." class="w-full bg-black border-white/10 rounded-xl text-xs text-white focus:border-atlvs-cyan focus:ring-0" value="{{ old("figma_link") }}">
                                @error("figma_link")
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="repo_link" class="block text-[9px] font-black text-gray-600 uppercase tracking-widest mb-1">Repositório GitHub</label>
                                <input type="url" name="repo_link" id="repo_link" placeholder="https://github.com/..." class="w-full bg-black border-white/10 rounded-xl text-xs text-white focus:border-atlvs-cyan focus:ring-0" value="{{ old("repo_link") }}">
                                @error("repo_link")
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="staging_link" class="block text-[9px] font-black text-gray-600 uppercase tracking-widest mb-1">Ambiente de Homologação</label>
                                <input type="url" name="staging_link" id="staging_link" placeholder="https://staging.site.com" class="w-full bg-black border-white/10 rounded-xl text-xs text-white focus:border-atlvs-cyan focus:ring-0" value="{{ old("staging_link") }}">
                                @error("staging_link")
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-6">
                        <a href="{{ route('projects.show', $project) }}" class="text-[10px] font-black text-gray-600 uppercase tracking-widest hover:text-white transition-colors">Cancelar</a>
                        <button type="submit" class="btn-cyan py-3 px-10 rounded-full text-[10px] font-black uppercase tracking-widest shadow-xl">
                            Criar Tarefa
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
