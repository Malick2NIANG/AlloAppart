<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publicite extends Model
{
    use HasFactory;

    protected $table = 'publicites';

    protected $fillable = [
        'user_id',
        'appartement_id',
        'paiement_id',
        'titre',
        'description',
        'image',
        'date_debut',
        'date_fin',
        'statut',
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
    ];

    /* =======================================================
     |                     RELATIONS
     ======================================================= */

    // Créateur de la publicité (bailleur)
    public function bailleur()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Appartement mis en avant
    public function appartement()
    {
        return $this->belongsTo(Appartement::class);
    }

    // Paiement associé à la publicité
    public function paiement()
    {
        return $this->belongsTo(Paiement::class);
    }

    /* =======================================================
     |                     SCOPES
     ======================================================= */

    // Publicités actives
    public function scopeActives($query)
    {
        return $query->where('statut', 'active');
    }

    // Publicités expirées
    public function scopeExpirees($query)
    {
        return $query->where('statut', 'expiree');
    }

    // Publicités en attente
    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }

    // Publicités en cours (entre deux dates)
    public function scopeEnCours($query)
    {
        return $query->whereDate('date_debut', '<=', now())
                     ->whereDate('date_fin', '>=', now());
    }
}
