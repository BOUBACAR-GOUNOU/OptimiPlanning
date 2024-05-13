<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class binome extends Model
{
    protected $fillable = ['binome1', 'binome2', 'theme', 'maitre', 'filiere', 'annee'];

    public function jury()
    {
        return $this->belongsTo(Jury::class, 'id_jury');
    }
}
