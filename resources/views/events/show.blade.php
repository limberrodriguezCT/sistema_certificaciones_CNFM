@extends('layouts.app')
@section('title', 'Historial del Evento')

@section('content')
<div class="mb-6">
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <h1 class="text-3xl font-bold text-gray-800">{{ $event->title }}</h1>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('events.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded shadow font-bold hover:bg-gray-600 transition">Volver</a>
            <a href="{{ route('events.map', $event) }}" class="bg-indigo-600 text-white px-4 py-2 rounded shadow font-bold hover:bg-indigo-700 transition">Ver Diseño</a>
            <a href="{{ route('certificates.bulk', $event) }}" class="cnfd-bg text-white px-4 py-2 rounded shadow font-bold hover:bg-blue-800 transition">Descargar Consolidado</a>
            <form action="{{ route('certificates.send_bulk', $event) }}" method="POST" class="inline m-0 form-send-emails">
                @csrf
                <button type="submit" class="cnfd-magenta text-white px-4 py-2 rounded shadow font-bold hover:bg-pink-700 transition">Enviar a Correos</button>
            </form>
        </div>
    </div>
    <p class="text-gray-600 font-bold mt-2">Protagonistas registrados: {{ $participants->count() }}</p>
</div>

<div class="bg-white shadow-lg rounded-lg border-t-4 border-blue-900 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-100 text-gray-600 uppercase text-sm border-b-2 border-gray-200">
                <tr>
                    <th class="py-4 px-6 font-bold text-left tracking-wider">Nombre Completo</th>
                    <th class="py-4 px-6 font-bold text-left tracking-wider">Cédula</th>
                    <th class="py-4 px-6 font-bold text-left tracking-wider">Correo Electrónico</th>
                    <th class="py-4 px-6 font-bold text-left tracking-wider">Teléfono</th>
                    <th class="py-4 px-6 font-bold text-left tracking-wider">Procedencia</th>
                    <th class="py-4 px-6 font-bold text-center tracking-wider">Acción</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm">
                @forelse($participants as $participant)
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                    <td class="py-4 px-6 font-bold text-gray-800">{{ $participant->full_name }}</td>
                    <td class="py-4 px-6 font-medium uppercase">{{ $participant->cedula }}</td>
                    <td class="py-4 px-6 font-medium">{{ $participant->email }}</td>
                    <td class="py-4 px-6 font-medium">{{ $participant->phone }}</td>
                    <td class="py-4 px-6 font-medium">{{ $participant->location }}</td>
                    <td class="py-4 px-6 flex justify-center gap-2">
                        <a href="{{ route('certificates.individual', $participant) }}" class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 rounded border border-blue-200 font-bold hover:bg-blue-200 transition">
                            PDF
                        </a>
                        <form action="{{ route('participants.destroy', $participant) }}" method="POST" class="inline m-0 form-delete-participant">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 rounded border border-red-200 font-bold hover:bg-red-200 transition">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-8 text-center text-gray-500 font-bold">
                        No existen protagonistas registrados en este evento todavía.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    document.querySelectorAll('.form-send-emails').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Confirmar envío masivo?',
                text: "Se procederá a despachar los documentos al correo electrónico de todos los protagonistas registrados.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#0d47a1',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sí, enviar documentos',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });

    document.querySelectorAll('.form-delete-participant').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Eliminar registro?',
                text: "Esta acción es irreversible. Los datos del protagonista serán eliminados del sistema de forma permanente.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e91e63',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sí, eliminar registro',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });
</script>
@endsection