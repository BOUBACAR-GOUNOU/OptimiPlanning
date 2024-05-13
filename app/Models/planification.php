<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class planification extends Model
{
    use HasFactory;

    /**
     * Indique les attributs pouvant être mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_binome', 'id_jury', 'heure', 'date','salle'
    ];

    /**
     * Obtient le premier membre du binôme.
     */
    public function id_binome()
    {
        return $this->belongsTo(User::class, 'id_binome');
    }

    /**
     * Obtient le deuxième membre du binôme.
     */
    public function id_jury()
    {
        return $this->belongsTo(User::class, 'id_jury');
    }

    /**
     * Obtient l'enseignant associé au binôme.
     */
    public function heure()
    {
        return $this->belongsTo(maitre::class, 'heure');
    }

    /**
     * Obtient le thème associé au binôme.
     */
    public function date()
    {
        return $this->belongsTo(Theme::class, 'date');
    }

    public function salle()
    {
        return $this->belongsTo(Theme::class, 'salle');
    }
}
