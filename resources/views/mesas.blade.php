@extends('layouts.app')

@section('title', 'Mesas - MeserosPro2')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 p-6">
    <div class="max-w-7xl mx-auto">
        <div class="mb-6">
            <h2 class="text-3xl font-bold bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent mb-2">
                Selecciona una Mesa
            </h2>
            <p class="text-gray-400">Toca una mesa para comenzar a tomar el pedido</p>
        </div>
        
        <!-- Filters -->
        <div class="mb-6 space-y-4">
            <!-- Search -->
            <div class="relative">
                <input 
                    type="text" 
                    id="search-mesa"
                    placeholder="🔍 Buscar mesa por nombre..."
                    class="w-full bg-gray-800 text-white border-2 border-gray-700 rounded-xl px-5 py-3 pl-12 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/50 transition"
                    oninput="filtrarMesas()"
                >
                <svg class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            
            <!-- Status Filters -->
            <div class="flex space-x-2 overflow-x-auto pb-2">
                <button onclick="filtrarPorEstado('todas')" 
                        class="filter-btn px-6 py-2 rounded-lg font-medium transition whitespace-nowrap bg-indigo-600 text-white"
                        data-estado="todas">
                    📋 Todas
                </button>
                <button onclick="filtrarPorEstado('Libre')" 
                        class="filter-btn px-6 py-2 rounded-lg font-medium transition whitespace-nowrap bg-gray-700 text-gray-300 hover:bg-gray-600"
                        data-estado="Libre">
                    🟢 Libres
                </button>
                <button onclick="filtrarPorEstado('Ocupada')" 
                        class="filter-btn px-6 py-2 rounded-lg font-medium transition whitespace-nowrap bg-gray-700 text-gray-300 hover:bg-gray-600"
                        data-estado="Ocupada">
                    🔴 Ocupadas
                </button>
            </div>
        </div>
        
        <div id="mesas-grid" class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 xl:grid-cols-8 gap-3">
            @foreach($mesas as $mesa)
            <a href="{{ route('menu', $mesa->Id) }}" 
               data-nombre="{{ strtolower($mesa->Nombre) }}"
               data-estado="{{ $mesa->Estado }}"
               data-mesa-id="{{ $mesa->Id }}"
               class="mesa-card group relative bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl p-4 text-center transition-all transform hover:scale-105 hover:shadow-2xl active:scale-95 border-2
                      {{ $mesa->Estado === 'Ocupada' ? 'border-red-500/50 hover:border-red-400' : 'border-green-500/50 hover:border-green-400' }}">
                
                <!-- Badge de Pedido Pendiente -->
                <div class="pending-badge hidden absolute -top-2 -right-2 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-full w-8 h-8 flex items-center justify-center shadow-lg border-2 border-gray-900 z-10">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                
                <!-- Icon -->
                <div class="w-12 h-12 mx-auto mb-2 rounded-lg flex items-center justify-center transition-all group-hover:scale-110
                            {{ $mesa->Estado === 'Ocupada' ? 'bg-gradient-to-br from-red-500/20 to-red-600/20' : 'bg-gradient-to-br from-green-500/20 to-emerald-600/20' }}">
                    <svg class="w-7 h-7 {{ $mesa->Estado === 'Ocupada' ? 'text-red-400' : 'text-green-400' }}" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                </div>
                
                <!-- Mesa Name -->
                <h3 class="font-bold text-sm mb-2 text-white truncate">{{ $mesa->Nombre }}</h3>
                
                <!-- Status Badge -->
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold
                             {{ $mesa->Estado === 'Ocupada' ? 'bg-red-500/20 text-red-300 border border-red-500/30' : 'bg-green-500/20 text-green-300 border border-green-500/30' }}">
                    <span class="w-1.5 h-1.5 rounded-full mr-1 {{ $mesa->Estado === 'Ocupada' ? 'bg-red-400' : 'bg-green-400' }}"></span>
                    {{ $mesa->Estado }}
                </span>
                
                <!-- Tiempo Ocupada -->
                @if($mesa->Estado === 'Ocupada' && $mesa->FechaHora)
                    @php
                        $tiempoOcupada = $mesa->FechaHora->diffForHumans(null, true);
                    @endphp
                    <div class="mt-2 text-xs text-red-300 flex items-center justify-center space-x-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ $tiempoOcupada }}</span>
                    </div>
                @endif
            </a>
            @endforeach
        </div>
        
        <!-- No results message -->
        <div id="no-mesas" class="hidden text-center py-20">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-gray-800 rounded-full mb-6">
                <svg class="w-12 h-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-400 mb-2">No se encontraron mesas</h3>
            <p class="text-gray-500">Intenta con otro filtro o búsqueda</p>
        </div>
    </div>
