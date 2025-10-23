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
        Schema::create('users', function (Blueprint $table) {
            // ✅ Moteur InnoDB (important pour les relations et contraintes)
            $table->engine = 'InnoDB';

            // Informations principales
            $table->id();
            $table->string('nom');
            $table->string('email')->unique();
            $table->string('telephone')->nullable();

            // Rôle de l’utilisateur
            $table->enum('role', ['admin', 'bailleur', 'client'])->default('client')->index();

            // Authentification
            $table->string('password');
            $table->string('adresse')->nullable();
            $table->rememberToken();

            // Dates de création / mise à jour
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
