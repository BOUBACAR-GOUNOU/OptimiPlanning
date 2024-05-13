<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Planification;
use App\Models\Binome;
use App\Models\Jury;
use App\Models\Salle;
use Carbon\Carbon;

class PlanificationController extends Controller
{
    public function genererProgrammation(Request $request)
    {
        // Récupération des données du formulaire
        $annee = $request->annee;
        $filiere = $request->filiere;
        $dateDebut = $request->date_debut;
        $dateFin = $request->date_fin;
        $heureDebut = $request->heure_debut;
        $heureFin = $request->heure_fin;
        $duree = $request->duree;
        $decalage = $request->decalage;

        // Sélection de tous les jurys disponibles
        $jurys = Jury::all();

        // Sélection de toutes les salles disponibles
        $salles = Salle::all();

        // Sélection des binômes de cette année et de cette filière
        $binomes = Binome::where('annee', $annee)->where('filiere', $filiere)->get();
        $nombreBinomes = count($binomes);

        for ($i = 0; $i < $nombreBinomes; $i++) {
            // Vérifier si une planification existe pour ce binôme
            $planificationExistante = Planification::where('id_binome', $binomes[$i]->id)->exists();

            // Si aucune planification n'existe, en créer une
            if (!$planificationExistante) {
                // Générer des plages horaires disponibles pour ce binôme
                $plagesHoraires = $this->generatePlagesHoraires($dateDebut, $dateFin, $heureDebut, $heureFin, $duree, $decalage);

                // Planifier la soutenance pour ce binôme
                $this->planifierSoutenancePourBinome($binomes[$i], $plagesHoraires, $jurys, $salles);
            }
        }

        return response()->json(['message' => 'La programmation des soutenances a été générée avec succès.']);
    }

    private function planifierSoutenancePourBinome($binome, $plagesHoraires, $jurys, $salles)
    {
        // Choix d'une plage horaire disponible pour ce binôme
        $plageHoraire = $this->selectPlageHoraireDisponible($plagesHoraires);

        // Assurez-vous qu'une plage horaire est disponible
        if ($plageHoraire) {
            // Choix d'un jury disponible pour ce binôme
            $jury = $this->selectJuryPourBinome($jurys, $binome);

            // Assurez-vous qu'un jury est disponible
            if ($jury) {
                // Choix d'une salle disponible pour ce binôme
                $salle = $this->selectSalleDisponible($plageHoraire, $salles);

                // Assurez-vous qu'une salle est disponible
                if ($salle) {
                    // Enregistrement de la planification dans la base de données pour ce binôme
                    Planification::create([
                        'id_binome' => $binome->id,
                        'id_jury' => $jury->id,
                        'heure' => $plageHoraire['heure'],
                        'date' => $plageHoraire['date'],
                        'salle' => $salle->salle
                    ]);

                    // Suppression de la plage horaire utilisée de la liste des plages horaires
                    $this->removePlageHoraire($plagesHoraires, $plageHoraire);
                }
            }
        } else {
            // Si aucune plage horaire n'est disponible pour ce binôme, vous pouvez gérer cela ici.
            // Par exemple, vous pouvez enregistrer un message de journalisation ou ignorer ce binôme.
        }
    }

    // Fonction pour générer les plages horaires disponibles
    private function generatePlagesHoraires($dateDebut, $dateFin, $heureDebut, $heureFin, $duree, $decalage)
    {
        // Initialisation des plages horaires
        $plagesHoraires = [];

        // Convertir les dates de début et de fin en objets Carbon
        $dateDebut = Carbon::parse($dateDebut);
        $dateFin = Carbon::parse($dateFin);

        // Convertir les heures de début et de fin en objets Carbon
        $heureDebut = Carbon::parse($heureDebut);
        $heureFin = Carbon::parse($heureFin);

        // Boucle sur les dates de début à la date de fin
        while ($dateDebut->lessThanOrEqualTo($dateFin)) {
            // Initialisation de l'heure de début pour chaque jour
            $heureActuelle = $heureDebut;

            // Tant que l'heure actuelle est inférieure ou égale à l'heure de fin
            while ($heureActuelle->lessThanOrEqualTo($heureFin)) {
                // Ajouter la plage horaire à la liste des plages horaires
                $plagesHoraires[] = [
                    'date' => $dateDebut->format('Y-m-d'),
                    'heure' => $heureActuelle->format('H:i:s')
                ];

                // Ajouter la durée en minutes à l'heure actuelle
                $heureActuelle->addMinutes($duree);

                // Ajouter le décalage en minutes à l'heure actuelle
                $heureActuelle->addMinutes($decalage);
            }

            // Passer à la date suivante
            $dateDebut->addDay();
        }

        return $plagesHoraires;
    }

    // Fonction pour choisir une plage horaire disponible
    private function selectPlageHoraireDisponible($plagesHoraires)
    {
        // Parcourir les plages horaires disponibles
        foreach ($plagesHoraires as $key => $plageHoraire) {
            // Vérifier si la plage horaire est occupée
            $planificationExistante = Planification::where('date', $plageHoraire['date'])
                ->where('heure', $plageHoraire['heure'])
                ->exists();

            // Si la plage horaire n'est pas occupée, la retourner
            if (!$planificationExistante) {
                // Retirer la plage horaire de la liste des plages horaires disponibles
                unset($plagesHoraires[$key]);
                return $plageHoraire;
            }
        }

        // Si aucune plage horaire disponible n'a été trouvée, retourner null
        return null;
    }

    // Fonction pour choisir une salle disponible
    private function selectSalleDisponible($plageHoraire, $salles)
    {
        // Parcourir chaque salle
        foreach ($salles as $salle) {
            // Vérifier si la salle est disponible à l'heure actuelle
            if ($plageHoraire !== null) {
                // Vérifier si la salle est déjà utilisée à cette plage horaire
                $planificationExistante = Planification::where('salle', $salle->salle)
                    ->where('date', $plageHoraire['date'])
                    ->where('heure', $plageHoraire['heure'])
                    ->exists();

                // Si la salle est disponible, la retourner
                if (!$planificationExistante) {
                    return $salle;
                }
            }
        }

        // Si aucune salle disponible n'a été trouvée, retourner null
        return null;
    }

    // Fonction pour choisir un jury pour un binôme
    private function selectJuryPourBinome($jurys, $binome)
    {
        // Parcourir tous les jurys disponibles
        foreach ($jurys as $jury) {
            // Si le rapporteur du jury correspond au maitre du binôme, retourner ce jury
            if ($jury->rapporteur === $binome->maitre) {
                return $jury;
            }
        }

        // Si aucun jury n'est disponible pour le binôme, retourner null
        return null;
    }

    // Fonction pour supprimer une plage horaire de la liste des plages horaires disponibles
    private function removePlageHoraire(&$plagesHoraires, $plageHoraire)
    {
        // Supprimer la plage horaire utilisée de la liste des plages horaires
        foreach ($plagesHoraires as $key => $plage) {
            if ($plage['date'] === $plageHoraire['date'] && $plage['heure'] === $plageHoraire['heure']) {
                unset($plagesHoraires[$key]);
                break;
            }
        }
    }
}
