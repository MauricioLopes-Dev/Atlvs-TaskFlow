<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-white leading-tight tracking-tight">Gestão de Contas</h2>
            <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest bg-white/5 px-4 py-2 rounded-full border border-white/5">
                {{ $users->count() }} Contas
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-atlvs-cyan/10 border border-atlvs-cyan/20 text-atlvs-cyan px-6 py-4 rounded-2xl mb-8 font-bold text-sm uppercase tracking-tight">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-500/10 border border-red-500/20 text-red-400 px-6 py-4 rounded-2xl mb-8 font-bold text-sm uppercase tracking-tight">
                    {{ session('error') }}
                </div>
            @endif

            <div class="glass-card rounded-3xl p-8">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-white/10 text-left text-[10px] font-black uppercase tracking-widest text-gray-500">
                                <th class="py-4 pr-4">Nome</th>
                                <th class="py-4 pr-4">Email</th>
                                <th class="py-4 pr-4">Tarefas</th>
                                <th class="py-4 pr-4">Projetos</th>
                                <th class="py-4">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @foreach($users as $user)
                                <tr>
                                    <td class="py-4 pr-4 font-bold text-white">{{ $user->name }}</td>
                                    <td class="py-4 pr-4 text-gray-400">{{ $user->email }}</td>
                                    <td class="py-4 pr-4 text-gray-400">{{ $user->tasks_count }}</td>
                                    <td class="py-4 pr-4 text-gray-400">{{ $user->projects_count }}</td>
                                    <td class="py-4">
                                        @if(auth()->id() !== $user->id)
                                            <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('Tem certeza que deseja excluir esta conta?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500/10 border border-red-500/20 text-red-400 hover:bg-red-500/20 font-black py-2 px-4 rounded-xl text-[10px] uppercase tracking-widest transition-all">
                                                    Excluir
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-[10px] font-black uppercase tracking-widest text-gray-600">Conta atual</span>
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
</x-app-layout>
