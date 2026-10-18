@extends('layouts.app')
@section('title', 'Acceso al Sistema')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded shadow-lg border-t-8 border-blue-900 mt-20 relative overflow-hidden">
    <div class="absolute -top-12 -left-12 w-32 h-32 cnfd-cyan cnfd-rounded"></div>
    
    <h2 class="text-3xl font-bold mb-6 text-center text-gray-800 relative z-10">Administración</h2>
    
    <!-- Se agrega novalidate para evitar validación de HTML5 en inglés -->
    <form method="POST" action="{{ route('login') }}" class="relative z-10" novalidate>
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Correo Electrónico</label>
            <input type="email" name="email" class="w-full px-3 py-2 border rounded focus:outline-none focus:border-blue-500" autofocus>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Contraseña</label>
            <input type="password" name="password" class="w-full px-3 py-2 border rounded focus:outline-none focus:border-blue-500">
        </div>

        <button type="submit" class="w-full cnfd-bg text-white px-6 py-3 rounded-full font-bold shadow hover:bg-blue-800 transition">Ingresar</button>
    </form>
</div>
@endsection