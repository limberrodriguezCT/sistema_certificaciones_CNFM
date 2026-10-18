<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Requests\StoreEventRequest;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::latest()->get();
        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(StoreEventRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('template_path')) {
            $data['template_path'] = $request->file('template_path')->store('templates', 'public');
        }

        $event = Event::create($data);

        return redirect()->route('events.map', $event)->with('success', 'Evento creado. Ahora marcá dónde irá el nombre.');
    }

    public function show(Event $event)
    {
        $participants = $event->participants()->latest()->get();
        return view('events.show', compact('event', 'participants'));
    }

    public function mapCoordinates(Event $event)
    {
        return view('events.map', compact('event'));
    }

    public function saveCoordinates(Request $request, Event $event)
    {
        $request->validate([
            'x_coord' => 'required|numeric',
            'y_coord' => 'required|numeric'
        ], [
            'x_coord.required' => 'Falta la coordenada X.',
            'y_coord.required' => 'Falta la coordenada Y.'
        ]);

        $event->update([
            'x_coord' => $request->x_coord,
            'y_coord' => $request->y_coord
        ]);

        return redirect()->route('events.show', $event)->with('success', 'Coordenadas guardadas correctamente.');
    }
}