<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Participant;
use App\Http\Requests\StoreParticipantRequest;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function create($uuid)
    {
        $event = Event::where('uuid', $uuid)->firstOrFail();
        return view('participants.create', compact('event'));
    }

    public function store(StoreParticipantRequest $request, $uuid)
    {
        $event = Event::where('uuid', $uuid)->firstOrFail();

        $data = $request->validated();
        $data['event_id'] = $event->id;
        $data['cedula'] = strtoupper($data['cedula']); // Convertir letra a mayúscula

        Participant::create($data);

        return redirect()->back()->with('success', 'Sus datos se han registrado correctamente.');
    }

    public function destroy(Participant $participant)
    {
        $participant->delete();
        return redirect()->back()->with('success', 'El registro del participante ha sido eliminado exitosamente.');
    }
}