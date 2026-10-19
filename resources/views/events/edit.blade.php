@extends('layouts.app')
@section('title', 'Editar Evento')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-md border-t-8 border-cyan-500">
    <div class="flex justify-between items-center mb-6 border-b pb-4">
        <div>
            <h2 class="text-2xl font-extrabold text-slate-800">Editar Datos del Evento</h2>
            <p class="text-xs text-slate-500 mt-1">Modifique la información general o reemplace la imagen de la plantilla.</p>
        </div>
        <a href="{{ route('events.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg font-bold text-sm transition flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i> Volver
        </a>
    </div>

    <form action="{{ route('events.update', $event) }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PUT')
        
        <div class="mb-5">
            <label class="block text-slate-700 font-bold mb-2 text-sm">Título del Evento</label>
            <input type="text" name="title" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:border-blue-600" value="{{ old('title', $event->title) }}">
        </div>
        
        <div class="mb-5">
            <label class="block text-slate-700 font-bold mb-2 text-sm">Tipo de Documento a Emitir</label>
            <select name="document_type" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:border-blue-600 bg-white">
                <option value="certificacion" {{ $event->document_type == 'certificacion' ? 'selected' : '' }}>Certificación</option>
                <option value="reconocimiento" {{ $event->document_type == 'reconocimiento' ? 'selected' : '' }}>Reconocimiento</option>
                <option value="participacion" {{ $event->document_type == 'participacion' ? 'selected' : '' }}>Participación</option>
            </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
            <div>
                <label class="block text-slate-700 font-bold mb-2 text-sm">Fecha y Hora de Apertura</label>
                <input type="datetime-local" name="start_date" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:border-blue-600" value="{{ old('start_date', $event->start_date->format('Y-m-d\TH:i')) }}">
            </div>
            <div>
                <label class="block text-slate-700 font-bold mb-2 text-sm">Fecha y Hora de Cierre</label>
                <input type="datetime-local" name="end_date" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:border-blue-600" value="{{ old('end_date', $event->end_date->format('Y-m-d\TH:i')) }}">
            </div>
        </div>

        <div class="mb-6 bg-blue-50/60 p-4 rounded-xl border border-blue-200">
            <label class="block text-slate-800 font-bold mb-2 text-sm">
                <i class="fa-regular fa-image text-blue-600 mr-1"></i> Reemplazar Plantilla Base (Opcional - Solo Imagen JPG o PNG)
            </label>
            <input type="file" name="template_path" accept=".jpg,.jpeg,.png,image/jpeg,image/png" class="w-full px-3 py-2 border border-slate-300 rounded-lg bg-white focus:outline-none focus:border-blue-600 text-sm">
            <p class="text-xs text-slate-600 mt-2 font-medium">
                <i class="fa-solid fa-circle-info text-cyan-600 mr-1"></i> Si no selecciona ningún archivo, se conservará la imagen actual. Solo se admiten imágenes en formato <strong>.JPG o .PNG</strong> (máximo 5MB).
            </p>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="cnfd-bg text-white px-8 py-3 rounded-xl font-bold shadow-md hover:opacity-95 transition flex items-center gap-2">
                <i class="fa-solid fa-rotate"></i> Actualizar Evento
            </button>
        </div>
    </form>
</div>
@endsection