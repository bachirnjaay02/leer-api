<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    protected $fillable = ['titre', 'description', 'image_url', 'ordre'];

    public function items()
    {
        return $this->hasMany(PlaylistItem::class)->orderBy('ordre');
    }
}
