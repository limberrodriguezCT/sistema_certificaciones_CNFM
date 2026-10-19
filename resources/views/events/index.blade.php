@extends('layouts.app')
@section('title', 'Gestión de Eventos')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4 bg-white p-6 rounded-xl shadow-sm border-l-8 border-cyan-500">
    <div>
        <h1 class="text-2xl md:text-3xl font-extrabold text-slate-800">Panel de Gestión de Eventos</h1>
        <p class="text-slate-500 text-sm mt-1">Administre los enlaces de inscripción, plantillas de certificados y nóminas de participantes.</p>
    </div>
    <a href="{{ route('events.create') }}" class="cnfd-magenta text-white px-6 py-3 rounded-xl shadow-md hover:bg-pink-700 transition font-bold flex items-center gap-2">
        <i class="fa-solid fa-plus-circle text-lg"></i> Crear Nuevo Evento
    </a>
</div>

<div class="bg-white shadow-md rounded-xl border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-800 text-white uppercase text-xs tracking-wider">
                <tr>
                    <th class="py-4 px-6 font-bold text-left">Evento / Tipo</th>
                    <th class="py-4 px-6 font-bold text-left">Vigencia del Registro</th>
                    <th class="py-4 px-6 font-bold text-center">Inscritos</th>
                    <th class="py-4 px-6 font-bold text-center">Enlace de Inscripción</th>
                    <th class="py-4 px-6 font-bold text-center">Gestión y Diseño</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm bg-white">
                @forelse($events as $event)
                @php
                    $now = now();
                    $isActive = $now->between($event->start_date, $event->end_date);
                @endphp
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-4 px-6">
                        <div class="font-extrabold text-slate-800 text-base">{{ $event->title }}</div>
                        <span class="inline-flex items-center gap-1 mt-1 px-2.5 py-0.5 rounded-md text-xs font-bold bg-blue-50 text-blue-800 border border-blue-200 uppercase">
                            <i class="fa-solid fa-award text-cyan-600"></i> {{ $event->document_type }}
                        </span>
                    </td>

                    <td class="py-4 px-6">
                        <div class="text-slate-700 font-medium">
                            <i class="fa-regular fa-clock text-slate-400 mr-1"></i> Cierra: {{ $event->end_date->format('d/m/Y h:i A') }}
                        </div>
                        @if($isActive)
                            <span class="inline-flex items-center gap-1 text-xs font-bold text-emerald-600 mt-1">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Formulario Abierto
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 text-xs font-bold text-rose-600 mt-1">
                                <span class="w-2 h-2 rounded-full bg-rose-500"></span> Formulario Cerrado
                            </span>
                        @endif
                    </td>

                    <td class="py-4 px-6 text-center">
                        <a href="{{ route('events.show', $event) }}" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-blue-50 text-slate-800 hover:text-blue-700 font-extrabold transition border border-slate-200" title="Ver lista de participantes">
                            <i class="fa-solid fa-users text-blue-600"></i> {{ $event->participants()->count() }}
                        </a>
                    </td>

                    <td class="py-4 px-6 text-center">
                        <div class="inline-flex items-center gap-2">
                            <button type="button" onclick="copyLink('{{ route('participants.create', $event->uuid) }}')" class="px-3 py-2 bg-cyan-50 hover:bg-cyan-100 text-cyan-800 rounded-lg font-bold text-xs border border-cyan-200 transition flex items-center gap-1.5" title="Copiar enlace para compartir">
                                <i class="fa-regular fa-copy"></i> Copiar Enlace
                            </button>
                            <a href="{{ route('participants.create', $event->uuid) }}" target="_blank" class="p-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg border border-slate-200 transition" title="Abrir formulario público en pestaña nueva">
                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                            </a>
                        </div>
                    </td>

                    <td class="py-4 px-6 text-center">
                        <div class="flex justify-center items-center flex-wrap gap-2">
                            <a href="{{ route('events.show', $event) }}" class="px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-bold text-xs shadow-sm transition flex items-center gap-1.5" title="Ver participantes y emitir certificados">
                                <i class="fa-solid fa-list-check"></i> Participantes
                            </a>

                            <a href="{{ route('events.map', $event) }}" class="px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-bold text-xs shadow-sm transition flex items-center gap-1.5" title="Posicionar nombre y tipografía en el certificado">
                                <i class="fa-solid fa-wand-magic-sparkles"></i> Diseñar Certificado
                            </a>

                            <a href="{{ route('events.edit', $event) }}" class="px-3 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-lg font-bold text-xs shadow-sm transition flex items-center gap-1.5" title="Modificar título, fechas o imagen del evento">
                                <i class="fa-solid fa-pen-to-square"></i> Editar Evento
                            </a>

                            <form action="{{ route('events.destroy', $event) }}" method="POST" class="form-delete inline-block m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-lg font-bold text-xs shadow-sm transition flex items-center gap-1.5" title="Eliminar evento permanentemente">
                                    <i class="fa-solid fa-trash-can"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-12 text-center text-slate-500">
                        <i class="fa-regular fa-folder-open text-4xl text-slate-300 mb-3 block"></i>
                        <span class="font-bold text-base block">No hay eventos registrados todavía.</span>
                        <span class="text-xs">Haga clic en el botón "Crear Nuevo Evento" para comenzar.</span>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    function copyLink(url) {
        navigator.clipboard.writeText(url).then(() => {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Enlace copiado al portapapeles',
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true
            });
        });
    }
</script>
@endsection