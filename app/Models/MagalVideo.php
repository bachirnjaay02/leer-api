<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MagalVideo extends Model
{
    protected $fillable = ['titre', 'file_path', 'url', 'ordre'];
}
