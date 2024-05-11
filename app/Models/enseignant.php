<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class enseignant extends Model
{
    protected $fillable = ['nom', 'numero', 'grade','filiere', 'annee'];

}
