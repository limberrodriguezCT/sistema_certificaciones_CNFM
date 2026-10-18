@extends('layouts.app')
@section('title', 'Registro al Evento')

@section('content')
<div class="max-w-lg mx-auto bg-white p-8 rounded shadow-lg border-t-8 border-pink-600 relative overflow-hidden mt-10">
    <!-- Elemento gráfico circular -->
    <div class="absolute -top-12 -right-12 w-32 h-32 cnfd-cyan cnfd-rounded"></div>

    <h2 class="text-2xl font-bold mb-2 text-blue-900 relative z-10">Registro en Línea</h2>
    <p class="text-gray-600 mb-6 font-bold border-b pb-2 relative z-10">{{ $event->title }}</p>

    <form action="{{ route('participants.store', $event->uuid) }}" method="POST" class="relative z-10">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Nombre Completo</label>
            <input type="text" name="full_name" class="w-full px-3 py-2 border rounded focus:outline-none focus:border-pink-500" value="{{ old('full_name') }}" placeholder="Ingresá tu nombre">
            @error('full_name') <span class="text-red-500 text-sm font-bold">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Correo Electrónico</label>
            <input type="email" name="email" class="w-full px-3 py-2 border rounded focus:outline-none focus:border-pink-500" value="{{ old('email') }}" placeholder="ejemplo@correo.com">
            @error('email') <span class="text-red-500 text-sm font-bold">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Número de Teléfono</label>
            <input type="text" name="phone" class="w-full px-3 py-2 border rounded focus:outline-none focus:border-pink-500" value="{{ old('phone') }}" placeholder="Ej. 8888-8888">
            @error('phone') <span class="text-red-500 text-sm font-bold">{{ $message }}</span> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Lugar de Procedencia</label>
            <input type="text" name="location" class="w-full px-3 py-2 border rounded focus:outline-none focus:border-pink-500" value="{{ old('location') }}" placeholder="Ej. Estelí">
            @error('location') <span class="text-red-500 text-sm font-bold">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="w-full cnfd-bg text-white px-6 py-3 rounded-full font-bold shadow hover:bg-blue-800 transition">Enviar Registro</button>
    </form>
</div>
@endsection