<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $table = 'messages';

    protected $fillable = [
        'user_id',
        'bailleur_id',
        'appartement_id',
        'contenu',
        'lu',
    ];

    /**
     * Relation : message envoyé par un utilisateur (client)
     */
    public function expediteur()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relation : message reçu par un bailleur
     */
    public function destinataire()
    {
        return $this->belongsTo(User::class, 'bailleur_id');
    }

    /**
     * Relation : message lié à un appartement spécifique
     */
    public function appartement()
    {
        return $this->belongsTo(Appartement::class);
    }

    /**
     * Scope : récupérer les messages non lus
     */
    public function scopeNonLus($query)
    {
        return $query->where('lu', false);
    }

    /**
     * Scope : récupérer les messages d’un bailleur donné
     */
    public function scopePourBailleur($query, $bailleurId)
    {
        return $query->where('bailleur_id', $bailleurId);
    }

    /**
     * Scope : récupérer les messages d’un utilisateur (client)
     */
    public function scopePourUtilisateur($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
