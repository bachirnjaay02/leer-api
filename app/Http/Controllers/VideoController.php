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
     * Résout n'importe quel lien TikTok (court ou long) via l'API oEmbed de TikTok
     * et retourne l'ID numérique de la vidéo.
     */
    private function getTiktokVideoId(string $url): ?string
    {
        // Lien complet → extraction directe
        $id = Video::extractTiktokId($url);
        if ($id) return $id;

        // Lien court (vt.tiktok.com, vm.tiktok.com) → oEmbed API
        try {
            $res = Http::timeout(8)->get('https://www.tiktok.com/oembed', [
                'url' => $url,
            ]);
            if ($res->ok()) {
                $data = $res->json();
                // embed_product_id contient l'ID numérique
                if (!empty($data['embed_product_id'])) {
                    return (string) $data['embed_product_id'];
                }
                // Fallback : extraire depuis author_url + HTML
                if (!empty($data['html']) && preg_match('/data-video-id="(\d+)"/', $data['html'], $m)) {
                    return $m[1];
                }
            }
        } catch (\Exception $e) {}

        return null;
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'url'         => 'required|string',
            'ordre'       => 'nullable|integer',
        ]);

        $videoId = $this->getTiktokVideoId($request->url);

        if (!$videoId) {
            return response()->json([
                'error' => 'Lien TikTok invalide. Copie le lien depuis l\'app TikTok et réessaie.'
            ], 422);
        }

        $video = Video::create([
            'titre'       => $request->titre,
            'description' => $request->description,
            'url'         => $request->url,
            'video_id'    => $videoId,
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
