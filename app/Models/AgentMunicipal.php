<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AgentMunicipal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function signalements(): HasMany
    {
        return $this->hasMany(\App\Models\Signalement::class);
    }
}
