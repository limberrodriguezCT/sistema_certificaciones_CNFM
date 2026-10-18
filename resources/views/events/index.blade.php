@extends('layouts.app')
@section('title', 'Lista de Eventos')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-800 border-b-4 border-cyan-500 pb-2">Gestión de Eventos</h1>
    <a href="{{ route('events.create') }}" class="cnfd-magenta text-white px-6 py-2 rounded-full shadow hover:bg-pink-700 transition font-bold">Crear Evento</a>
</div>

<div class="bg-white shadow-lg rounded-lg border-t-4 border-blue-900 my-6 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-100 text-gray-600 uppercase text-sm border-b-2 border-gray-200">
                <tr>
                    <th class="py-4 px-6 font-bold text-left tracking-wider">Título</th>
                    <th class="py-4 px-6 font-bold text-left tracking-wider">Tipo</th>
                    <th class="py-4 px-6 font-bold text-left tracking-wider">Cierre</th>
                    <th class="py-4 px-6 font-bold text-center tracking-wider">Acciones Administrativas</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm">
                @foreach($events as $event)
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                    <td class="py-4 px-6 font-bold text-gray-800">{{ $event->title }}</td>
                    <td class="py-4 px-6 font-bold text-blue-900">{{ mb_strtoupper($event->document_type) }}</td>
                    <td class="py-4 px-6 text-gray-600 font-medium">{{ $event->end_date->format('d/m/Y H:i') }}</td>
                    <td class="py-4 px-6 flex justify-center flex-wrap gap-2">
                        <a href="{{ route('participants.create', $event->uuid) }}" target="_blank" class="inline-flex items-center px-3 py-1 bg-pink-100 text-pink-700 rounded-full font-bold hover:bg-pink-200 transition border border-pink-200">
                            Enlace
                        </a>
                        <a href="{{ route('events.show', $event) }}" class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 rounded-full font-bold hover:bg-blue-200 transition border border-blue-200">
                            Historial
                        </a>
                        <a href="{{ route('events.edit', $event) }}" class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-700 rounded-full font-bold hover:bg-gray-200 transition border border-gray-300">
                            Datos
                        </a>
                        <a href="{{ route('events.map', $event) }}" class="inline-flex items-center px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full font-bold hover:bg-indigo-200 transition border border-indigo-200">
                            Diseño
                        </a>
                        
                        <form action="{{ route('events.destroy', $event) }}" method="POST" class="form-delete inline-block m-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 rounded-full font-bold hover:bg-red-200 transition border border-red-200">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection