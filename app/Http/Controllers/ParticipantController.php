<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Participant;
use App\Http\Requests\StoreParticipantRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function create($uuid)
    {
        $event = Event::where('uuid', $uuid)->firstOrFail();
        $now = Carbon::now();

        if ($now->lt($event->start_date) || $now->gt($event->end_date)) {
            return view('participants.closed', compact('event'));
        }

        return view('participants.create', compact('event'));
    }

    public function store(StoreParticipantRequest $request, $uuid)
    {
        $event = Event::where('uuid', $uuid)->firstOrFail();
        $now = Carbon::now();

        if ($now->lt($event->start_date) || $now->gt($event->end_date)) {
            return redirect()->route('participants.create', $uuid)->with('error', 'El periodo de registro ha finalizado.');
        }

        $data = $request->validated();
        $data['event_id'] = $event->id;

        Participant::create($data);

        return redirect()->route('participants.create', $uuid)->with('success', 'Tus datos se han registrado correctamente.');
    }
}