<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['titre', 'description', 'emoji', 'date_event', 'actif'];

    protected $casts = [
        'date_event' => 'datetime',
        'actif'      => 'boolean',
    ];
}
