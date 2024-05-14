<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Binome;
use App\Models\Enseignant;
use App\Models\Jury;

class PostController extends Controller
{
    public function index()
    {
        $planifications = $this->fetchPlanifications();
    $binomes = $this->fetchBinomes();
    $enseignants = $this->fetchEnseignants();

    return view('layouts.index', compact('planifications', 'binomes', 'enseignants'));
    }


    private function fetchPlanifications()
    {
        $annee = date('Y');
        $filieres = 'GT-TIC';
        $planifications = Jury::where('filiere', $filieres)
            ->whereYear('created_at', '=', $annee)
            ->orderBy('date_soutenance', 'asc')
            ->orderBy('heure_soutenance', 'asc')
            ->orderBy('rapporteur')
            ->get();

        return $planifications;
    }

    private function fetchBinomes()
    {
        // Logique de récupération des binômes depuis la base de données
        $binomes = Binome::all();

        return $binomes;
    }

    private function fetchEnseignants()
    {
        // Logique de récupération des enseignants depuis la base de données
        $enseignants = Enseignant::all();

        return $enseignants;
    }



    public function importation()
    {
        return view('layouts.importer_fichiers');
    }

    public function constitution()
    {
        return view('layouts.constituer_jury');
    }

    public function generation()
    {
        return view('layouts.generer_planning');
    }
}
