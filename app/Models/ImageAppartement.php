<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageAppartement extends Model
{
    use HasFactory;

    protected $table = 'image_appartements';

    protected $fillable = [
        'appartement_id',
        'url',
        'position',
        'principale',
    ];

    /**
     * Relation : une image appartient à un appartement
     */
    public function appartement()
    {
        return $this->belongsTo(Appartement::class);
    }

    /**
     * Scope : récupérer uniquement les images principales
     */
    public function scopePrincipales($query)
    {
        return $query->where('principale', true);
    }
}
