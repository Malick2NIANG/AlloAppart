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
        Schema::create('image_appartements', function (Blueprint $table) {
            $table->id();

            // Référence à l'appartement concerné
            $table->foreignId('appartement_id')
                  ->constrained('appartements')
                  ->onDelete('cascade');

            // Chemin ou URL de l’image
            $table->string('url');

            // Optionnel : position d’affichage (ex. 1 = image principale)
            $table->integer('position')->default(1);

            // Image principale (utile pour l’affichage du catalogue)
            $table->boolean('principale')->default(false);

            // Index pour accélérer les requêtes sur l’appartement
            $table->index('appartement_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('image_appartements');
    }
};
