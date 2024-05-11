<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Binome;
use App\Models\Enseignant;
use App\Models\Jury;

class JuryController extends Controller
{
    public function constituerJurys(Request $request)
    {
        // Récupération des données du formulaire
        $annee = $request->input('annee');
        $filiere = $request->input('filiere');

        // Sélection des enseignants en fonction de l'année et de la filière
        $enseignants = Enseignant::where('annee', $annee)
            ->where('filiere', $filiere)
            ->get();

        // Sélection de la colonne "maitre" dans la table "binome"
        $maitres_noms = Binome::where('annee', $annee)
            ->where('filiere', $filiere)
            ->pluck('maitre')
            ->toArray();

        // Suppression des doublons parmi les maîtres
        $maitres_noms_uniques = array_unique($maitres_noms);

        // Constitution des jurys
        $jurys = [];
        // Liste des enseignants déjà utilisés comme présidents
        $presidents_utilises = [];
        foreach ($maitres_noms_uniques as $nom) {
            // Sélection du rapporteur
            $rapporteur = Enseignant::where('nom', $nom)->first();
        
            // Compteur pour suivre le nombre de jurys où le rapporteur est impliqué
            $nombre_de_jurys_rapporteur = 0;
        
            for ($i = 0; $i < 2; $i++) {
                // Vérifie si le rapporteur est déjà rapporteur dans deux jurys
                if ($nombre_de_jurys_rapporteur >= 2) {
                    break; // Sort de la boucle si le rapporteur est déjà rapporteur dans deux jurys
                }
        
                // Sélection du président
                $president = null;
                foreach ($enseignants as $enseignant) {
                    // Vérifie si l'enseignant n'est pas déjà utilisé comme président
                    if (!in_array($enseignant->nom, $presidents_utilises) && $enseignant->nom != $rapporteur->nom) {
                        // Vérifie si l'enseignant a un grade éligible
                        if (in_array($enseignant->grade, ['PT', 'MC', 'MA', 'Dr'])) {
                            // Vérifie si l'enseignant n'a pas déjà été président dans deux jurys
                            $nb_jurys_president = Jury::where('president', $enseignant->nom)
                                                        ->whereYear('created_at', '=', $annee)
                                                        ->count();
                            if ($nb_jurys_president <= 2) {
                                $president = $enseignant;
                                $presidents_utilises[] = $enseignant->nom; // Ajoute le président utilisé à la liste
                                break; // Sort de la boucle après avoir trouvé un président admissible
                            }
                        }
                    }
                }
        
                // Si aucun président admissible n'est trouvé, prenez celui avec le grade le plus bas
                if (is_null($president)) {
                    $president = $enseignants->sortBy(function ($enseignant) {
                        return ['PT' => 1, 'MC' => 2, 'MA' => 3, 'Dr' => 4, 'Master' => 5][$enseignant->grade];
                    })->first();
                }
        
                // Sélection de l'examinateur
                $examinateurs_potentiels = $enseignants
                    ->whereNotIn('nom', [$president->nom, $rapporteur->nom])
                    ->sortBy(function ($enseignant) {
                        return [ 
                            'PT' => 2,
                            'MC' => 2,
                            'MA' => 3,
                            'Dr' => 4,
                            'Master' => 5
                        ][$enseignant->grade];
                    });

                if ($examinateurs_potentiels->isEmpty()) {
                    continue; // Pas assez d'examinateurs potentiels, passer au prochain rapporteur
                }
                $examinateur = $examinateurs_potentiels->first();

                // Création du jury
                $jury = new Jury();
                $jury->president = $president->nom;
                $jury->examinateur = $examinateur->nom;
                $jury->rapporteur = $rapporteur->nom;
                $jury->save();
                $jurys[] = $jury;

                // Incrémentation du nombre de jurys où le rapporteur est impliqué
                $nombre_de_jurys_rapporteur++;
            }
        }

        // Nombre de jurys à constituer
        $nombre_de_jurys = count($maitres_noms_uniques) * 2;

        return response()->json(['jurys' => $jurys, 'nombre_de_jurys' => $nombre_de_jurys]);
    }
}
