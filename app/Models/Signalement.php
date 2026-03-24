<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Signalement extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'description',
        'statut',
        'date_signalement',
        'category_id',
        'citoyen_id',
        'agent_municipal_id',
    ];



    public function category(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Category::class);
    }

    public function citoyen(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'citoyen_id');
    }

    public function agentMunicipal(): BelongsTo
    {
        return $this->belongsTo(\App\Models\AgentMunicipal::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(\App\Models\Photo::class);
    }

    public function historiqueStatuts(): HasMany
    {
        return $this->hasMany(\App\Models\HistoriqueStatut::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(\App\Models\Notification::class);
    }
}
