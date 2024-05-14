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
        Schema::create('juries', function (Blueprint $table) {
            // Clé primaire
            $table->id();
            // Colonnes
            $table->string('filiere');
            $table->integer('annee');
            $table->string('president');
            $table->string('examinateur');
            $table->string('rapporteur');
            $table->string('heure_soutenance');
            $table->string('date_soutenance');
            $table->foreignId('id_binome')->references('id')->on('binomes')
            ->constrained()
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->string('salle');
            // Timestamps (facultatif)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('juries');
    }
};