</div>

<script>
let estadoActual = 'todas';

function filtrarPorEstado(estado) {
    estadoActual = estado;
    
    // Limpiar campo de búsqueda
    document.getElementById('search-mesa').value = '';
    
    // Update button styles
    document.querySelectorAll('.filter-btn').forEach(btn => {
        if (btn.dataset.estado === estado) {
            btn.classList.remove('bg-gray-700', 'text-gray-300');
            btn.classList.add('bg-indigo-600', 'text-white');
        } else {
            btn.classList.remove('bg-indigo-600', 'text-white');
            btn.classList.add('bg-gray-700', 'text-gray-300');
        }
    });
    
    filtrarMesas();
}

function filtrarMesas() {
    const busqueda = document.getElementById('search-mesa').value.toLowerCase().trim();
    const mesas = document.querySelectorAll('.mesa-card');
    let visibles = 0;
    
    mesas.forEach(mesa => {
        const nombre = mesa.getAttribute('data-nombre');
        const estado = mesa.getAttribute('data-estado');
        
        const coincideEstado = estadoActual === 'todas' || estado === estadoActual;
        const coincideNombre = busqueda === '' || nombre.includes(busqueda);
        
        if (coincideEstado && coincideNombre) {
            mesa.style.display = 'block';
            visibles++;
        } else {
            mesa.style.display = 'none';
        }
    });
    
    // Show/hide no results message
    document.getElementById('no-mesas').classList.toggle('hidden', visibles > 0);
}

// Auto-refresh cada 10 segundos para actualizar estado de mesas
setInterval(() => {
    // Guardar estado actual de filtros y búsqueda
    const busquedaActual = document.getElementById('search-mesa').value;
    
    // Guardar en sessionStorage para mantener después del refresh
    sessionStorage.setItem('mesasEstadoFiltro', estadoActual);
    sessionStorage.setItem('mesasBusqueda', busquedaActual);
    
    // Recargar página
    window.location.reload();
}, 10000);

// Restaurar filtros después del refresh
window.addEventListener('DOMContentLoaded', () => {
    const estadoGuardado = sessionStorage.getItem('mesasEstadoFiltro');
    const busquedaGuardada = sessionStorage.getItem('mesasBusqueda');
    
    if (estadoGuardado && estadoGuardado !== 'todas') {
        filtrarPorEstado(estadoGuardado);
    }
    
    if (busquedaGuardada) {
        document.getElementById('search-mesa').value = busquedaGuardada;
        filtrarMesas();
    }
    
    // Verificar pedidos pendientes en localStorage
    verificarPedidosPendientes();
});

// Función para verificar si hay pedidos pendientes en localStorage
function verificarPedidosPendientes() {
    document.querySelectorAll('.mesa-card').forEach(card => {
        const mesaId = card.getAttribute('data-mesa-id');
        const carritoKey = `carrito_mesa_${mesaId}`;
        
        try {
            const carrito = localStorage.getItem(carritoKey);
            if (carrito) {
                const items = JSON.parse(carrito);
                if (items && items.length > 0) {
                    // Mostrar badge de pedido pendiente
                    const badge = card.querySelector('.pending-badge');
                    if (badge) {
                        badge.classList.remove('hidden');
                    }
                }
            }
        } catch (error) {
            console.error('Error al verificar pedido pendiente:', error);
        }
    });
}
</script>
@endsection
