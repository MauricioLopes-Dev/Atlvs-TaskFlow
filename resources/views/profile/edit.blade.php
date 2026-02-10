<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-white leading-tight tracking-tight">
                {{ __('Meu Perfil') }}
            </h2>
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-atlvs-cyan to-blue-500 flex items-center justify-center text-white text-lg font-black shadow-lg">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <div>
                    <p class="text-white font-bold text-sm">{{ Auth::user()->name }}</p>
                    <p class="text-gray-400 text-xs">{{ Auth::user()->email }}</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Atualizar Informações de Perfil -->
            <div class="glass-card rounded-3xl p-8 border border-white/10">
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-white mb-2">{{ __('Informações do Perfil') }}</h3>
                    <p class="text-gray-400 text-sm">{{ __('Atualize as informações da sua conta e endereço de email.') }}</p>
                </div>

                <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                    @csrf
                </form>

                <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                    @csrf
                    @method('patch')

                    <!-- Campo Nome -->
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-300 mb-2 uppercase tracking-widest">{{ __('Nome') }}</label>
                        <input 
                            id="name" 
                            name="name" 
                            type="text" 
                            class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-600 focus:border-atlvs-cyan focus:ring-2 focus:ring-atlvs-cyan/20 focus:outline-none transition-all"
                            value="{{ old('name', Auth::user()->name) }}" 
                            required 
                            autofocus 
                            autocomplete="name" 
                        />
                        @error('name')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Campo Email -->
                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-300 mb-2 uppercase tracking-widest">{{ __('Email') }}</label>
                        <input 
                            id="email" 
                            name="email" 
                            type="email" 
                            class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-600 focus:border-atlvs-cyan focus:ring-2 focus:ring-atlvs-cyan/20 focus:outline-none transition-all"
                            value="{{ old('email', Auth::user()->email) }}" 
                            required 
                            autocomplete="username" 
                        />
                        @error('email')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror

                        @if (Auth::user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! Auth::user()->hasVerifiedEmail())
                            <div class="mt-4 p-4 bg-yellow-500/10 border border-yellow-500/20 rounded-xl">
                                <p class="text-sm text-yellow-400">
                                    {{ __('Seu endereço de email não foi verificado.') }}
                                    <button form="send-verification" class="underline font-bold hover:text-yellow-300 transition-colors">
                                        {{ __('Clique aqui para reenviar o email de verificação.') }}
                                    </button>
                                </p>

                                @if (session('status') === 'verification-link-sent')
                                    <p class="mt-2 font-bold text-sm text-green-400">
                                        {{ __('Um novo link de verificação foi enviado para seu email.') }}
                                    </p>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Botão Salvar -->
                    <div class="flex items-center gap-4 pt-4">
                        <button type="submit" class="px-6 py-3 bg-atlvs-cyan hover:bg-atlvs-cyan/80 text-black font-bold rounded-xl transition-all duration-300 shadow-lg shadow-atlvs-cyan/20 uppercase tracking-widest text-sm">
                            {{ __('Salvar Alterações') }}
                        </button>

                        @if (session('status') === 'profile-updated')
                            <p class="text-sm text-green-400 font-bold animate-pulse">✓ {{ __('Perfil atualizado com sucesso!') }}</p>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Atualizar Senha -->
            <div class="glass-card rounded-3xl p-8 border border-white/10">
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-white mb-2">{{ __('Atualizar Senha') }}</h3>
                    <p class="text-gray-400 text-sm">{{ __('Garanta que sua conta esteja usando uma senha longa e aleatória para manter-se segura.') }}</p>
                </div>

                <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                    @csrf
                    @method('put')

                    <!-- Senha Atual -->
                    <div>
                        <label for="update_password_current_password" class="block text-sm font-bold text-gray-300 mb-2 uppercase tracking-widest">{{ __('Senha Atual') }}</label>
                        <input 
                            id="update_password_current_password" 
                            name="current_password" 
                            type="password" 
                            class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-600 focus:border-atlvs-cyan focus:ring-2 focus:ring-atlvs-cyan/20 focus:outline-none transition-all"
                            autocomplete="current-password" 
                        />
                        @error('current_password', 'updatePassword')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nova Senha -->
                    <div>
                        <label for="update_password_password" class="block text-sm font-bold text-gray-300 mb-2 uppercase tracking-widest">{{ __('Nova Senha') }}</label>
                        <input 
                            id="update_password_password" 
                            name="password" 
                            type="password" 
                            class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-600 focus:border-atlvs-cyan focus:ring-2 focus:ring-atlvs-cyan/20 focus:outline-none transition-all"
                            autocomplete="new-password" 
                        />
                        @error('password', 'updatePassword')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirmar Senha -->
                    <div>
                        <label for="update_password_password_confirmation" class="block text-sm font-bold text-gray-300 mb-2 uppercase tracking-widest">{{ __('Confirmar Senha') }}</label>
                        <input 
                            id="update_password_password_confirmation" 
                            name="password_confirmation" 
                            type="password" 
                            class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-600 focus:border-atlvs-cyan focus:ring-2 focus:ring-atlvs-cyan/20 focus:outline-none transition-all"
                            autocomplete="new-password" 
                        />
                        @error('password_confirmation', 'updatePassword')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Botão Salvar -->
                    <div class="flex items-center gap-4 pt-4">
                        <button type="submit" class="px-6 py-3 bg-atlvs-cyan hover:bg-atlvs-cyan/80 text-black font-bold rounded-xl transition-all duration-300 shadow-lg shadow-atlvs-cyan/20 uppercase tracking-widest text-sm">
                            {{ __('Atualizar Senha') }}
                        </button>

                        @if (session('status') === 'password-updated')
                            <p class="text-sm text-green-400 font-bold animate-pulse">✓ {{ __('Senha atualizada com sucesso!') }}</p>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Excluir Conta -->
            <div class="glass-card rounded-3xl p-8 border border-red-500/30 bg-red-500/5">
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-red-400 mb-2">{{ __('Excluir Conta') }}</h3>
                    <p class="text-gray-400 text-sm">{{ __('Após a exclusão da sua conta, todos os seus recursos e dados serão permanentemente deletados. Antes de excluir sua conta, baixe qualquer dado ou informação que você deseje manter.') }}</p>
                </div>

                <button 
                    type="button"
                    @click="$dispatch('open-modal', 'confirm-user-deletion')"
                    class="px-6 py-3 bg-red-500/20 hover:bg-red-500/30 text-red-400 font-bold border border-red-500/30 rounded-xl transition-all duration-300 uppercase tracking-widest text-sm"
                >
                    {{ __('Excluir Minha Conta') }}
                </button>

                <!-- Modal de Confirmação -->
                <div x-data="{ open: false }" @open-modal.window="open = true" @close.window="open = false" style="display: none;" x-show="open" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" x-cloak>
                    <div class="glass-card rounded-3xl p-8 border border-white/10 max-w-md w-full mx-4">
                        <h2 class="text-xl font-bold text-white mb-4">{{ __('Tem certeza que deseja excluir sua conta?') }}</h2>
                        <p class="text-gray-400 text-sm mb-6">{{ __('Após a exclusão, todos os seus dados serão permanentemente deletados. Digite sua senha para confirmar.') }}</p>

                        <form method="post" action="{{ route('profile.destroy') }}" class="space-y-6">
                            @csrf
                            @method('delete')

                            <div>
                                <label for="password" class="block text-sm font-bold text-gray-300 mb-2 uppercase tracking-widest">{{ __('Senha') }}</label>
                                <input 
                                    id="password" 
                                    name="password" 
                                    type="password" 
                                    class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-600 focus:border-atlvs-cyan focus:ring-2 focus:ring-atlvs-cyan/20 focus:outline-none transition-all"
                                    placeholder="{{ __('Sua senha') }}"
                                    required
                                />
                                @error('password', 'userDeletion')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex gap-4 justify-end">
                                <button 
                                    type="button"
                                    @click="$dispatch('close')"
                                    class="px-6 py-3 bg-white/5 hover:bg-white/10 text-gray-300 font-bold border border-white/10 rounded-xl transition-all duration-300 uppercase tracking-widest text-sm"
                                >
                                    {{ __('Cancelar') }}
                                </button>
                                <button 
                                    type="submit"
                                    class="px-6 py-3 bg-red-500/20 hover:bg-red-500/30 text-red-400 font-bold border border-red-500/30 rounded-xl transition-all duration-300 uppercase tracking-widest text-sm"
                                >
                                    {{ __('Excluir Conta') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
