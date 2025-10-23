<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Paiement;
use App\Models\User;
use Illuminate\Support\Str;

class PaiementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 🔍 On récupère les bailleurs
        $bailleurs = User::where('role', 'bailleur')->get();

        foreach ($bailleurs as $bailleur) {
            // Chaque bailleur aura 2 à 3 paiements
            $nbPaiements = rand(2, 3);

            for ($i = 1; $i <= $nbPaiements; $i++) {
                Paiement::create([
                    'user_id'   => $bailleur->id,
                    'montant'   => rand(20000, 100000),
                    'type'      => collect(['abonnement', 'publicite', 'autre'])->random(),
                    'methode'   => collect(['orange_money', 'wave', 'carte'])->random(),
                    'reference' => strtoupper(Str::random(10)),
                    'statut'    => collect(['effectue', 'en_attente', 'echoue'])->random(),
                ]);
            }
        }
    }
}
