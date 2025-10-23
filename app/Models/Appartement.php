<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appartement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'titre',
        'description',
        'adresse',
        'ville',
        'prix',
        'chambres',
        'salles_de_bain',
        'surface',
        'statut',
        'views',
    ];

    protected $casts = [
        'prix' => 'decimal:2',
    ];

    /* =============================
     |         RELATIONS
     ============================= */

    // ✅ Lien avec le bailleur (utilisateur)
    public function bailleur()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ✅ Lien avec les images de l'appartement
    public function images()
    {
        return $this->hasMany(ImageAppartement::class, 'appartement_id');
    }

    // ✅ Lien avec les favoris
// ✅ Lien avec les utilisateurs qui ont mis en favori cet appartement
    public function fans()
    {
        return $this->belongsToMany(User::class, 'favoris')
            ->withTimestamps();
    }


    // ✅ Lien avec les messages
    public function messages()
    {
        return $this->hasMany(Message::class, 'appartement_id');
    }

    // ✅ Lien avec les publicités
    public function publicites()
    {
        return $this->hasMany(Publicite::class, 'appartement_id');
    }
    public function avis()
    {
        return $this->hasMany(Avis::class);
    }

}
