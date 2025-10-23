<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Publicite;
use App\Models\User;
use App\Models\Appartement;
use App\Models\Paiement;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PubliciteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 🔍 On récupère les bailleurs et leurs paiements
        $bailleurs = User::where('role', 'bailleur')->get();

        foreach ($bailleurs as $bailleur) {
            $paiements = Paiement::where('user_id', $bailleur->id)
                                 ->where('type', 'publicite')
                                 ->get();

            // Chaque bailleur aura 1 à 2 publicités
            $nbPublicites = rand(1, 2);
            $appartements = Appartement::where('user_id', $bailleur->id)->get();

            if ($appartements->isEmpty()) continue;

            for ($i = 1; $i <= $nbPublicites; $i++) {
                $appartement = $appartements->random();

                // On choisit éventuellement un paiement lié
                $paiement = $paiements->random() ?? null;

                Publicite::create([
                    'user_id'        => $bailleur->id,
                    'appartement_id' => $appartement->id,
                    'paiement_id'    => $paiement?->id,
                    'titre'          => "Publicité pour {$appartement->titre}",
                    'description'    => "Annonce sponsorisée pour mettre en avant le logement situé à {$appartement->adresse}.",
                    'image'          => "https://picsum.photos/seed/" . Str::random(5) . "/800/400",
                    'date_debut'     => Carbon::now()->subDays(rand(0, 10)),
                    'date_fin'       => Carbon::now()->addDays(rand(5, 15)),
                    'statut'         => collect(['en_attente', 'active', 'expiree'])->random(),
                ]);
            }
        }
    }
}
