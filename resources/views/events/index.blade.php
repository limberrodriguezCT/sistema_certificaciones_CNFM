@extends('layouts.app')
@section('title', 'Lista de Eventos')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-800 border-b-4 border-cyan-500 pb-2">Gestión de Eventos</h1>
    <a href="{{ route('events.create') }}" class="cnfd-magenta text-white px-6 py-2 rounded-full shadow hover:bg-pink-700 transition font-bold">Crear Evento</a>
</div>

<div class="bg-white shadow-md rounded border-t-4 border-blue-900 my-6 overflow-x-auto">
    <table class="min-w-full bg-white">
        <thead class="bg-gray-200 text-gray-700">
            <tr>
                <th class="py-3 px-4 uppercase font-bold text-sm text-left">Título</th>
                <th class="py-3 px-4 uppercase font-bold text-sm text-left">Tipo</th>
                <th class="py-3 px-4 uppercase font-bold text-sm text-left">Cierre</th>
                <th class="py-3 px-4 uppercase font-bold text-sm text-left">Acciones</th>
            </tr>
        </thead>
        <tbody class="text-gray-700">
            @foreach($events as $event)
            <tr class="border-b hover:bg-gray-50">
                <td class="py-3 px-4">{{ $event->title }}</td>
                <td class="py-3 px-4 uppercase text-xs font-bold text-blue-900">{{ $event->document_type }}</td>
                <td class="py-3 px-4">{{ $event->end_date->format('d/m/Y H:i') }}</td>
                <td class="py-3 px-4">
                    <a href="{{ route('participants.create', $event->uuid) }}" target="_blank" class="text-pink-600 font-bold hover:underline">Ver Enlace</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection