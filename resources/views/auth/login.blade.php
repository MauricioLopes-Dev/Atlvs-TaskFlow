<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-xl font-semibold text-white">Bem-vindo de volta</h2>
        <p class="text-gray-400 text-sm mt-1">Acesse sua conta para gerenciar tarefas</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block font-medium text-sm text-gray-300 mb-1">E-mail</label>
            <input id="email" class="block w-full bg-slate-900/50 border-slate-700 text-white rounded-xl focus:border-cyan-500 focus:ring-cyan-500 shadow-sm transition-all duration-200" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-6">
            <label for="password" class="block font-medium text-sm text-gray-300 mb-1">Senha</label>
            <input id="password" class="block w-full bg-slate-900/50 border-slate-700 text-white rounded-xl focus:border-cyan-500 focus:ring-cyan-500 shadow-sm transition-all duration-200"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-6">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded bg-slate-900 border-slate-700 text-cyan-500 shadow-sm focus:ring-cyan-500 focus:ring-offset-slate-900" name="remember">
                <span class="ms-2 text-sm text-gray-400 hover:text-gray-300 transition-colors">Lembrar de mim</span>
            </label>
        </div>

        <div class="mt-8">
            <button type="submit" class="w-full flex justify-center items-center px-4 py-3 bg-cyan-600 hover:bg-cyan-500 text-white font-bold rounded-xl transition-all duration-300 shadow-lg shadow-cyan-900/20 active:scale-[0.98]">
                Entrar no Sistema
            </button>
        </div>

        @if (Route::has('password.request'))
            <div class="mt-6 text-center">
                <a class="text-sm text-gray-500 hover:text-cyan-400 transition-colors" href="{{ route('password.request') }}">
                    Esqueceu sua senha?
                </a>
            </div>
        @endif
    </form>
</x-guest-layout>
