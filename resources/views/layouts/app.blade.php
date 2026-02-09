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
            body {
                background-color: #000000;
                color: #ffffff;
            }
            .glass-card {
                background: rgba(255, 255, 255, 0.03);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.1);
            }
            .btn-cyan {
                background-color: #06b6d4;
                color: #000000;
                transition: all 0.3s ease;
            }
            .btn-cyan:hover {
                background-color: #22d3ee;
                transform: translateY(-1px);
                box-shadow: 0 0 15px rgba(6, 182, 212, 0.4);
            }
            .text-gradient {
                background: linear-gradient(to right, #06b6d4, #ffffff);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
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
