@extends('layouts.app')

@section('title', 'Mesas - MeserosPro2')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 p-6">
    <div class="max-w-7xl mx-auto">
        <div class="mb-8">
            <h2 class="text-3xl font-bold bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent mb-2">
                Selecciona una Mesa
            </h2>
            <p class="text-gray-400">Toca una mesa para comenzar a tomar el pedido</p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($mesas as $mesa)
            <a href="{{ route('menu', $mesa->Id) }}" 
               class="group relative bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl p-8 text-center transition-all transform hover:scale-105 hover:shadow-2xl active:scale-95 border-2
                      {{ $mesa->Estado === 'Ocupada' ? 'border-red-500/50 hover:border-red-400' : 'border-green-500/50 hover:border-green-400' }}">
                
                <!-- Icon -->
                <div class="w-20 h-20 mx-auto mb-4 rounded-2xl flex items-center justify-center transition-all group-hover:scale-110
                            {{ $mesa->Estado === 'Ocupada' ? 'bg-gradient-to-br from-red-500/20 to-red-600/20' : 'bg-gradient-to-br from-green-500/20 to-emerald-600/20' }}">
                    <svg class="w-12 h-12 {{ $mesa->Estado === 'Ocupada' ? 'text-red-400' : 'text-green-400' }}" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                </div>
                
                <!-- Mesa Name -->
                <h3 class="font-bold text-xl mb-3 text-white">{{ $mesa->Nombre }}</h3>
                
                <!-- Status Badge -->
                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold
                             {{ $mesa->Estado === 'Ocupada' ? 'bg-red-500/20 text-red-300 border border-red-500/30' : 'bg-green-500/20 text-green-300 border border-green-500/30' }}">
                    <span class="w-2 h-2 rounded-full mr-2 {{ $mesa->Estado === 'Ocupada' ? 'bg-red-400' : 'bg-green-400' }}"></span>
                    {{ $mesa->Estado }}
                </span>
                
                <!-- Tiempo Ocupada -->
                @if($mesa->Estado === 'Ocupada' && $mesa->FechaHora)
                    @php
                        $tiempoOcupada = $mesa->FechaHora->diffForHumans(null, true);
                    @endphp
                    <div class="mt-3 text-xs text-red-300 flex items-center justify-center space-x-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ $tiempoOcupada }}</span>
                    </div>
                @endif
            </a>
            @endforeach
        </div>
    </div>
</div>
@endsection
