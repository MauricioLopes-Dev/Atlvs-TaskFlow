<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white leading-tight tracking-tight">
            {{ __("Gestão de Equipe") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session("success"))
                <div class="bg-atlvs-cyan/10 border border-atlvs-cyan/20 text-atlvs-cyan px-6 py-4 rounded-2xl relative mb-8 flex items-center backdrop-blur-sm" role="alert">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <span class="block sm:inline font-bold text-sm uppercase tracking-tight">{{ session("success") }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Form de Convite -->
                <div class="lg:col-span-1">
                    <div class="glass-card rounded-3xl p-8">
                        <h3 class="text-lg font-bold text-white mb-6 tracking-tight">Convidar Membro</h3>
                        <form action="{{ route('invitations.store') }}" method="POST">
                            @csrf
                            <div class="mb-6">
                                <label for="email" class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2">E-mail do Colaborador</label>
                                <input type="email" name="email" id="email" class="w-full bg-black text-sm text-white rounded-2xl border-white/10 shadow-sm focus:border-atlvs-cyan focus:ring-0 transition-all placeholder-gray-700 font-medium" placeholder="exemplo@atlvs.com" required>
                                @error('email')
                                    <p class="text-red-500 text-[10px] mt-1 font-bold uppercase tracking-tighter">{{ $message }}</p>
                                @enderror
                            </div>
                            <button type="submit" class="w-full btn-cyan font-black py-3 px-8 rounded-2xl shadow-lg text-[10px] uppercase tracking-widest">
                                Gerar Link de Acesso
                            </button>
                        </form>
                        <p class="mt-6 text-[10px] text-gray-500 font-medium leading-relaxed">
                            O link gerado permitirá que o novo membro se registre no sistema. O convite expira em 7 dias.
                        </p>
                    </div>
                </div>

                <!-- Lista de Convites -->
                <div class="lg:col-span-2">
                    <div class="glass-card rounded-3xl p-8">
                        <h3 class="text-lg font-bold text-white mb-8 tracking-tight">Convites Pendentes</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="border-b border-white/5">
                                        <th class="pb-4 text-left text-[10px] font-black text-gray-500 uppercase tracking-widest">E-mail</th>
                                        <th class="pb-4 text-left text-[10px] font-black text-gray-500 uppercase tracking-widest">Link de Registro</th>
                                        <th class="pb-4 text-right text-[10px] font-black text-gray-500 uppercase tracking-widest">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-white/5">
                                    @forelse($invitations as $invitation)
                                        <tr>
                                            <td class="py-5 text-sm text-white font-bold">{{ $invitation->email }}</td>
                                            <td class="py-5">
                                                <div class="flex items-center">
                                                    <input type="text" readonly value="{{ route('register', ['token' => $invitation->token]) }}" class="bg-white/5 border-none text-[10px] text-gray-400 rounded-lg py-1 px-3 w-48 focus:ring-0 font-mono">
                                                    <button onclick="navigator.clipboard.writeText('{{ route('register', ['token' => $invitation->token]) }}'); alert('Link copiado!')" class="ml-2 text-atlvs-cyan hover:text-white transition-colors">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m-3 8h3m-3-8h3m-3-8h3"></path></svg>
                                                    </button>
                                                </div>
                                            </td>
                                            <td class="py-5 text-right">
                                                <form action="{{ route('invitations.destroy', $invitation) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-gray-600 hover:text-red-500 transition-all" onclick="return confirm('Cancelar este convite?')">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="py-10 text-center text-gray-600 text-xs font-bold uppercase tracking-widest">Nenhum convite pendente</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
