<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    // GET /api/events — retourne tous les événements futurs actifs
    public function index()
    {
        return response()->json(
            Event::where('actif', true)
                ->where('date_event', '>=', now())
                ->orderBy('date_event')
                ->get()
        );
    }

    // GET /api/events/all — admin : tous les événements
    public function all()
    {
        return response()->json(Event::orderBy('date_event')->get());
    }

    // POST /api/events
    public function store(Request $request)
    {
        $request->validate([
            'titre'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'emoji'       => 'nullable|string|max:10',
            'date_event'  => 'required|date',
            'actif'       => 'nullable|boolean',
        ]);

        $event = Event::create([
            'titre'       => $request->titre,
            'description' => $request->description,
            'emoji'       => $request->emoji ?? '🌙',
            'date_event'  => $request->date_event,
            'actif'       => $request->actif ?? true,
        ]);

        return response()->json($event, 201);
    }

    // DELETE /api/events/{id}
    public function destroy($id)
    {
        Event::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}
