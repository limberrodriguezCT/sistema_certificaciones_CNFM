@extends('layouts.app')
@section('title', 'Editar Evento')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded shadow-md border-t-8 border-cyan-500 relative overflow-hidden">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Editar Evento</h2>
        <a href="{{ route('events.index') }}" class="text-gray-500 font-bold hover:underline">Volver</a>
    </div>

    <form action="{{ route('events.update', $event) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Título del Evento</label>
            <input type="text" name="title" class="w-full px-3 py-2 border rounded focus:outline-none focus:border-blue-500" value="{{ old('title', $event->title) }}">
            @error('title') <span class="text-red-500 text-sm font-bold">{{ $message }}</span> @enderror
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Tipo de Documento</label>
            <select name="document_type" class="w-full px-3 py-2 border rounded focus:outline-none focus:border-blue-500">
                <option value="certificacion" {{ $event->document_type == 'certificacion' ? 'selected' : '' }}>Certificación</option>
                <option value="reconocimiento" {{ $event->document_type == 'reconocimiento' ? 'selected' : '' }}>Reconocimiento</option>
                <option value="participacion" {{ $event->document_type == 'participacion' ? 'selected' : '' }}>Participación</option>
            </select>
            @error('document_type') <span class="text-red-500 text-sm font-bold">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 font-bold mb-2">Apertura</label>
                <input type="datetime-local" name="start_date" class="w-full px-3 py-2 border rounded focus:outline-none focus:border-blue-500" value="{{ old('start_date', $event->start_date->format('Y-m-d\TH:i')) }}">
                @error('start_date') <span class="text-red-500 text-sm font-bold">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-gray-700 font-bold mb-2">Cierre</label>
                <input type="datetime-local" name="end_date" class="w-full px-3 py-2 border rounded focus:outline-none focus:border-blue-500" value="{{ old('end_date', $event->end_date->format('Y-m-d\TH:i')) }}">
                @error('end_date') <span class="text-red-500 text-sm font-bold">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Cambiar Plantilla (Opcional)</label>
            <input type="file" name="template_path" class="w-full px-3 py-2 border rounded focus:outline-none focus:border-blue-500">
            <p class="text-xs text-gray-500 mt-1">Si no subís nada, se mantendrá el diseño anterior.</p>
            @error('template_path') <span class="text-red-500 text-sm font-bold">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-end">
            <button type="submit" class="cnfd-bg text-white px-6 py-2 rounded-full font-bold shadow hover:bg-blue-800 transition">Actualizar Evento</button>
        </div>
    </form>
</div>
@endsection