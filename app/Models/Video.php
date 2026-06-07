<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = ['titre', 'description', 'url', 'video_id', 'platform', 'ordre'];

    // Détecte la plateforme et extrait l'ID
    public static function detectPlatform(string $url): array
    {
        // YouTube : youtube.com/watch?v=ID, youtu.be/ID, youtube.com/shorts/ID
        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|shorts\/|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $url, $m)) {
            return ['platform' => 'youtube', 'video_id' => $m[1]];
        }

        // TikTok : tiktok.com/@user/video/ID
        if (preg_match('/tiktok\.com\/@[\w.]+\/video\/(\d+)/', $url, $m)) {
            return ['platform' => 'tiktok', 'video_id' => $m[1]];
        }

        return ['platform' => null, 'video_id' => null];
    }
}
