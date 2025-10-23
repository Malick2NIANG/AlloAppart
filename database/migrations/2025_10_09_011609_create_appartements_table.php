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
        Schema::create('appartements', function (Blueprint $table) {
            $table->id();
            
            // Clé étrangère : propriétaire (bailleur)
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            
            // Informations générales
            $table->string('titre');
            $table->text('description')->nullable();
            $table->string('adresse');
            $table->string('ville')->default('Dakar');
            
            // Détails de l'appartement
            $table->decimal('prix', 10, 2);
            $table->integer('chambres')->default(1);
            $table->integer('salles_de_bain')->default(1);
            $table->integer('surface')->nullable();

            // Statut de disponibilité
            $table->enum('statut', ['disponible', 'occupé'])->default('disponible');

            // Dates de création / modification
            // Index pour accélérer les recherches par ville et statut
            $table->index(['ville', 'statut']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appartements');
    }
};
