<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index()
    {
        return response()->json(Video::orderBy('ordre')->orderByDesc('created_at')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'url'         => 'required|string',
            'ordre'       => 'nullable|integer',
        ]);

        // Liens courts TikTok non supportés (vt.tiktok.com, vm.tiktok.com)
        if (preg_match('/(?:vt|vm)\.tiktok\.com/', $request->url)) {
            return response()->json([
                'error' => 'Lien court TikTok non supporté. Ouvre la vidéo TikTok, appuie sur "..." → "Copier le lien" pour obtenir le lien complet.'
            ], 422);
        }

        ['platform' => $platform, 'video_id' => $videoId] = Video::detectPlatform($request->url);

        if (!$platform) {
            return response()->json(['error' => 'Lien YouTube ou TikTok invalide'], 422);
        }

        $video = Video::create([
            'titre'       => $request->titre,
            'description' => $request->description,
            'url'         => $request->url,
            'video_id'    => $videoId,
            'platform'    => $platform,
            'ordre'       => $request->ordre ?? 0,
        ]);

        return response()->json($video, 201);
    }

    public function destroy($id)
    {
        Video::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}
