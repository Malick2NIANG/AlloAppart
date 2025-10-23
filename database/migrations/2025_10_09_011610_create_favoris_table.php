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
        Schema::create('favoris', function (Blueprint $table) {
            $table->id();

            // Utilisateur ayant ajouté le favori
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Appartement ajouté en favori
            $table->foreignId('appartement_id')
                  ->constrained('appartements')
                  ->onDelete('cascade');

            // Empêcher les doublons (même utilisateur / même appartement)
            $table->unique(['user_id', 'appartement_id']);

            // Index individuels pour accélérer les recherches
            $table->index('user_id');
            $table->index('appartement_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favoris');
    }
};
