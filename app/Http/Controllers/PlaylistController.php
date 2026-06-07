<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use App\Models\PlaylistItem;
use Illuminate\Http\Request;

class PlaylistController extends Controller
{
    // GET /api/playlists
    public function index()
    {
        return response()->json(
            Playlist::orderBy('ordre')->orderByDesc('created_at')
                ->withCount('items')
                ->get()
        );
    }

    // GET /api/playlists/{id}
    public function show($id)
    {
        $playlist = Playlist::with('items')->findOrFail($id);
        return response()->json($playlist);
    }

    // POST /api/playlists
    public function store(Request $request)
    {
        $request->validate([
            'titre'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_url'   => 'nullable|string',
            'ordre'       => 'nullable|integer',
        ]);

        $playlist = Playlist::create($request->only('titre', 'description', 'image_url', 'ordre'));
        return response()->json($playlist, 201);
    }

    // DELETE /api/playlists/{id}
    public function destroy($id)
    {
        Playlist::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }

    // POST /api/playlists/{id}/items
    public function addItem(Request $request, $id)
    {
        $request->validate([
            'titre'     => 'required|string|max:255',
            'artiste'   => 'nullable|string|max:255',
            'audio_url' => 'required|string',
            'ordre'     => 'nullable|integer',
        ]);

        $playlist = Playlist::findOrFail($id);
        $item = $playlist->items()->create($request->only('titre', 'artiste', 'audio_url', 'ordre'));
        return response()->json($item, 201);
    }

    // DELETE /api/playlists/items/{itemId}
    public function removeItem($itemId)
    {
        PlaylistItem::findOrFail($itemId)->delete();
        return response()->json(['success' => true]);
    }
}
