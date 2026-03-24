<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'is_read',
        'user_id',
        'signalement_id',
    ];



    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function signalement(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Signalement::class);
    }
}
