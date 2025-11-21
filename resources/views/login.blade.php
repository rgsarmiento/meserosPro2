@extends('layouts.app')

@section('title', 'Login - MeserosPro2')

@section('content')
<div class="min-h-screen flex items-center justify-center p-6 bg-gradient-to-br from-gray-900 via-purple-900/20 to-gray-900">
    <div class="w-full max-w-2xl">
        <!-- Logo/Header -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-indigo-500 via-purple-600 to-pink-600 rounded-3xl mb-6 shadow-2xl transform hover:scale-110 transition">
                <svg class="w-14 h-14 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <h1 class="text-5xl font-black bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400 bg-clip-text text-transparent mb-3">
                MeserosPro2
            </h1>
            <p class="text-gray-400 text-lg">Selecciona tu usuario para continuar</p>
        </div>

        <!-- Error Messages -->
        @if($errors->any())
        <div class="bg-gradient-to-r from-red-500/20 to-pink-500/20 border-2 border-red-500/50 rounded-2xl p-5 mb-8 backdrop-blur-sm">
            <div class="flex items-center space-x-3">
                <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-red-300 font-medium">{{ $errors->first() }}</p>
            </div>
        </div>
        @endif

        <!-- Login Form -->
        <form action="{{ route('authenticate') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-2 gap-5">
                @foreach($usuarios as $usuario)
                <label class="relative cursor-pointer group">
                    <input type="radio" name="usuario_id" value="{{ $usuario->Id }}" class="peer sr-only" required>
                    <div class="bg-gradient-to-br from-gray-800 to-gray-900 border-2 border-gray-700 rounded-2xl p-8 text-center transition-all 
                                peer-checked:border-indigo-500 peer-checked:bg-gradient-to-br peer-checked:from-indigo-500/20 peer-checked:to-purple-500/20 
                                hover:border-gray-600 hover:shadow-xl group-hover:scale-105 transform">
                        <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-indigo-500 via-purple-600 to-pink-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-2xl transition">
                            <span class="text-3xl font-black text-white">{{ substr($usuario->Nombre, 0, 1) }}</span>
                        </div>
                        <p class="font-bold text-white text-lg">{{ $usuario->Nombre }}</p>
                        <div class="mt-3 opacity-0 peer-checked:opacity-100 transition">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-indigo-500 text-white">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                Seleccionado
                            </span>
                        </div>
                    </div>
                </label>
                @endforeach
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 hover:from-indigo-700 hover:to-pink-700 text-white font-black text-lg py-5 px-8 rounded-2xl shadow-2xl transition-all transform hover:scale-105 active:scale-95">
                🚀 Iniciar Sesión
            </button>
        </form>

        <!-- Footer -->
        <div class="text-center mt-8">
            <p class="text-gray-500 text-sm">Sistema de Gestión de Pedidos</p>
        </div>
    </div>
</div>
@endsection
