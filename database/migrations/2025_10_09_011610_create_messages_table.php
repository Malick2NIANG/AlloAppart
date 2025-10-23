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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();

            // L'utilisateur qui envoie le message (souvent un client)
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Le bailleur destinataire du message
            $table->foreignId('bailleur_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // L’appartement concerné par le message
            $table->foreignId('appartement_id')
                  ->constrained('appartements')
                  ->onDelete('cascade');

            // Contenu du message
            $table->text('contenu');

            // Statut de lecture
            $table->boolean('lu')->default(false);

            // Index pour améliorer la recherche de messages
            $table->index(['user_id', 'bailleur_id', 'appartement_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
