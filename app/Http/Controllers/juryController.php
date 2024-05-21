<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Binome;
use App\Models\Enseignant;
use App\Models\Jury;
use App\Models\Salle;

class JuryController extends Controller
{
    public function constituerJurys(Request $request)
    {
        try {
            // Récupération de la date envoyée par le formulaire
            $date_envoyee = $request->input('date');

            // Vérification de la validité de la date envoyée
            if (!$date_envoyee || !strtotime($date_envoyee)) {
                return response()->json(['error' => 'La date envoyée est invalide.'], 400);
            }

            // Convertir la date envoyée en timestamp
            $timestamp_date_envoyee = strtotime($date_envoyee);

            // Déterminer la date minimale et maximale pour la soutenance (entre la date envoyée et quatre jours plus tard)
            $date_min = date('Y-m-d', $timestamp_date_envoyee);
            $date_max = date('Y-m-d', strtotime("+4 days", $timestamp_date_envoyee));

            // Générer une date aléatoire dans cet intervalle
            $timestamp_date_soutenance = rand(strtotime($date_min), strtotime($date_max));
            $date_soutenance = date('Y-m-d', $timestamp_date_soutenance);

            // Récupération de l'année à partir de la date actuelle
            $annee = date('Y');

            // Liste des filières dans l'ordre de priorité
            $filieres = ['GT-TIC', 'IIM', 'ELT', 'ELN'];

            // Tableau pour stocker les données des binômes avec leurs jurys et les détails de soutenance
            $binomes_jurys = [];

            foreach ($filieres as $filiere) {
                // Vérifie si des jurys ont déjà été constitués pour cette année et cette filière
                $exist = Jury::where('filiere', $filiere)
                    ->whereYear('created_at', '=', $annee)
                    ->exists();

                // Si des jurys n'ont pas encore été constitués pour cette année et cette filière
                if (!$exist) {
                    // Récupérer tous les binômes de la filière pour cette année
                    $binomes = Binome::where('filiere', $filiere)
                        ->where('annee', $annee)
                        ->get();

                    // Parcours de chaque binôme
                    foreach ($binomes as $binome) {
                        $this->creerJury($binome, $date_soutenance, $binomes_jurys, $annee);
                    }
                } else {
                    return back()->with('error', 'Le jury pour cette année a déjà été constitué');
                }
            }

            // Retourne les binômes avec leurs jurys et les détails de soutenance sous forme de réponse JSON
            return back()->with('success', 'Planification réussie');
        } catch (\Exception $e) {
            // Retourne un message d'erreur en cas d'exception
            return back()->with('error', 'Une erreur a été retenue lors de la constitution des juries');
        }
    }

    // Fonction pour générer une heure de soutenance aléatoire (entre 08:00 et 18:00 par exemple)
    private function generateRandomTime()
    {
        $hour = rand(8, 16); // Entre 08:00 et 17:00
        $minute = rand(0, 5) * 10; // 0, 10, 20, 30, 40, ou 50
        return sprintf('%02d:%02d', $hour, $minute);
    }

    // Fonction pour créer un jury pour un binôme donné
    private function creerJury($binome, $date_soutenance, &$binomes_jurys, $annee)
    {
        // Récupérer les données nécessaires pour créer le jury
        $filiere = $binome->filiere;

        // Sélection des enseignants en fonction de l'année et de la filière
        $enseignants = Enseignant::where('annee', $annee)
            ->where('filiere', $filiere)
            ->get();

        // Sélection du maître du binôme
        $maitre = $binome->maitre;

        // Sélection du rapporteur (même que le maître dans votre logique)
        $rapporteur = $maitre;

        // Sélection du président du jury
        $president = null;
        $presidents_utilises = [];
        foreach ($enseignants as $enseignant) {
            if (!in_array($enseignant->nom, $presidents_utilises) && $enseignant->nom != $rapporteur) {
                $nb_jurys_president = Jury::where('president', $enseignant->nom)
                    ->whereYear('created_at', '=', $annee)
                    ->count();
                if ($nb_jurys_president <= 2 && in_array($enseignant->grade, ['PT', 'MC', 'MA', 'Dr'])) {
                    $president = $enseignant;
                    $presidents_utilises[] = $enseignant->nom;
                    break;
                }
            }
        }

        // Si aucun président admissible n'est trouvé, prenez celui avec le grade le plus bas
        if (is_null($president)) {
            $president = $enseignants->sortBy(function ($enseignant) {
                return ['PT' => 1, 'MC' => 2, 'MA' => 3, 'Dr' => 4, 'Master' => 5][$enseignant->grade];
            })->first();
        }

        // Sélection de l'examinateur du jury
        $examinateur = null;
        $examinateurs_potentiels = $enseignants
            ->whereNotIn('nom', [$president->nom, $rapporteur])
            ->sortBy(function ($enseignant) {
                return [
                    'PT' => 2,
                    'MC' => 2,
                    'MA' => 3,
                    'Dr' => 4,
                    'Master' => 5
                ][$enseignant->grade];
            });

        if (!$examinateurs_potentiels->isEmpty()) {
            $examinateur = $examinateurs_potentiels->first();
        } else {
            // Si aucun examinateur admissible n'est trouvé, prenez celui avec le grade le plus bas
            $examinateur = $enseignants
                ->whereNotIn('nom', [$president->nom, $rapporteur])
                ->sortBy(function ($enseignant) {
                    return [
                        'PT' => 2,
                        'MC' => 2,
                        'MA' => 3,
                        'Dr' => 4,
                        'Master' => 5
                    ][$enseignant->grade];
                })->first();
        }

        // Génération de l'heure de soutenance et de la salle de façon aléatoire
        $heure_soutenance = $this->generateRandomTime();
        $salle = Salle::inRandomOrder()->first();

        // Créer le jury
        $jury = new Jury();
        $jury->filiere = $filiere;
        $jury->annee = $annee;
        $jury->president = $president->nom;
        $jury->examinateur = $examinateur->nom;
        $jury->rapporteur = $rapporteur;
        $jury->heure_soutenance = $heure_soutenance;
        $jury->id_binome = $binome->id;
        $jury->salle = $salle->salle;
        $jury->date_soutenance = $date_soutenance;
        $jury->save();

        // Ajouter les détails du binôme et du jury au tableau
        $binomes_jurys[] = [
            'binome' => $binome->toArray(),
            'jury' => $jury->toArray(),
            'heure_soutenance' => $heure_soutenance,
            'salle' => $salle->salle,
        ];
    }


     // Met à jour une planification dans la base de données
     public function update(Request $request, $id)
     {
         $request->validate([
             'president' => 'required',
             'examinateur' => 'required',
             'date' => 'required',
             'heure' => 'required',
             'salle' => 'required',
         ]);
 
         $planification = Jury::findOrFail($id);
         $planification->president = $request->input('president');
         $planification->examinateur = $request->input('examinateur');
         $planification->date_soutenance = $request->input('date');
         $planification->heure_soutenance = $request->input('heure');
         $planification->salle = $request->input('salle');
         $planification->save();
 
         return redirect()->route('dashboard')->with('success', 'Planification mise à jour avec succès');
     }
}
