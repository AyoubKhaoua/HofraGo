<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoriqueStatut extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'ancien_statut',
        'nouveau_statut',
        'date_changement',
        'signalement_id',
    ];



    public function signalement(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Signalement::class);
    }
}
