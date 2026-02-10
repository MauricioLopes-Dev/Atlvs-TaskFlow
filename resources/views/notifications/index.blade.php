<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-white tracking-tight">Notificações</h1>
                @if(Auth::user()->unreadNotifications->count() > 0)
                    <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-xs font-black text-atlvs-cyan uppercase hover:text-white transition-colors">Marcar todas como lidas</button>
                    </form>
                @endif
            </div>

            <div class="space-y-4">
                @forelse($notifications as $notification)
                    <div class="glass-card p-6 rounded-2xl border border-white/10 {{ $notification->read_at ? 'opacity-60' : 'border-l-4 border-l-atlvs-cyan' }}">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="text-white font-medium">{{ $notification->data['message'] }}</p>
                                <span class="text-xs text-gray-500 mt-2 block">{{ $notification->created_at->diffForHumans() }}</span>
                            </div>
                            @if(!$notification->read_at)
                                <a href="{{ route('notifications.read', $notification->id) }}" class="text-[10px] font-black text-atlvs-cyan uppercase hover:text-white transition-colors">Ver</a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="glass-card p-12 rounded-2xl border border-white/10 text-center">
                        <p class="text-gray-500">Você não tem notificações no momento.</p>
                    </div>
                @endforelse

                <div class="mt-6">
                    {{ $notifications->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
