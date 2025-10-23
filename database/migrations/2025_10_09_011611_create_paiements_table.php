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
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();

            // Bailleur ayant effectué le paiement
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Montant payé
            $table->decimal('montant', 10, 2);

            // Type de paiement : abonnement, publicité, etc.
            $table->enum('type', ['abonnement', 'publicite', 'autre'])->default('autre');

            // Méthode utilisée : Orange Money, Wave, carte, etc.
            $table->string('methode')->default('orange_money');

            // Référence unique de la transaction
            $table->string('reference')->unique();

            // Statut du paiement
            $table->enum('statut', ['en_attente', 'effectue', 'echoue'])->default('en_attente');

            // Index combiné utile pour suivi rapide
            $table->index(['user_id', 'type', 'statut']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
