<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MeserosPro2')</title>
    
    <!-- PWA Meta Tags -->
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Prevent pull-to-refresh */
        body {
            overscroll-behavior-y: contain;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #1f2937;
        }
        ::-webkit-scrollbar-thumb {
            background: #4b5563;
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #6b7280;
        }
    </style>
</head>
<body class="bg-gray-900 text-white min-h-screen">
    <!-- Header -->
    @if(Session::has('mesero_nombre'))
    <header class="bg-gradient-to-r from-indigo-600 to-purple-600 shadow-lg sticky top-0 z-50">
        <div class="px-4 py-3 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <div>
                    <h1 class="text-lg font-bold">MeserosPro2</h1>
                    <p class="text-xs text-indigo-200">{{ Session::get('mesero_nombre') }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <a href="{{ route('cocina.index') }}" target="_blank" class="bg-orange-500/20 hover:bg-orange-500/30 border border-orange-400/30 px-4 py-2 rounded-lg text-sm font-medium transition flex items-center space-x-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                    </svg>
                    <span>Cocina</span>
                </a>
                <a href="{{ route('historial') }}" class="bg-white/20 hover:bg-white/30 px-4 py-2 rounded-lg text-sm font-medium transition flex items-center space-x-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Historial</span>
                </a>
                <a href="{{ route('logout') }}" class="bg-white/20 hover:bg-white/30 px-4 py-2 rounded-lg text-sm font-medium transition">
                    Salir
                </a>
            </div>
        </div>
    </header>
    @endif

    <!-- Main Content -->
    <main class="pb-20">
        @yield('content')
    </main>

    @yield('scripts')
</body>
</html>
