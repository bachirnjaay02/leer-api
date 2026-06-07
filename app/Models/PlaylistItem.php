<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlaylistItem extends Model
{
    protected $fillable = ['playlist_id', 'titre', 'artiste', 'audio_url', 'ordre'];

    public function playlist()
    {
        return $this->belongsTo(Playlist::class);
    }
}
