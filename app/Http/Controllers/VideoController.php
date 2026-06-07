<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    // GET /api/videos
    public function index()
    {
        return response()->json(Video::orderBy('ordre')->orderByDesc('created_at')->get());
    }

    // POST /api/videos
    public function store(Request $request)
    {
        $request->validate([
            'titre'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'youtube_url' => 'required|string',
            'ordre'       => 'nullable|integer',
        ]);

        $youtubeId = Video::extractYoutubeId($request->youtube_url);
        if (!$youtubeId) {
            return response()->json(['error' => 'Lien YouTube invalide'], 422);
        }

        $video = Video::create([
            'titre'       => $request->titre,
            'description' => $request->description,
            'youtube_url' => $request->youtube_url,
            'youtube_id'  => $youtubeId,
            'ordre'       => $request->ordre ?? 0,
        ]);

        return response()->json($video, 201);
    }

    // DELETE /api/videos/{id}
    public function destroy($id)
    {
        Video::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}
