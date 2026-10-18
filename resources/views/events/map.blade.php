@extends('layouts.app')
@section('title', 'Mapeo de Coordenadas')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-8 rounded shadow-md border-t-8 border-cyan-500 text-center">
    <h2 class="text-2xl font-bold mb-4 text-gray-800">Definir Posición del Nombre</h2>
    <p class="text-gray-600 mb-6">El sistema centrará el nombre automáticamente. Usá los controles para ajustar la altura (Eje Y) donde querés que aparezca el texto y revisá la vista previa.</p>

    <form action="{{ route('events.save_map', $event) }}" method="POST" class="mb-6 bg-gray-100 p-4 rounded inline-block">
        @csrf
        <div class="flex items-center space-x-4">
            <input type="hidden" name="x_coord" value="0">
            <div>
                <label class="font-bold text-gray-700">Posición Vertical (Y):</label>
                <input type="number" step="0.1" name="y_coord" id="y_coord" class="w-24 px-2 py-1 border rounded focus:outline-none" value="{{ $event->y_coord ?? 100 }}" required>
                <span class="text-sm text-gray-500">mm</span>
            </div>
            <button type="submit" class="cnfd-bg text-white px-6 py-2 rounded shadow font-bold hover:bg-blue-800">Guardar Posición</button>
        </div>
    </form>

    <div class="mt-4">
        <a href="{{ route('certificates.preview', $event) }}" target="_blank" class="cnfd-magenta text-white px-6 py-3 rounded shadow font-bold hover:bg-pink-700 transition">Generar Vista Previa del PDF</a>
    </div>
</div>
@endsection