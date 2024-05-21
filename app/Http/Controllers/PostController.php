<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Binome;
use App\Models\Enseignant;
use App\Models\Jury;
use App\Models\salle;
use PhpParser\Node\Stmt\Else_;

class PostController extends Controller
{
    public function index()
    {
        $planifications = $this->fetchPlanifications();
        $binomes = $this->fetchBinomes();
        $enseignants = $this->fetchEnseignants();
        $salles = salle::where('annee', '=', 2024)
            ->get();
        return view('layouts.index', compact('planifications', 'binomes', 'enseignants', 'salles'));
    }

    public function filter(Request $request)
    {
        // Sinon, récupérer les valeurs de la requête
        $annee = $request->input('annee');
        $filiere = $request->input('filiere');
        

         // Récupérer les planifications selon les filtres
         $planifications = Jury::where('filiere', $filiere)
         ->whereYear('created_at', $annee)
         ->orderBy('date_soutenance', 'asc')
         ->orderBy('heure_soutenance', 'asc')
         ->orderBy('rapporteur')
         ->get();

        $binomes = $this->fetchBinomes();
        $enseignants = $this->fetchEnseignants();
        $salles = salle::where('annee', '=', 2024)
            ->get();
        return view('layouts.index', compact('planifications', 'binomes', 'enseignants', 'salles'));
    }
    

    private function fetchPlanifications()
    {
            $annee = date('Y');
            $filiere = 'GT-TIC';

        // Récupérer les planifications selon les filtres
        $planifications = Jury::where('filiere', $filiere)
            ->whereYear('created_at', $annee)
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
