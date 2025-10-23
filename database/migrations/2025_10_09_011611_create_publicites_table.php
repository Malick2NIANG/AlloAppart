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
        Schema::create('publicites', function (Blueprint $table) {
            $table->id();

            // Bailleur ayant créé la publicité
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Appartement concerné (facultatif : pub générale ou ciblée)
            $table->foreignId('appartement_id')
                  ->nullable()
                  ->constrained('appartements')
                  ->onDelete('cascade');

            // Détails de la publicité
            $table->string('titre');
            $table->text('description')->nullable();
            $table->string('image')->nullable();

            // Durée et période de la publicité
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();

            // Statut : active, expirée, suspendue, en attente de paiement
            $table->enum('statut', ['en_attente', 'active', 'expiree', 'suspendue'])->default('en_attente');

            // Lien éventuel avec un paiement
            $table->foreignId('paiement_id')
                  ->nullable()
                  ->constrained('paiements')
                  ->onDelete('set null');

            // Index pour améliorer les requêtes de filtrage
            $table->index(['user_id', 'appartement_id', 'statut']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publicites');
    }
};
