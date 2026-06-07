<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = ['titre', 'description', 'youtube_url', 'youtube_id', 'ordre'];

    // Extrait l'ID YouTube depuis n'importe quel format d'URL
    public static function extractYoutubeId(string $url): string
    {
        preg_match('/(?:youtube\.com\/(?:watch\?v=|shorts\/|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $url, $m);
        return $m[1] ?? '';
    }
}
