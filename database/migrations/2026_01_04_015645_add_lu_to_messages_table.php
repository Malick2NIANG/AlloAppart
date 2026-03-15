<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            // Ajoute "lu" seulement si elle n'existe pas déjà
            if (!Schema::hasColumn('messages', 'lu')) {
                $table->boolean('lu')->default(false)->after('status');
                $table->index(['user_id', 'bailleur_id', 'appartement_id', 'lu'], 'messages_fast_lookup');
            }
        });

        // Sync: status -> lu (pour les anciennes lignes)
        if (Schema::hasColumn('messages', 'status') && Schema::hasColumn('messages', 'lu')) {
            DB::statement("UPDATE messages SET lu = CASE WHEN status = 'lu' THEN 1 ELSE 0 END");
        }
    }

    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            if (Schema::hasColumn('messages', 'lu')) {
                $table->dropIndex('messages_fast_lookup');
                $table->dropColumn('lu');
            }
        });
    }
};
