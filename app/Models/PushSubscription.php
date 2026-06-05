<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PushSubscription extends Model
{
    protected $fillable = ['endpoint', 'public_key', 'auth_token', 'prayer_times', 'timezone'];
    protected $casts    = ['prayer_times' => 'array'];
}
