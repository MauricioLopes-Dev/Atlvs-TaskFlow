<nav x-data="{ open: false }" class="bg-black/80 backdrop-blur-md border-b border-white/10 sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="font-bold text-xl tracking-wider text-white">
                        <span class="text-atlvs-cyan">ATL</span>VS <span class="text-xs font-light text-gray-500 ml-1">TASKFLOW</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-gray-400 hover:text-white border-atlvs-cyan transition-colors">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('projects.index')" :active="request()->routeIs('projects.*')" class="text-gray-400 hover:text-white border-atlvs-cyan transition-colors">
                        {{ __('Projetos') }}
                    </x-nav-link>
                    <x-nav-link :href="route('kanban.index')" :active="request()->routeIs('kanban.*')" class="text-gray-400 hover:text-white border-atlvs-cyan transition-colors">
                        {{ __('Kanban') }}
                    </x-nav-link>
                    <x-nav-link :href="route('calendar.index')" :active="request()->routeIs('calendar.*')" class="text-gray-400 hover:text-white border-atlvs-cyan transition-colors">
                        {{ __('Calendário') }}
                    </x-nav-link>
                    <x-nav-link :href="route('invitations.index')" :active="request()->routeIs('invitations.*')" class="text-gray-400 hover:text-white border-atlvs-cyan transition-colors">
                        {{ __('Equipe') }}
                    </x-nav-link>
                                        @if(Auth::user()->email === config('app.admin_email', 'admin@empresa.com'))
                        <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')" class="text-gray-400 hover:text-white border-atlvs-cyan transition-colors">
                            {{ __('Contas') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-4">
                <!-- Notificações (Sino) -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="relative p-2 text-gray-400 hover:text-atlvs-cyan transition-colors focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        @if(Auth::user()->unreadNotifications->count() > 0)
                            <span class="absolute top-1.5 right-1.5 flex h-4 w-4">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-atlvs-cyan opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-4 w-4 bg-atlvs-cyan text-[10px] font-bold text-black items-center justify-center">
                                    {{ Auth::user()->unreadNotifications->count() }}
                                </span>
                            </span>
                        @endif
                    </button>

                    <!-- Dropdown de Notificações -->
                    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="absolute right-0 mt-2 w-80 bg-black border border-white/10 rounded-2xl shadow-2xl z-50 overflow-hidden" style="display: none;">
                        <div class="p-4 border-b border-white/5 flex justify-between items-center">
                            <h3 class="text-sm font-bold text-white">Notificações</h3>
                            @if(Auth::user()->unreadNotifications->count() > 0)
                                <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-[10px] font-black text-atlvs-cyan uppercase hover:text-white transition-colors">Limpar Tudo</button>
                                </form>
                            @endif
                        </div>
                        <div class="max-h-96 overflow-y-auto">
                            @forelse(Auth::user()->unreadNotifications->take(5) as $notification)
                                <a href="{{ route('notifications.read', $notification->id) }}" class="block p-4 hover:bg-white/5 border-b border-white/5 transition-colors">
                                    <p class="text-xs text-gray-300">{{ $notification->data['message'] }}</p>
                                    <span class="text-[10px] text-gray-500 mt-1 block">{{ $notification->created_at->diffForHumans() }}</span>
                                </a>
                            @empty
                                <div class="p-8 text-center">
                                    <p class="text-xs text-gray-500">Nenhuma notificação nova.</p>
                                </div>
                            @endforelse
                        </div>
                        <a href="{{ route('notifications.index') }}" class="block p-3 text-center text-[10px] font-black text-gray-400 uppercase hover:bg-white/5 transition-colors">Ver Todas</a>
                    </div>
                </div>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 border border-white/10 text-sm leading-4 font-medium rounded-full text-gray-300 bg-white/5 hover:text-white hover:bg-white/10 focus:outline-none transition ease-in-out duration-150">
                            <div class="w-2 h-2 rounded-full bg-atlvs-cyan mr-2 animate-pulse"></div>
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="bg-black border border-white/10 rounded-md shadow-xl">
                            <x-dropdown-link :href="route('profile.edit')" class="text-gray-300 hover:bg-white/5 hover:text-atlvs-cyan">
                                {{ __('Perfil') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();" class="text-gray-300 hover:bg-white/5 hover:text-red-400">
                                    {{ __('Sair') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-white/5 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-black border-b border-white/10">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-gray-400 hover:text-atlvs-cyan">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('projects.index')" :active="request()->routeIs('projects.*')" class="text-gray-400 hover:text-atlvs-cyan">
                {{ __('Projetos') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('kanban.index')" :active="request()->routeIs('kanban.*')" class="text-gray-400 hover:text-atlvs-cyan">
                {{ __('Kanban') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('calendar.index')" :active="request()->routeIs('calendar.*')" class="text-gray-400 hover:text-atlvs-cyan">
                {{ __('Calendário') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('invitations.index')" :active="request()->routeIs('invitations.*')" class="text-gray-400 hover:text-atlvs-cyan">
                {{ __('Equipe') }}
            </x-responsive-nav-link>
                  @if(Auth::user()->email === config('app.admin_email', 'admin@empresa.com'))
                <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')" class="text-gray-400 hover:text-atlvs-cyan">
                    {{ __('Contas') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-white/10">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-gray-400">
                    {{ __('Perfil') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();" class="text-gray-400 hover:text-red-400">
                        {{ __('Sair') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
