<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jury extends Model
{
    use HasFactory;

     /**
     * Indique les attributs pouvant être mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'president', 'examinateur', 'rapporteur'
    ];

    /**
     * Obtient toutes les planifications associées à ce jury.
     */
    public function planifications()
    {
        return $this->hasMany(Planification::class, 'id_jury');
    }

}


   

