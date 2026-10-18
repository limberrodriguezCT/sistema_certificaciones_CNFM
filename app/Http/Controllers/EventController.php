<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Requests\StoreEventRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        return redirect()->route('events.map', $event)->with('success', 'Evento creado exitosamente. Por favor, ajustá el diseño.');
    }

    public function show(Event $event)
    {
        $participants = $event->participants()->latest()->get();
        return view('events.show', compact('event', 'participants'));
    }

    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    public function update(StoreEventRequest $request, Event $event)
    {
        $data = $request->validated();

        if ($request->hasFile('template_path')) {
            if ($event->template_path) {
                Storage::disk('public')->delete($event->template_path);
            }
            $data['template_path'] = $request->file('template_path')->store('templates', 'public');
        }

        $event->update($data);

        return redirect()->route('events.map', $event)->with('success', 'Evento actualizado. Revisá que el diseño siga en la posición correcta.');
    }

    public function destroy(Event $event)
    {
        if ($event->template_path) {
            Storage::disk('public')->delete($event->template_path);
        }
        $event->delete();

        return redirect()->route('events.index')->with('success', 'El evento ha sido eliminado permanentemente.');
    }

    public function mapCoordinates(Event $event)
    {
        return view('events.map', compact('event'));
    }

    public function saveCoordinates(Request $request, Event $event)
    {
        $request->validate([
            'x_coord' => 'required|numeric',
            'y_coord' => 'required|numeric',
            'font_family' => 'required|string',
            'font_size' => 'required|numeric',
            'text_color' => 'required|string'
        ]);

        $event->update([
            'x_coord' => $request->x_coord,
            'y_coord' => $request->y_coord,
            'font_family' => $request->font_family,
            'font_size' => $request->font_size,
            'text_color' => $request->text_color
        ]);

        return redirect()->route('events.show', $event)->with('success', 'Diseño y coordenadas guardadas correctamente.');
    }
}