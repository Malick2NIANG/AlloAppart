<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Appartement;
use App\Models\User;

class AppartementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 🔍 On récupère tous les bailleurs existants
        $bailleurs = User::where('role', 'bailleur')->get();

        // 🏘️ Quelques exemples d’appartements types
        $appartementsExemples = [
            [
                'titre' => 'Studio moderne à Mermoz',
                'description' => 'Studio entièrement équipé, climatisé, avec balcon.',
                'adresse' => 'Mermoz Pyrotechnie',
                'ville' => 'Dakar',
                'prix' => 150000,
                'chambres' => 1,
                'salles_de_bain' => 1,
                'surface' => 35,
            ],
            [
                'titre' => 'Appartement F3 à Yoff',
                'description' => 'Bel appartement avec vue sur mer, proche de toutes commodités.',
                'adresse' => 'Yoff Virage',
                'ville' => 'Dakar',
                'prix' => 300000,
                'chambres' => 3,
                'salles_de_bain' => 2,
                'surface' => 80,
            ],
            [
                'titre' => 'F2 à louer à Sacré-Cœur',
                'description' => 'Appartement calme et sécurisé avec parking privé.',
                'adresse' => 'Sacré-Cœur 3',
                'ville' => 'Dakar',
                'prix' => 200000,
                'chambres' => 2,
                'salles_de_bain' => 1,
                'surface' => 60,
            ],
        ];

        // 🏠 Pour chaque bailleur, on assigne quelques appartements
        foreach ($bailleurs as $bailleur) {
            foreach ($appartementsExemples as $data) {
                Appartement::create([
                    'user_id' => $bailleur->id,
                    'titre' => $data['titre'],
                    'description' => $data['description'],
                    'adresse' => $data['adresse'],
                    'ville' => $data['ville'],
                    'prix' => $data['prix'],
                    'chambres' => $data['chambres'],
                    'salles_de_bain' => $data['salles_de_bain'],
                    'surface' => $data['surface'],
                    'statut' => 'disponible',
                ]);
            }
        }
    }
}
