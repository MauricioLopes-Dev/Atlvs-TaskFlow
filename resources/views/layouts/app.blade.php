<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Atlvs TaskFlow</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            :root {
                --atlvs-cyan: #06b6d4;
                --atlvs-cyan-glow: rgba(6, 182, 212, 0.5);
            }
            body {
                background-color: #000000;
                color: #ffffff;
                background-image: 
                    radial-gradient(circle at 20% 20%, rgba(6, 182, 212, 0.05) 0%, transparent 40%),
                    radial-gradient(circle at 80% 80%, rgba(6, 182, 212, 0.05) 0%, transparent 40%);
                background-attachment: fixed;
            }
            .glass-card {
                background: rgba(255, 255, 255, 0.02);
                backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.05);
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            }
            .glass-card:hover {
                background: rgba(255, 255, 255, 0.04);
                border-color: rgba(6, 182, 212, 0.3);
                transform: translateY(-4px);
                box-shadow: 0 20px 40px -20px rgba(0, 0, 0, 0.5);
            }
            .btn-cyan {
                background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
                color: #000000;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                position: relative;
                overflow: hidden;
            }
            .btn-cyan::after {
                content: '';
                position: absolute;
                top: 0; left: -100%;
                width: 100%; height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
                transition: 0.5s;
            }
            .btn-cyan:hover::after {
                left: 100%;
            }
            .btn-cyan:hover {
                transform: translateY(-2px);
                box-shadow: 0 0 20px var(--atlvs-cyan-glow);
                filter: brightness(1.1);
            }
            .text-glow {
                text-shadow: 0 0 10px var(--atlvs-cyan-glow);
            }
            .nav-link-active {
                color: var(--atlvs-cyan) !important;
                text-shadow: 0 0 8px var(--atlvs-cyan-glow);
            }
            
            /* Custom Scrollbar */
            ::-webkit-scrollbar { width: 8px; }
            ::-webkit-scrollbar-track { background: #000; }
            ::-webkit-scrollbar-thumb { 
                background: #222; 
                border-radius: 10px;
            }
            ::-webkit-scrollbar-thumb:hover { background: #333; }

            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .animate-fade-in {
                animation: fadeIn 0.6s ease-out forwards;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-black">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-black/50 backdrop-blur border-b border-white/10 sticky top-16 z-40">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
            
            <footer class="py-12 text-center text-sm text-gray-500 border-t border-white/5 mt-12">
                <div class="mb-4 font-bold text-lg">
                    <span class="text-atlvs-cyan">ATL</span>VS
                </div>
                &copy; {{ date('Y') }} Atlvs - Todos os direitos reservados.
            </footer>
        </div>
    </body>
</html>
