<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white leading-tight tracking-tight">
            {{ __('Editar Projeto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-card rounded-3xl p-10 border border-white/10">
                <form action="{{ route('projects.update', $project) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    @method('PATCH')

                    <!-- Nome do Projeto -->
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-300 mb-3 uppercase tracking-widest">{{ __('Nome do Projeto') }}</label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name" 
                            class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-600 focus:border-atlvs-cyan focus:ring-2 focus:ring-atlvs-cyan/20 focus:outline-none transition-all"
                            value="{{ old('name', $project->name) }}"
                            required
                        />
                        @error('name')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Descrição do Projeto -->
                    <div>
                        <label for="description" class="block text-sm font-bold text-gray-300 mb-3 uppercase tracking-widest">{{ __('Descrição do Projeto') }}</label>
                        <textarea 
                            name="description" 
                            id="description" 
                            rows="5" 
                            class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-600 focus:border-atlvs-cyan focus:ring-2 focus:ring-atlvs-cyan/20 focus:outline-none transition-all resize-none"
                        >{{ old('description', $project->description) }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Upload de Banner/Logo -->
                    <div>
                        <label for="image" class="block text-sm font-bold text-gray-300 mb-3 uppercase tracking-widest">{{ __('Banner ou Logo do Projeto (Opcional)') }}</label>
                        
                        <!-- Imagem Atual -->
                        @if($project->image_path)
                            <div class="mb-4">
                                <p class="text-sm text-gray-400 mb-2">Imagem atual:</p>
                                <img src="{{ asset('storage/' . $project->image_path) }}" alt="Banner atual" class="w-full h-48 object-cover rounded-xl border border-atlvs-cyan/30">
                            </div>
                        @endif

                        <div class="relative">
                            <input 
                                type="file" 
                                name="image" 
                                id="image" 
                                accept="image/*"
                                class="hidden"
                                onchange="previewImage(this)"
                            />
                            <label for="image" class="block w-full px-4 py-6 bg-white/5 border-2 border-dashed border-atlvs-cyan/30 rounded-xl cursor-pointer hover:bg-white/10 hover:border-atlvs-cyan/50 transition-all text-center">
                                <svg class="w-12 h-12 mx-auto text-atlvs-cyan/60 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                <p class="text-gray-400 font-medium">Clique para selecionar ou arraste uma imagem</p>
                                <p class="text-gray-600 text-xs mt-1">PNG, JPG, GIF (máx. 5MB)</p>
                            </label>
                            
                            <!-- Preview da Imagem -->
                            <div id="imagePreview" class="mt-4 hidden">
                                <img id="previewImg" src="" alt="Preview" class="w-full h-48 object-cover rounded-xl border border-atlvs-cyan/30">
                                <button type="button" onclick="clearImage()" class="mt-2 text-sm text-red-400 hover:text-red-300 font-bold">✕ Remover nova imagem</button>
                            </div>
                        </div>
                        @error('image')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Botões de Ação -->
                    <div class="flex items-center justify-between pt-6 border-t border-white/10">
                        <a href="{{ route('projects.show', $project) }}" class="px-6 py-3 bg-white/5 hover:bg-white/10 text-gray-300 font-bold border border-white/10 rounded-xl transition-all duration-300 uppercase tracking-widest text-sm">
                            {{ __('Cancelar') }}
                        </a>
                        <button 
                            type="submit" 
                            class="px-8 py-3 bg-atlvs-cyan hover:bg-atlvs-cyan/80 text-black font-bold rounded-xl transition-all duration-300 shadow-lg shadow-atlvs-cyan/20 uppercase tracking-widest text-sm"
                        >
                            {{ __('Salvar Alterações') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewImg').src = e.target.result;
                    document.getElementById('imagePreview').classList.remove('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function clearImage() {
            document.getElementById('image').value = '';
            document.getElementById('imagePreview').classList.add('hidden');
        }
    </script>
</x-app-layout>
