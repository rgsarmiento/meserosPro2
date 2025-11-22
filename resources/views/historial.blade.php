@extends('layouts.app')

@section('title', 'Historial de Pedidos')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-3xl font-bold bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent mb-2">
                        📋 Historial de Pedidos
                    </h2>
                    <p class="text-gray-400">Últimas 100 órdenes de todos los meseros</p>
                </div>
                <a href="{{ route('mesas') }}" class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg transition-all transform hover:scale-105">
                    ← Volver a Mesas
                </a>
            </div>
            
            <!-- Filter -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl p-6 border border-gray-700">
                <form method="GET" action="{{ route('historial') }}" class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                    <label class="text-gray-300 font-medium whitespace-nowrap">Filtrar por mesa:</label>
                    <select name="mesa_id" onchange="this.form.submit()" 
                            class="flex-1 w-full sm:max-w-xs bg-gray-700 text-white border-2 border-gray-600 rounded-xl px-4 py-3 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/50 transition">
                        <option value="">📋 Todas las mesas</option>
                        @foreach($mesasConOrdenes as $mesa)
                        <option value="{{ $mesa->Id }}" {{ $mesaSeleccionada == $mesa->Id ? 'selected' : '' }}>
                            {{ $mesa->Nombre }}
                        </option>
                        @endforeach
                    </select>
                    @if($mesaSeleccionada)
                    <a href="{{ route('historial') }}" class="bg-red-500/20 hover:bg-red-500/30 text-red-300 px-4 py-3 rounded-xl font-medium transition flex items-center space-x-2 border border-red-500/30 whitespace-nowrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <span>Limpiar</span>
                    </a>
                    @endif
                </form>
            </div>
        </div>

        <!-- Orders List Grouped by Table -->
        @if($ordenes->count() > 0)
        <div class="space-y-8">
            @foreach($ordenes as $mesaId => $ordenesGrupo)
            <div class="bg-gradient-to-br from-gray-800/50 to-gray-900/50 rounded-3xl p-6 border-2 border-indigo-500/30">
                <!-- Mesa Header -->
                <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-700">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-white">{{ $ordenesGrupo->first()->mesa->Nombre }}</h3>
                            <p class="text-sm text-gray-400">{{ $ordenesGrupo->count() }} {{ $ordenesGrupo->count() === 1 ? 'orden' : 'órdenes' }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-400">Total acumulado</p>
                        <p class="text-2xl font-black bg-gradient-to-r from-orange-400 to-red-400 bg-clip-text text-transparent">
                            ${{ number_format($ordenesGrupo->sum('Total'), 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                <!-- Orders for this table -->
                <div class="space-y-4">
                    @foreach($ordenesGrupo as $orden)
                    <div class="bg-gray-800/50 rounded-2xl p-5 border border-gray-700 hover:border-indigo-500/50 transition">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-2">
                                    <h4 class="text-lg font-bold text-white">Orden #{{ $orden->Id }}</h4>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold
                                                 {{ $orden->Estado === 'Pendiente' ? 'bg-yellow-500/20 text-yellow-300 border border-yellow-500/30' : 
                                                    ($orden->Estado === 'Completada' ? 'bg-green-500/20 text-green-300 border border-green-500/30' : 
                                                    'bg-gray-500/20 text-gray-300 border border-gray-500/30') }}">
                                        {{ $orden->Estado }}
                                    </span>
                                </div>
                                <div class="flex items-center space-x-4 text-sm text-gray-400">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $orden->FechaHora->format('d/m/Y H:i') }}
                                    </span>
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        {{ $orden->usuario->Nombre }}
                                    </span>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-400 mb-1">Total</p>
                                <p class="text-2xl font-black text-indigo-300">
                                    ${{ number_format($orden->Total, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        <!-- Order Details -->
                        <div class="border-t border-gray-700 pt-4">
                            <p class="text-sm font-medium text-gray-400 mb-3">Productos:</p>
                            <div class="space-y-2">
                                @foreach($orden->detalles as $detalle)
                                <div class="flex items-start justify-between bg-gray-900/50 rounded-lg p-3 gap-2">
                                    <div class="flex items-start space-x-3 flex-1 min-w-0">
                                        <div class="flex-shrink-0">
                                            <span class="inline-flex items-center justify-center w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl text-white font-black text-lg shadow-lg">
                                                {{ $detalle->Cantidad }}
                                            </span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center space-x-2 mb-1 flex-wrap">
                                                <p class="font-medium text-white truncate">{{ $detalle->NombreProducto }}</p>
                                                @if($detalle->Estado)
                                                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-bold flex-shrink-0
                                                             {{ $detalle->Estado === 'Pendiente' ? 'bg-red-500/20 text-red-300 border border-red-500/30' : 
                                                                ($detalle->Estado === 'En Preparación' ? 'bg-yellow-500/20 text-yellow-300 border border-yellow-500/30' : 
                                                                'bg-green-500/20 text-green-300 border border-green-500/30') }}">
                                                    {{ $detalle->Estado === 'Pendiente' ? '⏸️' : ($detalle->Estado === 'En Preparación' ? '🔥' : '✅') }}
                                                    {{ $detalle->Estado }}
                                                </span>
                                                @endif
                                            </div>
                                            @if($detalle->Observacion)
                                            <p class="text-sm text-yellow-400 mt-1">💬 {{ $detalle->Observacion }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-right flex-shrink-0">
                                        <p class="font-bold text-indigo-300 text-base sm:text-lg whitespace-nowrap">${{ number_format($detalle->Precio, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-20">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-gray-800 rounded-full mb-6">
                <svg class="w-12 h-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-400 mb-2">No hay pedidos registrados</h3>
            <p class="text-gray-500">Los pedidos que realices aparecerán aquí</p>
        </div>
        @endif
    </div>
</div>
@endsection
