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
        Schema::create('binomes', function (Blueprint $table) {
            $table->id();
            $table->string('binome1');
            $table->string('binome2');
            $table->string('theme');
            $table->string('maitre');
            $table->string('filiere');
            $table->string('annee');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('binomes');
    }
};
