<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class VideoController extends Controller
{
    public function index()
    {
        return response()->json(Video::orderBy('ordre')->orderByDesc('created_at')->get());
    }

    /**
     * Résout les liens courts TikTok (vt.tiktok.com, vm.tiktok.com)
     * en suivant les redirections pour obtenir l'URL complète.
     */
    private function resolveUrl(string $url): string
    {
        if (preg_match('/(?:vt|vm)\.tiktok\.com/', $url)) {
            try {
                $response = Http::withOptions([
                    'allow_redirects' => ['max' => 5],
                    'timeout' => 5,
                ])->head($url);
                $effectiveUri = (string) $response->effectiveUri();
                if ($effectiveUri && $effectiveUri !== $url) {
                    return $effectiveUri;
                }
            } catch (\Exception $e) {
                // On garde l'URL originale si ça échoue
            }
        }
        return $url;
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'url'         => 'required|string',
            'ordre'       => 'nullable|integer',
        ]);

        $resolvedUrl = $this->resolveUrl($request->url);
        ['platform' => $platform, 'video_id' => $videoId] = Video::detectPlatform($resolvedUrl);

        if (!$platform) {
            return response()->json(['error' => 'Lien YouTube ou TikTok invalide'], 422);
        }

        $video = Video::create([
            'titre'       => $request->titre,
            'description' => $request->description,
            'url'         => $resolvedUrl,
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
