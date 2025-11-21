@extends('layouts.app')

@section('title', 'Menú - ' . $mesa->Nombre)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 pb-32">
    <!-- Mesa Info Header -->
    <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 p-6 shadow-2xl">
        <div class="max-w-7xl mx-auto">
            <a href="{{ route('mesas') }}" class="inline-flex items-center text-white/90 hover:text-white text-sm mb-3 transition">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Volver a mesas
            </a>
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-bold text-white mb-1">{{ $mesa->Nombre }}</h2>
                    <p class="text-indigo-100">Selecciona los productos para el pedido</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-indigo-200 mb-1">Estado</p>
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold border-2
                                 {{ $mesa->Estado === 'Ocupada' ? 'bg-red-500/20 text-red-200 border-red-400' : 'bg-green-500/20 text-green-200 border-green-400' }}">
                        <span class="w-2 h-2 rounded-full mr-2 {{ $mesa->Estado === 'Ocupada' ? 'bg-red-400' : 'bg-green-400' }}"></span>
                        {{ $mesa->Estado }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="sticky top-16 bg-gray-900/95 backdrop-blur-sm border-b border-gray-700 z-40 shadow-lg">
        <div class="max-w-7xl mx-auto p-4">
            <div class="relative">
                <input 
                    type="text" 
                    id="search-input"
                    placeholder="🔍 Buscar producto o categoría (mín. 3 caracteres)..."
                    class="w-full bg-gray-800 text-white border-2 border-gray-700 rounded-xl px-5 py-3 pl-12 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/50 transition text-lg"
                    oninput="filtrarProductos(this.value)"
                >
                <svg class="w-6 h-6 text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Categories Tabs -->
    <div class="sticky top-32 bg-gray-900/95 backdrop-blur-sm border-b border-gray-700 overflow-x-auto z-40 shadow-lg">
        <div class="max-w-7xl mx-auto">
            <div class="flex space-x-2 p-4 min-w-max">
                <button onclick="mostrarCategoria('todas')" 
                        class="categoria-tab px-6 py-3 rounded-xl font-bold transition-all whitespace-nowrap bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg" 
                        data-categoria="todas">
                    📋 Todas
                </button>
                @foreach($categorias as $categoria)
                <button onclick="mostrarCategoria('cat-{{ $categoria->Id }}')" 
                        class="categoria-tab px-6 py-3 rounded-xl font-medium transition-all whitespace-nowrap bg-gray-800 text-gray-300 hover:bg-gray-700 hover:text-white" 
                        data-categoria="cat-{{ $categoria->Id }}">
                    {{ $categoria->Nombre }}
                </button>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="max-w-7xl mx-auto p-6">
        @foreach($categorias as $categoria)
        <div class="categoria-section mb-10" data-categoria="cat-{{ $categoria->Id }}">
            <div class="flex items-center mb-6">
                <h3 class="text-2xl font-bold bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent">
                    {{ $categoria->Nombre }}
                </h3>
                <div class="flex-1 h-px bg-gradient-to-r from-indigo-500/50 to-transparent ml-4"></div>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                @foreach($categoria->productos as $producto)
                <div onclick="abrirModalProducto('{{ $producto->Codigo }}', '{{ addslashes($producto->Nombre) }}', {{ $producto->PrecioVenta }})"
                     data-nombre="{{ $producto->Nombre }}"
                     class="producto-card group cursor-pointer bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl transition-all transform hover:scale-105 active:scale-95 border-2 border-gray-700 hover:border-indigo-500">
                    <div class="p-5">
                        <h4 class="font-bold text-base mb-3 line-clamp-2 text-white group-hover:text-indigo-300 transition min-h-[3rem]">
                            {{ $producto->Nombre }}
                        </h4>
                        <div class="text-center">
                            <p class="text-2xl font-black bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent">
                                ${{ number_format($producto->PrecioVenta, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Product Modal -->
<div id="producto-modal" class="fixed inset-0 bg-black/90 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-3xl max-w-md w-full border-2 border-indigo-500 shadow-2xl">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 id="modal-producto-nombre" class="text-2xl font-bold text-white"></h3>
                <button onclick="cerrarModalProducto()" class="text-gray-400 hover:text-white transition p-2 hover:bg-gray-800 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <div class="mb-6">
                <p id="modal-producto-precio" class="text-4xl font-black bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent"></p>
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-300 font-medium mb-3">Cantidad</label>
                <div class="flex items-center justify-center space-x-4">
                    <button onclick="cambiarCantidadModal(-1)" class="bg-gray-700 hover:bg-indigo-600 w-14 h-14 rounded-xl flex items-center justify-center transition font-bold text-2xl text-white">
                        −
                    </button>
                    <span id="modal-cantidad" class="font-black text-4xl w-16 text-center text-white">1</span>
                    <button onclick="cambiarCantidadModal(1)" class="bg-gray-700 hover:bg-indigo-600 w-14 h-14 rounded-xl flex items-center justify-center transition font-bold text-2xl text-white">
                        +
                    </button>
                </div>
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-300 font-medium mb-3">Observaciones (opcional)</label>
                <textarea 
                    id="modal-observacion"
                    placeholder="Ej: Sin cebolla, término medio, etc."
                    class="w-full bg-gray-700/50 text-white rounded-xl p-4 border-2 border-gray-600 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/50 transition"
                    rows="3"
                ></textarea>
            </div>
            
            <button onclick="agregarAlCarrito()" 
                    class="w-full bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold py-4 px-6 rounded-2xl shadow-2xl transition-all transform hover:scale-105 active:scale-95">
                ✓ Agregar al Pedido
            </button>
        </div>
    </div>
</div>

<!-- Floating Cart Button -->
<div class="fixed bottom-0 left-0 right-0 bg-gradient-to-t from-gray-900 via-gray-900 to-transparent p-6 z-50">
    <div class="max-w-7xl mx-auto">
        <button onclick="toggleCarrito()" 
                class="w-full bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 hover:from-green-700 hover:to-teal-700 text-white font-bold py-5 px-8 rounded-2xl shadow-2xl transition-all transform hover:scale-105 active:scale-95 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span class="text-lg">Ver Pedido</span>
            </div>
            <span id="cart-count" class="bg-white text-green-600 px-4 py-2 rounded-full text-lg font-black min-w-[3rem] text-center">0</span>
        </button>
    </div>
</div>

<!-- Cart Modal -->
<div id="carrito-modal" class="fixed inset-0 bg-black/90 backdrop-blur-sm z-50 hidden">
    <div class="absolute inset-x-0 bottom-0 bg-gradient-to-br from-gray-900 to-gray-800 rounded-t-3xl max-h-[85vh] overflow-y-auto border-t-4 border-indigo-500">
        <div class="sticky top-0 bg-gradient-to-r from-gray-900 to-gray-800 border-b border-gray-700 p-6 flex items-center justify-between z-10">
            <h3 class="text-2xl font-bold bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent">
                🛒 Pedido - {{ $mesa->Nombre }}
            </h3>
            <button onclick="toggleCarrito()" class="text-gray-400 hover:text-white transition p-2 hover:bg-gray-800 rounded-lg">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <div id="cart-items" class="p-6 space-y-4">
            <!-- Cart items will be inserted here -->
        </div>
        
        <div class="sticky bottom-0 bg-gradient-to-t from-gray-900 to-gray-800 border-t border-gray-700 p-6 space-y-4">
            <div class="flex items-center justify-between text-2xl font-bold">
                <span class="text-gray-300">Total:</span>
                <span id="cart-total" class="bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent">$0</span>
            </div>
            <button onclick="enviarPedido()" 
                    class="w-full bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold py-5 px-6 rounded-2xl shadow-2xl transition-all transform hover:scale-105 active:scale-95">
                ✓ Enviar Pedido
            </button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
let carrito = [];
let productoModalActual = null;

function mostrarCategoria(categoriaId) {
    document.querySelectorAll('.categoria-tab').forEach(tab => {
        if (tab.dataset.categoria === categoriaId) {
            tab.classList.remove('bg-gray-800', 'text-gray-300');
            tab.classList.add('bg-gradient-to-r', 'from-indigo-600', 'to-purple-600', 'text-white', 'shadow-lg');
        } else {
            tab.classList.remove('bg-gradient-to-r', 'from-indigo-600', 'to-purple-600', 'shadow-lg');
            tab.classList.add('bg-gray-800', 'text-gray-300');
        }
    });
    
    document.querySelectorAll('.categoria-section').forEach(section => {
        if (categoriaId === 'todas' || section.dataset.categoria === categoriaId) {
            section.style.display = 'block';
        } else {
            section.style.display = 'none';
        }
    });
    
    // Limpiar búsqueda al cambiar de categoría
    document.getElementById('search-input').value = '';
}

function filtrarProductos(busqueda) {
    busqueda = busqueda.toLowerCase().trim();
    
    // Si hay menos de 3 caracteres, mostrar todo según categoría activa
    if (busqueda.length < 3) {
        document.querySelectorAll('.categoria-section').forEach(section => {
            const categoriaActiva = document.querySelector('.categoria-tab.bg-gradient-to-r');
            const categoriaId = categoriaActiva ? categoriaActiva.dataset.categoria : 'todas';
            
            if (categoriaId === 'todas' || section.dataset.categoria === categoriaId) {
                section.style.display = 'block';
                section.querySelectorAll('.producto-card').forEach(card => {
                    card.style.display = 'block';
                });
            }
        });
        
        // Ocultar mensaje de no resultados
        const mensajeNoResultados = document.getElementById('no-resultados');
        if (mensajeNoResultados) {
            mensajeNoResultados.style.display = 'none';
        }
        return;
    }
    
    // Filtrar productos
    let hayResultados = false;
    
    document.querySelectorAll('.categoria-section').forEach(section => {
        const nombreCategoria = section.querySelector('h3').textContent.toLowerCase();
        const categoriaCoincide = nombreCategoria.includes(busqueda);
        
        let productosVisibles = 0;
        
        section.querySelectorAll('.producto-card').forEach(card => {
            const nombreProducto = card.getAttribute('data-nombre').toLowerCase();
            
            if (nombreProducto.includes(busqueda) || categoriaCoincide) {
                card.style.display = 'block';
                productosVisibles++;
                hayResultados = true;
            } else {
                card.style.display = 'none';
            }
        });
        
        // Mostrar/ocultar sección según si tiene productos visibles
        section.style.display = productosVisibles > 0 ? 'block' : 'none';
    });
    
    // Mostrar mensaje si no hay resultados
    const contenedor = document.querySelector('.max-w-7xl');
    let mensajeNoResultados = document.getElementById('no-resultados');
    
    if (!hayResultados) {
        if (!mensajeNoResultados) {
            mensajeNoResultados = document.createElement('div');
            mensajeNoResultados.id = 'no-resultados';
            mensajeNoResultados.className = 'text-center py-20';
            mensajeNoResultados.innerHTML = `
                <div class="inline-flex items-center justify-center w-24 h-24 bg-gray-800 rounded-full mb-6">
                    <svg class="w-12 h-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-400 mb-2">No se encontraron productos</h3>
                <p class="text-gray-500">Intenta con otro término de búsqueda</p>
            `;
            contenedor.appendChild(mensajeNoResultados);
        }
        mensajeNoResultados.style.display = 'block';
    } else if (mensajeNoResultados) {
        mensajeNoResultados.style.display = 'none';
    }

function abrirModalProducto(codigo, nombre, precio) {
    productoModalActual = {
        codigo: codigo,
        nombre: nombre,
        precio: parseFloat(precio)
    };
    
    document.getElementById('modal-producto-nombre').textContent = nombre;
    document.getElementById('modal-producto-precio').textContent = '$' + Math.round(precio).toLocaleString('es-CO');
    document.getElementById('modal-cantidad').textContent = '1';
    document.getElementById('modal-observacion').value = '';
    document.getElementById('producto-modal').classList.remove('hidden');
}

function cerrarModalProducto() {
    document.getElementById('producto-modal').classList.add('hidden');
    productoModalActual = null;
}

function cambiarCantidadModal(delta) {
    const cantidadEl = document.getElementById('modal-cantidad');
    let cantidad = parseInt(cantidadEl.textContent) + delta;
    if (cantidad < 1) cantidad = 1;
    cantidadEl.textContent = cantidad;
}

function agregarAlCarrito() {
    if (!productoModalActual) return;
    
    const cantidad = parseInt(document.getElementById('modal-cantidad').textContent);
    const observacion = document.getElementById('modal-observacion').value.trim();
    
    const existente = carrito.find(item => item.codigo === productoModalActual.codigo && item.observacion === observacion);
    
    if (existente) {
        existente.cantidad += cantidad;
    } else {
        carrito.push({
            codigo: productoModalActual.codigo,
            nombre: productoModalActual.nombre,
            precio: productoModalActual.precio,
            cantidad: cantidad,
            observacion: observacion
        });
    }
    
    actualizarCarrito();
    cerrarModalProducto();
    
    // Show success feedback
    const toast = document.createElement('div');
    toast.className = 'fixed top-24 right-6 bg-green-600 text-white px-6 py-3 rounded-xl shadow-2xl z-50 animate-bounce';
    toast.textContent = '✓ Producto agregado';
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 2000);
}

function actualizarCarrito() {
    const cartCount = document.getElementById('cart-count');
    const cartItems = document.getElementById('cart-items');
    const cartTotal = document.getElementById('cart-total');
    
    const totalItems = carrito.reduce((sum, item) => sum + item.cantidad, 0);
    const total = carrito.reduce((sum, item) => sum + (parseFloat(item.precio) * parseInt(item.cantidad)), 0);
    
    cartCount.textContent = totalItems;
    cartTotal.textContent = '$' + Math.round(total).toLocaleString('es-CO');
    
    if (carrito.length === 0) {
        cartItems.innerHTML = '<div class="text-center py-12"><p class="text-gray-400 text-lg">🛒 No hay productos en el pedido</p><p class="text-gray-500 text-sm mt-2">Agrega productos del menú</p></div>';
        return;
    }
    
    cartItems.innerHTML = carrito.map((item, index) => {
        const subtotal = parseFloat(item.precio) * parseInt(item.cantidad);
        return `
        <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl p-5 border border-gray-700 hover:border-indigo-500/50 transition">
            <div class="flex items-start justify-between mb-3">
                <div class="flex-1">
                    <h4 class="font-bold text-white text-lg">${item.nombre}</h4>
                    <p class="text-sm text-indigo-300 mt-1">$${parseFloat(item.precio).toLocaleString('es-CO')} c/u</p>
                </div>
                <button onclick="eliminarProducto(${index})" class="text-red-400 hover:text-red-300 hover:bg-red-500/10 p-2 rounded-lg transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </div>
            <div class="flex items-center space-x-4 mb-3">
                <button onclick="cambiarCantidad(${index}, -1)" class="bg-gray-700 hover:bg-indigo-600 w-10 h-10 rounded-xl flex items-center justify-center transition font-bold text-lg">
                    −
                </button>
                <span class="font-black text-xl w-12 text-center text-white">${item.cantidad}</span>
                <button onclick="cambiarCantidad(${index}, 1)" class="bg-gray-700 hover:bg-indigo-600 w-10 h-10 rounded-xl flex items-center justify-center transition font-bold text-lg">
                    +
                </button>
                <div class="flex-1 text-right">
                    <p class="text-xs text-gray-400">Subtotal</p>
                    <p class="font-black text-xl bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent">
                        $${Math.round(subtotal).toLocaleString('es-CO')}
                    </p>
                </div>
            </div>
            <textarea 
                onchange="actualizarObservacionCarrito(${index}, this.value)"
                placeholder="💬 Observaciones (opcional)"
                class="w-full bg-gray-700/50 text-white rounded-xl p-3 text-sm border border-gray-600 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/50 transition"
                rows="2"
            >${item.observacion || ''}</textarea>
        </div>
    `}).join('');
}

function cambiarCantidad(index, delta) {
    carrito[index].cantidad += delta;
    if (carrito[index].cantidad <= 0) {
        carrito.splice(index, 1);
    }
    actualizarCarrito();
}

function eliminarProducto(index) {
    carrito.splice(index, 1);
    actualizarCarrito();
}

function actualizarObservacionCarrito(index, valor) {
    carrito[index].observacion = valor.trim();
}

function toggleCarrito() {
    const modal = document.getElementById('carrito-modal');
    modal.classList.toggle('hidden');
}

async function enviarPedido() {
    if (carrito.length === 0) {
        alert('El pedido está vacío');
        return;
    }
    
    const btn = event.target;
    btn.disabled = true;
    btn.textContent = '⏳ Enviando...';
    
    try {
        const response = await fetch('{{ route("crear.orden", $mesa->Id) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                productos: carrito
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            alert('✓ ¡Pedido enviado exitosamente!');
            carrito = [];
            actualizarCarrito();
            toggleCarrito();
            window.location.href = '{{ route("mesas") }}';
        } else {
            alert('✗ Error al enviar el pedido');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('✗ Error al enviar el pedido');
    } finally {
        btn.disabled = false;
        btn.textContent = '✓ Enviar Pedido';
    }
}
</script>
@endsection
