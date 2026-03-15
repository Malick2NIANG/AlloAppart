<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable implements MustVerifyEmailContract
{
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    protected $fillable = [
        'nom',
        'email',
        'telephone',
        'role',       // admin | bailleur | client
        'password',
        'adresse',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    protected $casts = [
        'password' => 'hashed',
        'email_verified_at' => 'datetime',
        'two_factor_confirmed_at' => 'datetime',
    ];

    /**
     * ✅ Compat starter-kit: certaines vues utilisent auth()->user()->name
     * alors que ta colonne s'appelle "nom".
     */
    public function getNameAttribute(): string
    {
        return (string) ($this->attributes['nom'] ?? '');
    }

    /**
     * ✅ Utilisé par ton sidebar: auth()->user()->initials()
     */
    public function initials(): string
    {
        $name = trim($this->name);
        if ($name === '') return '??';

        $parts = preg_split('/\s+/', $name);
        $first = mb_substr($parts[0] ?? '', 0, 1);
        $second = mb_substr($parts[1] ?? ($parts[0] ?? ''), 0, 1);

        return mb_strtoupper($first . $second);
    }

    /* ===================== RELATIONS ===================== */

    public function appartements()
    {
        return $this->hasMany(Appartement::class, 'user_id');
    }

    public function favoris()
    {
        return $this->belongsToMany(Appartement::class, 'favoris')->withTimestamps();
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'user_id');
    }

    public function messagesRecus()
    {
        return $this->hasMany(Message::class, 'bailleur_id');
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }

    public function publicites()
    {
        return $this->hasMany(Publicite::class);
    }

    public function avis()
    {
        return $this->hasMany(Avis::class);
    }

    /* ===================== SCOPES ===================== */

    public function scopeAdmins($query)   { return $query->where('role', 'admin'); }
    public function scopeBailleurs($query){ return $query->where('role', 'bailleur'); }
    public function scopeClients($query)  { return $query->where('role', 'client'); }

    /* ===================== HELPERS ===================== */

    public function isAdmin(): bool    { return $this->role === 'admin'; }
    public function isBailleur(): bool { return $this->role === 'bailleur'; }
    public function isClient(): bool   { return $this->role === 'client'; }
}
