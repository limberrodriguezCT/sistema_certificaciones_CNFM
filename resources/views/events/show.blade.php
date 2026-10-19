@extends('layouts.app')
@section('title', 'Participantes Registrados')

@section('content')
<div class="bg-white p-6 rounded-xl shadow-sm border-l-8 border-blue-900 mb-6 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
    <div>
        <div class="flex items-center gap-3">
            <h1 class="text-2xl md:text-3xl font-extrabold text-slate-800">{{ $event->title }}</h1>
            <span class="px-3 py-1 bg-blue-50 text-blue-800 border border-blue-200 rounded-full text-xs font-bold uppercase">
                {{ $event->document_type }}
            </span>
        </div>
        <p class="text-slate-600 font-semibold mt-1 text-sm">
            <i class="fa-solid fa-users text-cyan-600 mr-1"></i> Total de protagonistas registrados: <span class="text-blue-900 font-extrabold">{{ $participants->count() }}</span>
        </p>
    </div>

    <div class="flex flex-wrap gap-2">
        <a href="{{ route('events.index') }}" class="bg-slate-200 text-slate-700 px-4 py-2.5 rounded-xl font-bold text-sm hover:bg-slate-300 transition flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i> Volver
        </a>
        <a href="{{ route('events.map', $event) }}" class="bg-indigo-600 text-white px-4 py-2.5 rounded-xl shadow font-bold text-sm hover:bg-indigo-700 transition flex items-center gap-2">
            <i class="fa-solid fa-wand-magic-sparkles"></i> Diseñar Certificado
        </a>
        <a href="{{ route('certificates.preview', $event) }}" target="_blank" class="bg-cyan-600 text-white px-4 py-2.5 rounded-xl shadow font-bold text-sm hover:bg-cyan-700 transition flex items-center gap-2">
            <i class="fa-solid fa-eye"></i> Previsualizar PDF
        </a>
        <a href="{{ route('certificates.bulk', $event) }}" class="cnfd-bg text-white px-4 py-2.5 rounded-xl shadow font-bold text-sm hover:opacity-95 transition flex items-center gap-2">
            <i class="fa-solid fa-file-arrow-down"></i> Descargar Consolidado
        </a>
        <form action="{{ route('certificates.send_bulk', $event) }}" method="POST" class="inline m-0 form-send-emails">
            @csrf
            <button type="submit" class="cnfd-magenta text-white px-4 py-2.5 rounded-xl shadow font-bold text-sm hover:bg-pink-700 transition flex items-center gap-2">
                <i class="fa-solid fa-paper-plane"></i> Enviar por Correo
            </button>
        </form>
    </div>
</div>

<div class="bg-white shadow-md rounded-xl border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-800 text-white uppercase text-xs tracking-wider">
                <tr>
                    <th class="py-4 px-6 font-bold text-left">Nombre Completo</th>
                    <th class="py-4 px-6 font-bold text-left">Cédula</th>
                    <th class="py-4 px-6 font-bold text-left">Correo Electrónico</th>
                    <th class="py-4 px-6 font-bold text-left">Teléfono</th>
                    <th class="py-4 px-6 font-bold text-left">Procedencia</th>
                    <th class="py-4 px-6 font-bold text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm bg-white">
                @forelse($participants as $participant)
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-4 px-6 font-bold text-slate-800">{{ $participant->full_name }}</td>
                    <td class="py-4 px-6 font-semibold uppercase text-slate-700">{{ $participant->cedula }}</td>
                    <td class="py-4 px-6 text-slate-600">{{ $participant->email }}</td>
                    <td class="py-4 px-6 text-slate-600">{{ $participant->phone }}</td>
                    <td class="py-4 px-6 text-slate-600">{{ $participant->location }}</td>
                    <td class="py-4 px-6 flex justify-center gap-2">
                        <a href="{{ route('certificates.individual', $participant) }}" target="_blank" class="px-3 py-1.5 bg-blue-600 text-white rounded-lg font-bold text-xs hover:bg-blue-700 transition flex items-center gap-1.5 shadow-sm" title="Visualizar certificado individual">
                            <i class="fa-solid fa-file-pdf"></i> Ver PDF
                        </a>
                        <form action="{{ route('participants.destroy', $participant) }}" method="POST" class="inline m-0 form-delete-participant">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1.5 bg-rose-600 text-white rounded-lg font-bold text-xs hover:bg-rose-700 transition flex items-center gap-1.5 shadow-sm" title="Eliminar registro">
                                <i class="fa-solid fa-trash-can"></i> Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-12 text-center text-slate-500 font-bold">
                        <i class="fa-solid fa-user-slash text-3xl text-slate-300 mb-2 block"></i>
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
                text: "Se enviarán los certificados por correo electrónico a todos los protagonistas registrados en la lista.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#0d47a1',
                cancelButtonColor: '#64748b',
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
                title: '¿Eliminar participante?',
                text: "Esta acción es irreversible y los datos del participante no podrán ser recuperados.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e91e63',
                cancelButtonColor: '#64748b',
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