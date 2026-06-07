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

    /**
     * Suit les redirections des liens courts (vt.tiktok.com, vm.tiktok.com, youtu.be, etc.)
     * en utilisant cURL avec un User-Agent navigateur pour éviter les blocages.
     */
    private function resolveShortUrl(string $url): string
    {
        if (!preg_match('/(?:vt|vm)\.tiktok\.com|youtu\.be/', $url)) {
            return $url;
        }

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS      => 5,
            CURLOPT_NOBODY         => true,
            CURLOPT_TIMEOUT        => 8,
            CURLOPT_USERAGENT      => 'Mozilla/5.0 (iPhone; CPU iPhone OS 15_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148',
        ]);
        curl_exec($ch);
        $finalUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        curl_close($ch);

        return $finalUrl ?: $url;
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'url'         => 'required|string',
            'ordre'       => 'nullable|integer',
        ]);

            $resolvedUrl = $this->resolveShortUrl($request->url);
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
