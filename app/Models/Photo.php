<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'uploaded_at',
        'signalement_id',
    ];



    public function signalement(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Signalement::class);
    }
}
