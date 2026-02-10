<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-xl font-semibold text-white">Criar Nova Conta</h2>
        <p class="text-gray-400 text-sm mt-1">Junte-se à equipe Atlvs TaskFlow</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block font-medium text-sm text-gray-300 mb-1">Nome Completo</label>
            <input id="name" class="block w-full bg-slate-900/50 border-slate-700 text-white rounded-xl focus:border-cyan-500 focus:ring-cyan-500 shadow-sm transition-all duration-200" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <label for="email" class="block font-medium text-sm text-gray-300 mb-1">E-mail</label>
            <input id="email" class="block w-full bg-slate-900/50 border-slate-700 text-white rounded-xl focus:border-cyan-500 focus:ring-cyan-500 shadow-sm transition-all duration-200" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password" class="block font-medium text-sm text-gray-300 mb-1">Senha</label>
            <input id="password" class="block w-full bg-slate-900/50 border-slate-700 text-white rounded-xl focus:border-cyan-500 focus:ring-cyan-500 shadow-sm transition-all duration-200"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <label for="password_confirmation" class="block font-medium text-sm text-gray-300 mb-1">Confirmar Senha</label>
            <input id="password_confirmation" class="block w-full bg-slate-900/50 border-slate-700 text-white rounded-xl focus:border-cyan-500 focus:ring-cyan-500 shadow-sm transition-all duration-200"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-8">
            <button type="submit" class="w-full flex justify-center items-center px-4 py-3 bg-cyan-600 hover:bg-cyan-500 text-white font-bold rounded-xl transition-all duration-300 shadow-lg shadow-cyan-900/20 active:scale-[0.98]">
                Criar Conta
            </button>
        </div>

        <div class="mt-6 text-center">
            <a class="text-sm text-gray-500 hover:text-cyan-400 transition-colors" href="{{ route('login') }}">
                Já possui uma conta? Entre aqui
            </a>
        </div>
    </form>
</x-guest-layout>
