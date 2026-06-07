<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = ['titre', 'description', 'url', 'video_id', 'ordre'];

    /**
     * Extrait l'ID TikTok depuis un lien complet.
     * Ex: https://www.tiktok.com/@user/video/7123456789 → 7123456789
     */
    public static function extractTiktokId(string $url): ?string
    {
        if (preg_match('/tiktok\.com\/@[\w.]+\/video\/(\d+)/', $url, $m)) {
            return $m[1];
        }
        return null;
    }
}
