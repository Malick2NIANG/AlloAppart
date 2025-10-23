<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favori extends Model
{
    use HasFactory;

    protected $table = 'favoris';

    protected $fillable = [
        'user_id',
        'appartement_id',
    ];

    /**
     * Relation : un favori appartient à un utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation : un favori est lié à un appartement
     */
    public function appartement()
    {
        return $this->belongsTo(Appartement::class);
    }

    /**
     * Scope : récupérer les favoris d’un utilisateur spécifique
     */
    public function scopePourUtilisateur($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
