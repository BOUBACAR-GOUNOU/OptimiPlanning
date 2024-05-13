<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('planifications', function (Blueprint $table) {
            // Création de la colonne id_planification comme clé primaire auto-incrémentée
            $table->id();

            // Création de la colonne id_binome comme clé étrangère liée à la table 'binomes'
            $table->unsignedBigInteger('id_binome');

            // Création de la colonne id_jury comme clé étrangère liée à la table 'jurys'
            // Création de la colonne id_binome comme clé étrangère liée à la table 'binomes'
            $table->unsignedBigInteger('id_jury');

            // Création de la colonne heure pour stocker l'heure de la planification
            $table->time('heure');

            // Création de la colonne date pour stocker la date de la planification
            $table->date('date');

            // Création de la colonne id_salle comme clé étrangère liée à la table 'salles'
            $table->string('salle');

            // Création des colonnes created_at et updated_at pour le suivi temporel
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Suppression de la table 'planifications' si elle existe
        Schema::dropIfExists('planifications');
    }
};
