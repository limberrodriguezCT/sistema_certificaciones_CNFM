@extends('layouts.app')
@section('title', 'Crear Evento')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded shadow-md border-t-8 border-cyan-500 relative overflow-hidden">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Registrar Nuevo Evento</h2>
    <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Título del Evento</label>
            <input type="text" name="title" class="w-full px-3 py-2 border rounded focus:outline-none focus:border-blue-500" value="{{ old('title') }}">
            @error('title') <span class="text-red-500 text-sm font-bold">{{ $message }}</span> @enderror
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Tipo de Documento</label>
            <select name="document_type" class="w-full px-3 py-2 border rounded focus:outline-none focus:border-blue-500">
                <option value="certificacion">Certificación</option>
                <option value="reconocimiento">Reconocimiento</option>
                <option value="participacion">Participación</option>
            </select>
            @error('document_type') <span class="text-red-500 text-sm font-bold">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 font-bold mb-2">Apertura</label>
                <input type="datetime-local" name="start_date" class="w-full px-3 py-2 border rounded focus:outline-none focus:border-blue-500" value="{{ old('start_date') }}">
                @error('start_date') <span class="text-red-500 text-sm font-bold">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-gray-700 font-bold mb-2">Cierre</label>
                <input type="datetime-local" name="end_date" class="w-full px-3 py-2 border rounded focus:outline-none focus:border-blue-500" value="{{ old('end_date') }}">
                @error('end_date') <span class="text-red-500 text-sm font-bold">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Plantilla Base (Opcional, PDF o Imagen)</label>
            <input type="file" name="template_path" class="w-full px-3 py-2 border rounded focus:outline-none focus:border-blue-500">
            @error('template_path') <span class="text-red-500 text-sm font-bold">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-end">
            <button type="submit" class="cnfd-bg text-white px-6 py-2 rounded-full font-bold shadow hover:bg-blue-800 transition">Guardar Evento</button>
        </div>
    </form>
</div>
@endsection