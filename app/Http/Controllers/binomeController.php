<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Binome;
use App\Models\enseignant;
use App\Models\salle;
use Maatwebsite\Excel\Facades\Excel;

class BinomeController extends Controller
{
    public function importExcel(Request $request)
    {
        try {
            $request->validate([
                'etudiant_file' => 'required|mimes:xls,xlsx',
                'enseignant_file' => 'required|mimes:xls,xlsx',
                'salle_file' => 'required|mimes:xls,xlsx',
            ]);



            $etudiantfile = $request->file('etudiant_file');
            $enseignantfile = $request->file('enseignant_file');
            $sallefile = $request->file('salle_file');

            // Enregistrer le fichier dans le dossier public/uploads
            $etudiantfileName = time() . '_' . $etudiantfile->getClientOriginalName();
            $etudiantfile->move(public_path('uploads'), $etudiantfileName);
            // Lire les données du fichier Excel
            $dataEtudiant = Excel::toArray([], public_path('uploads/' . $etudiantfileName));

            // Enregistrer le fichier dans le dossier public/uploads
            $enseignantfileName = time() . '_' . $enseignantfile->getClientOriginalName();
            $enseignantfile->move(public_path('uploads'), $enseignantfileName);

            // Lire les données du fichier Excel
            $dataEnseignant = Excel::toArray([], public_path('uploads/' . $enseignantfileName));

            // Enregistrer le fichier dans le dossier public/uploads
            $sallefileName = time() . '_' . $sallefile->getClientOriginalName();
            $sallefile->move(public_path('uploads'), $sallefileName);

            // Lire les données du fichier Excel
            $dataSalle = Excel::toArray([], public_path('uploads/' . $sallefileName));

            if ($etudiantfile) {



                // Assurez-vous que le fichier Excel a des données

                $firstRow = true; // Variable pour suivre si c'est la première ligne

                // Parcourir les lignes du fichier Excel
                foreach ($dataEtudiant[0] as $rowEtu) {
                    // Ignorer la première ligne
                    if ($firstRow) {
                        $firstRow = false;
                        continue;
                    }

                    // Vérifiez que la ligne a toutes les colonnes nécessaires
                    if (count($rowEtu) >= 6) {
                        // Créer un nouvel enregistrement Binome
                        try {
                            Binome::create([
                                'binome1' => $rowEtu[0],
                                'binome2' => $rowEtu[1],
                                'theme' => $rowEtu[2],
                                'maitre' => $rowEtu[3],
                                'filiere' => $rowEtu[4],
                                'annee' => $rowEtu[5]
                            ]);
                        } catch (\Exception $e) {
                            return back()->with('error', "Une erreur est subvenue $e");
                        }
                    }
                }
            }


            if ($enseignantfile) {


                $firstRowEn = true; // Variable pour suivre si c'est la première ligne

                // Parcourir les lignes du fichier Excel
                foreach ($dataEnseignant[0] as $rowEn) {
                    // Ignorer la première ligne
                    if ($firstRowEn) {
                        $firstRowEn = false;

                        continue;
                    }

                    // Vérifiez que la ligne a toutes les colonnes nécessaires
                    if (count($rowEn) >= 5) {
                        try {
                            // Créer un nouvel enregistrement Binome
                            enseignant::create([
                                'nom' => $rowEn[0],
                                'email' => $rowEn[1],
                                'grade' => $rowEn[2],
                                'filiere' => $rowEn[3],
                                'annee' => $rowEn[4]
                            ]);
                        } catch (\Exception $e) {
                            return back()->with('error', "Une erreur est subvenue $e");
                        }
                    }
                }
            }


            if ($sallefile) {

                $firstRowS = true; // Variable pour suivre si c'est la première ligne

                // Parcourir les lignes du fichier Excel
                foreach ($dataSalle[0] as $rowS) {
                    // Ignorer la première ligne
                    if ($firstRowS) {
                        $firstRowS = false;
                        continue;
                    }

                    // Vérifiez que la ligne a toutes les colonnes nécessaires
                    if (count($rowS) >= 2) {
                        try {
                            // Créer un nouvel enregistrement Binome
                            salle::create([
                                'salle' => $rowS[0],
                                'annee' => $rowS[1]
                            ]);
                        } catch (\Exception $e) {
                            return back()->with('error', "Une erreur est subvenue $e");
                        }
                    }
                }
            }
            return back()->with('success', "Importation réussie.");
        } catch (\Exception $e) {
            return back()->with('error', "Une erreur est subvenue $e");
        }
    }
}
