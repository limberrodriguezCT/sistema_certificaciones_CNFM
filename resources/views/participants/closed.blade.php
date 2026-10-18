@extends('layouts.app')
@section('title', 'Registro Cerrado')

@section('content')
<div class="max-w-lg mx-auto bg-white p-8 rounded shadow-lg border-t-8 border-gray-600 text-center mt-10">
    <h2 class="text-3xl font-bold mb-4 text-gray-800">Registro Finalizado</h2>
    <p class="text-gray-600 mb-6">El periodo de registro para la actividad <span class="font-bold">"{{ $event->title }}"</span> ha concluido. Gracias por tu interés.</p>
</div>
@endsection