<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Atlvs TaskFlow') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Instrument Sans', sans-serif;
                background-color: #000000;
                background-image: radial-gradient(circle at 50% 50%, #083344 0%, #000000 100%);
                background-attachment: fixed;
            }
            .glass-card {
                background: rgba(15, 23, 42, 0.6);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.1);
                box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.8);
            }
            .text-cyan-atlvs { color: #06b6d4; }
            .bg-cyan-atlvs { background-color: #06b6d4; }
            .border-cyan-atlvs { border-color: #06b6d4; }
        </style>
    </head>
    <body class="antialiased text-gray-200">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="mb-8">
                <a href="/" class="flex flex-col items-center">
                    <span class="text-3xl font-bold tracking-tighter text-white">
                        ATLVS <span class="text-cyan-atlvs">TASKFLOW</span>
                    </span>
                    <div class="h-1 w-12 bg-cyan-atlvs mt-1 rounded-full"></div>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-8 py-10 glass-card overflow-hidden sm:rounded-2xl">
                {{ $slot }}
            </div>
            
            <div class="mt-8 text-gray-500 text-sm">
                &copy; {{ date('Y') }} Atlvs. Todos os direitos reservados.
            </div>
        </div>
    </body>
</html>
