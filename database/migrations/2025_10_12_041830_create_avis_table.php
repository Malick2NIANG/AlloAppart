<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('avis', function (Blueprint $table) {
            $table->id();

            // Si l'avis doit être lié à un utilisateur connecté (sinon ->nullable())
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->foreignId('appartement_id')->constrained()->onDelete('cascade');

            // Note 1..5
            $table->unsignedTinyInteger('note');
            // (Optionnel) contrainte SQL si ton SGBD la supporte
            // $table->check('note BETWEEN 1 AND 5');

            // commentaire facultatif ? (sinon retire ->nullable())
            $table->text('commentaire')->nullable();

            $table->timestamps();

            // Empêche plusieurs avis du même user sur le même appart
            $table->unique(['user_id', 'appartement_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('avis');
    }
};
