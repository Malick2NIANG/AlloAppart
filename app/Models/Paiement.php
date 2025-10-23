<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;

    protected $table = 'paiements';

    protected $fillable = [
        'user_id',
        'montant',
        'type',
        'methode',
        'reference',
        'statut',
    ];

    protected $casts = [
        'montant' => 'decimal:2',
    ];

    /**
     * Relation : un paiement appartient à un utilisateur (bailleur)
     */
    public function bailleur()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /* =======================================================
     |                     SCOPES
     ======================================================= */

    // Paiements réussis
    public function scopeEffectues($query)
    {
        return $query->where('statut', 'effectue');
    }

    // Paiements en attente
    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }

    // Filtrer par type (ex: abonnement)
    public function scopeDeType($query, $type)
    {
        return $query->where('type', $type);
    }
}
