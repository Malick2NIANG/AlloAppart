<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Appartement;
use App\Models\ImageAppartement;

class RealImageSeeder extends Seeder
{
    public function run(): void
    {
        // Images libres (Unsplash). On ajoute des params pour forcer un JPEG "propre".
        $baseImages = [
            'https://images.unsplash.com/photo-1505691723518-36a5ac3be353',
            'https://images.unsplash.com/photo-1600585154340-be6161a56a0c',
            'https://images.unsplash.com/photo-1572120360610-d971b9b78825',
            'https://images.unsplash.com/photo-1501183638710-841dd1904471',
            'https://images.unsplash.com/photo-1560448075-bb485b4b1a2e',
            'https://images.unsplash.com/photo-1615874959474-d609969a20ed',
            'https://images.unsplash.com/photo-1598300056393-4e8c7a9a65b9',
            'https://images.unsplash.com/photo-1613977257361-815b3cbb1121',
        ];

        // On force un format jpeg optimisé côté CDN Unsplash
        $images = array_map(
            fn ($u) => $u.'?auto=format&fit=crop&w=1600&q=80',
            $baseImages
        );

        // S'assure que le dossier cible existe
        Storage::disk('public')->makeDirectory('appartements');

        $appartements = Appartement::all();

        if ($appartements->isEmpty()) {
            $this->command->warn('⚠️ Aucun appartement trouvé. Lance d’abord AppartementSeeder.');
            return;
        }

        foreach ($appartements as $app) {
            $current = $app->images()->count();
            $targetMin = 3; // on veut au moins 3 images par appartement
            $needed = max(0, $targetMin - $current);

            if ($needed === 0) {
                $this->command->line("• Appartement #{$app->id} : déjà {$current} image(s) ✅");
                continue;
            }

            $this->command->line("→ Appartement #{$app->id} : {$current} image(s). Ajout de {$needed}…");

            // On pioche aléatoirement le nombre manquant
            $selection = collect($images)->shuffle()->take($needed);

            foreach ($selection as $url) {
                try {
                    $response = Http::timeout(20)->retry(2, 500)->get($url);

                    if (! $response->successful()) {
                        $this->command->warn("  - Skip: HTTP ".$response->status()." pour {$url}");
                        continue;
                    }

                    $contentType = $response->header('content-type', '');
                    if (! str_starts_with($contentType, 'image/')) {
                        $this->command->warn("  - Skip: content-type inattendu ({$contentType}) pour {$url}");
                        continue;
                    }

                    $filename = 'appartements/'.Str::uuid()->toString().'.jpg';
                    Storage::disk('public')->put($filename, $response->body());

                    ImageAppartement::create([
                        'appartement_id' => $app->id,
                        'url' => $filename,
                        'position' => 1,
                    ]);

                    $this->command->line("  ✓ Ajout: {$filename}");
                } catch (\Throwable $e) {
                    $this->command->warn("  - Erreur: ".$e->getMessage());
                }
            }

            $this->command->info("✅ Appartement #{$app->id} : images complétées");
        }

        $this->command->info('🎨 Toutes les images manquantes ont été ajoutées avec succès !');
    }
}
