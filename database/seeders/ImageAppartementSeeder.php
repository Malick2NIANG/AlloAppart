<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ImageAppartement;
use App\Models\Appartement;

class ImageAppartementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 🔍 On récupère tous les appartements existants
        $appartements = Appartement::all();

        // 🖼️ Exemple d’images génériques
        $imagesExemples = [
            'https://picsum.photos/800/600?random=1',
            'https://picsum.photos/800/600?random=2',
            'https://picsum.photos/800/600?random=3',
            'https://picsum.photos/800/600?random=4',
            'https://picsum.photos/800/600?random=5',
        ];

        foreach ($appartements as $appart) {
            // On attribue 2 à 3 images par appartement
            $nbImages = rand(2, 3);

            for ($i = 1; $i <= $nbImages; $i++) {
                ImageAppartement::create([
                    'appartement_id' => $appart->id,
                    'url' => $imagesExemples[array_rand($imagesExemples)],
                    'position' => $i,
                    'principale' => $i === 1, // première image = principale
                ]);
            }
        }
    }
}
