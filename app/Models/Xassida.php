<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Xassida extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id', 'titre', 'titre_arabe', 'auteur',
        'description', 'categorie', 'poeme', 'versets', 'pdfs',
    ];

    protected $casts = [
        'versets' => 'array',
        'pdfs'    => 'array',
    ];
}
