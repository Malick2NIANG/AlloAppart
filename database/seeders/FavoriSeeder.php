<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Favori;
use App\Models\User;
use App\Models\Appartement;

class FavoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 🔍 On récupère tous les clients
        $clients = User::where('role', 'client')->get();

        // 🔍 Et tous les appartements disponibles
        $appartements = Appartement::all();

        foreach ($clients as $client) {
            // Chaque client ajoute 2 à 4 appartements en favoris
            $nbFavoris = rand(2, 4);
            $appartementsChoisis = $appartements->random($nbFavoris);

            foreach ($appartementsChoisis as $appart) {
                Favori::firstOrCreate([
                    'user_id' => $client->id,
                    'appartement_id' => $appart->id,
                ]);
            }
        }
    }
}
