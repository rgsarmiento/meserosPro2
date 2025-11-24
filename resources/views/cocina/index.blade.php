<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cocina - MeserosPro2</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white min-h-screen">
    <!-- Header -->
    <header class="bg-gradient-to-r from-orange-600 via-red-600 to-pink-600 shadow-2xl sticky top-0 z-50">
        <div class="px-6 py-4 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                </svg>
                <div>
                    <h1 class="text-2xl font-black">🔥 COCINA</h1>
                    <p class="text-xs text-orange-100">Actualización automática cada 10 seg</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <div class="text-right">
                    <p class="text-sm text-orange-100">Órdenes Activas</p>
                    <p id="total-ordenes" class="text-3xl font-black">{{ $ordenes->count() }}</p>
                </div>
                <button onclick="location.reload()" class="bg-white/20 hover:bg-white/30 px-4 py-2 rounded-xl font-medium transition">
                    🔄 Actualizar
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="p-6">
        <div id="ordenes-container" class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6 max-w-[1920px] mx-auto">
            @forelse($ordenes as $orden)
            <div class="orden-card bg-gradient-to-br from-gray-800 to-gray-900 rounded-3xl p-6 border-2 
                        {{ $orden->detalles->contains('Estado', 'En Preparación') ? 'border-yellow-500' : 'border-orange-500/50' }} 
                        shadow-2xl" data-orden-id="{{ $orden->Id }}">
                <!-- Order Header -->
                <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-700">
                    <div class="flex items-center space-x-4">
                        <div class="min-w-[4rem] h-16 px-3 bg-gradient-to-br from-orange-500 to-red-600 rounded-2xl flex items-center justify-center shadow-lg">
                            <span class="text-2xl sm:text-3xl font-black whitespace-nowrap">#{{ $orden->Id }}</span>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-white">{{ $orden->mesa->Nombre }}</h3>
                            <div class="flex items-center space-x-3 text-sm text-gray-400 mt-1">
                                <span>👤 {{ $orden->usuario->Nombre }}</span>
                                <span>•</span>
                                <span>🕐 {{ $orden->FechaHora->format('H:i') }}</span>
                                <span>•</span>
                                <span class="text-orange-400 font-bold">{{ $orden->FechaHora->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-400">Productos</p>
                        <p class="text-3xl font-black text-orange-400">{{ $orden->detalles->count() }}</p>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="grid grid-cols-1 gap-4">
                    @foreach($orden->detalles as $detalle)
                    <div class="producto-item bg-gray-900/50 rounded-2xl p-5 border-2 border-gray-700 transition"
                         data-detalle-id="{{ $detalle->Id }}"
                         data-estado="{{ $detalle->Estado }}">
                        <!-- Quantity Badge -->
                        <div class="flex items-start space-x-3 mb-3">
                            <span class="flex-shrink-0 inline-flex items-center justify-center w-12 h-12 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl text-white font-black text-xl shadow-lg">
                                {{ $detalle->Cantidad }}
                            </span>
                            <div class="flex-1">
                                <h4 class="font-bold text-white text-lg leading-tight">{{ $detalle->NombreProducto }}</h4>
                                @if($detalle->Observacion)
                                <div class="mt-2 bg-yellow-500/20 border-2 border-yellow-500/50 rounded-lg p-3">
                                    <div class="flex items-start space-x-2">
                                        <svg class="w-5 h-5 text-yellow-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                        </svg>
                                        <p class="text-yellow-300 font-bold text-sm leading-relaxed">{{ $detalle->Observacion }}</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Status Buttons - Solo el activo con color -->
                        <div class="grid grid-cols-3 gap-2">
                            <button onclick="cambiarEstado({{ $detalle->Id }}, 'Pendiente')" 
                                    class="btn-estado py-3 px-3 rounded-lg text-xs font-bold transition
                                           {{ $detalle->Estado === 'Pendiente' ? 'bg-red-600 text-white shadow-lg' : 'bg-gray-700 text-gray-400 hover:bg-gray-600' }}">
                                ⏸️ Pendiente
                            </button>
                            <button onclick="cambiarEstado({{ $detalle->Id }}, 'En Preparación')" 
                                    class="btn-estado py-3 px-3 rounded-lg text-xs font-bold transition
                                           {{ $detalle->Estado === 'En Preparación' ? 'bg-yellow-600 text-white shadow-lg' : 'bg-gray-700 text-gray-400 hover:bg-gray-600' }}">
                                🔥 Preparando
                            </button>
                            <button onclick="cambiarEstado({{ $detalle->Id }}, 'Listo')" 
                                    class="btn-estado py-3 px-3 rounded-lg text-xs font-bold transition
                                           {{ $detalle->Estado === 'Listo' ? 'bg-green-600 text-white shadow-lg' : 'bg-gray-700 text-gray-400 hover:bg-gray-600' }}">
                                ✓ Listo
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @empty
            <div class="text-center py-20">
                <div class="inline-flex items-center justify-center w-32 h-32 bg-gray-800 rounded-full mb-6">
                    <svg class="w-16 h-16 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-3xl font-bold text-gray-400 mb-2">¡Todo al día!</h3>
                <p class="text-gray-500">No hay órdenes pendientes en este momento</p>
            </div>
            @endforelse
        </div>
    </div>

    <script>
        function cambiarEstado(detalleId, nuevoEstado) {
            const productoItem = document.querySelector(`[data-detalle-id="${detalleId}"]`);
            
            fetch(`/cocina/detalle/${detalleId}/estado`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ estado: nuevoEstado })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Actualizar botones visualmente de inmediato
                    const botones = productoItem.querySelectorAll('.btn-estado');
                    botones.forEach(btn => {
                        // Remover clases de color
                        btn.classList.remove('bg-red-600', 'bg-yellow-600', 'bg-green-600', 'text-white', 'shadow-lg');
                        btn.classList.add('bg-gray-700', 'text-gray-400');
                    });
                    
                    // Aplicar color al botón activo
                    let btnTexto;
                    if (nuevoEstado === 'Pendiente') btnTexto = 'Pendiente';
                    else if (nuevoEstado === 'En Preparación') btnTexto = 'Preparando';
                    else if (nuevoEstado === 'Listo') btnTexto = 'Listo';
                    
                    const btnActivo = Array.from(botones).find(btn => btn.textContent.includes(btnTexto));
                    if (btnActivo) {
                        btnActivo.classList.remove('bg-gray-700', 'text-gray-400');
                        if (nuevoEstado === 'Pendiente') {
                            btnActivo.classList.add('bg-red-600', 'text-white', 'shadow-lg');
                        } else if (nuevoEstado === 'En Preparación') {
                            btnActivo.classList.add('bg-yellow-600', 'text-white', 'shadow-lg');
                        } else if (nuevoEstado === 'Listo') {
                            btnActivo.classList.add('bg-green-600', 'text-white', 'shadow-lg');
                        }
                    }
                    
                    // Actualizar data-estado
                    productoItem.setAttribute('data-estado', nuevoEstado);
                    
                    actualizarContador();
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function actualizarContador() {
            const totalOrdenes = document.querySelectorAll('.orden-card').length;
            document.getElementById('total-ordenes').textContent = totalOrdenes;
        }

        // Auto-refresh cada 10 segundos
        setInterval(() => {
            location.reload();
        }, 10000);

        // Alerta sonora para nuevas órdenes
        document.addEventListener('DOMContentLoaded', () => {
            const currentOrders = {{ $ordenes->count() }};
            const lastOrders = parseInt(sessionStorage.getItem('lastOrders') || '0');
            
            // Si hay más órdenes que antes, reproducir sonido
            if (currentOrders > lastOrders) {
                playNotificationSound();
            }
            
            // Guardar estado actual
            sessionStorage.setItem('lastOrders', currentOrders);
        });

        function playNotificationSound() {
            // Crear contexto de audio
            const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
            const now = audioCtx.currentTime;

            // Crear oscilador principal (tipo sirena)
            const osc = audioCtx.createOscillator();
            const gain = audioCtx.createGain();

            osc.connect(gain);
            gain.connect(audioCtx.destination);

            // Configuración "escandalosa" (tipo alarma nuclear/sirena)
            osc.type = 'sawtooth'; // Onda diente de sierra es más estridente
            
            // Secuencia de tonos repetitivos (3 veces)
            for (let i = 0; i < 3; i++) {
                const startTime = now + (i * 0.5);
                
                // Tono alto
                osc.frequency.setValueAtTime(880, startTime); // La5
                osc.frequency.linearRampToValueAtTime(1760, startTime + 0.1); // Subida rápida a La6
                
                // Volumen fuerte
                gain.gain.setValueAtTime(0.8, startTime);
                gain.gain.linearRampToValueAtTime(0.8, startTime + 0.4);
                gain.gain.linearRampToValueAtTime(0.001, startTime + 0.5);
            }

            osc.start(now);
            osc.stop(now + 1.5); // Duración total 1.5 segundos
        }
    </script>
</body>
</html>
