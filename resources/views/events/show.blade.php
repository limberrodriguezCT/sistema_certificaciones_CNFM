@extends('layouts.app')
@section('title', 'Detalles del Evento')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">{{ $event->title }}</h1>
        <p class="text-gray-600">Protagonistas registrados: <span class="font-bold">{{ $participants->count() }}</span></p>
    </div>
    <div class="space-x-2 flex">
        <a href="{{ route('events.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600 font-bold">Volver</a>
        <a href="{{ route('certificates.preview', $event) }}" target="_blank" class="bg-indigo-600 text-white px-4 py-2 rounded shadow hover:bg-indigo-700 font-bold">Ver Diseño</a>
        <a href="{{ route('certificates.bulk', $event) }}" class="cnfd-bg text-white px-4 py-2 rounded shadow hover:bg-blue-800 font-bold">Descargar Consolidado</a>
        <form action="{{ route('certificates.send_bulk', $event) }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="cnfd-magenta text-white px-4 py-2 rounded shadow hover:bg-pink-700 font-bold" onclick="return confirm('¿Seguro que querés enviar todos los correos?')">Enviar a Correos</button>
        </form>
    </div>
</div>

<div class="bg-white shadow-md rounded border-t-4 border-blue-900 overflow-x-auto">
    <table class="min-w-full bg-white">
        <thead class="bg-gray-200 text-gray-700">
            <tr>
                <th class="py-3 px-4 uppercase font-bold text-sm text-left">Nombre</th>
                <th class="py-3 px-4 uppercase font-bold text-sm text-left">Correo</th>
                <th class="py-3 px-4 uppercase font-bold text-sm text-left">Teléfono</th>
                <th class="py-3 px-4 uppercase font-bold text-sm text-left">Lugar</th>
                <th class="py-3 px-4 uppercase font-bold text-sm text-left">Acción</th>
            </tr>
        </thead>
        <tbody class="text-gray-700">
            @forelse($participants as $participant)
            <tr class="border-b hover:bg-gray-50">
                <td class="py-3 px-4 font-bold">{{ $participant->full_name }}</td>
                <td class="py-3 px-4">{{ $participant->email }}</td>
                <td class="py-3 px-4">{{ $participant->phone }}</td>
                <td class="py-3 px-4">{{ $participant->location }}</td>
                <td class="py-3 px-4">
                    <a href="{{ route('certificates.individual', $participant) }}" class="text-cyan-600 font-bold hover:underline">Descargar PDF</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="py-6 text-center text-gray-500 font-bold">No hay registros todavía.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection