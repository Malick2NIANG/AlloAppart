<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Les champs autorisés à être remplis en masse (mass assignment)
     */
    protected $fillable = [
        'nom',
        'email',
        'telephone',
        'role',       // 'admin' | 'bailleur' | 'client'
        'password',
        'adresse',
    ];

    /**
     * Désactivation de toute protection supplémentaire
     * (corrige le problème "Field 'nom' doesn't have a default value")
     */
    protected $guarded = [];

    /**
     * Champs cachés lorsqu'on convertit l'objet en tableau ou JSON
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Conversion automatique des champs
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    /* =======================================================
     |                     RELATIONS
     ======================================================= */

    // Appartements publiés par le bailleur
    public function appartements()
    {
        return $this->hasMany(Appartement::class, 'user_id');
    }

    // Favoris de l'utilisateur (client)
// Favoris de l'utilisateur (appartements qu'il a ajoutés en favoris)
    public function favoris()
    {
        return $this->belongsToMany(Appartement::class, 'favoris')
            ->withTimestamps();
    }


    // Messages envoyés (côté client)
    public function messages()
    {
        return $this->hasMany(Message::class, 'user_id');
    }

    // Messages reçus (côté bailleur)
    public function messagesRecus()
    {
        return $this->hasMany(Message::class, 'bailleur_id');
    }

    // Paiements effectués par le bailleur
    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }

    // Publicités créées par le bailleur
    public function publicites()
    {
        return $this->hasMany(Publicite::class);
    }
    /* =======================================================
    |                     SCOPES
    ======================================================= */

    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopeBailleurs($query)
    {
        return $query->where('role', 'bailleur');
    }

    public function scopeClients($query)
    {
        return $query->where('role', 'client');
    }


    /* =======================================================
     |                     HELPERS
     ======================================================= */

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isBailleur(): bool
    {
        return $this->role === 'bailleur';
    }

    public function isClient(): bool
    {
        return $this->role === 'client';
    }
    public function avis()
    {
        return $this->hasMany(Avis::class);
    }

}
