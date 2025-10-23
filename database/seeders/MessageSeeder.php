<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Message;
use App\Models\User;
use App\Models\Appartement;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 🔍 On récupère les clients et les bailleurs
        $clients = User::where('role', 'client')->get();
        $bailleurs = User::where('role', 'bailleur')->get();

        // Pour chaque client, on simule 1 à 2 discussions
        foreach ($clients as $client) {
            $nbDiscussions = rand(1, 2);
            $bailleursChoisis = $bailleurs->random($nbDiscussions);

            foreach ($bailleursChoisis as $bailleur) {
                // 🏠 On prend un appartement du bailleur
                $appartement = Appartement::where('user_id', $bailleur->id)->inRandomOrder()->first();

                if (!$appartement) continue; // sécurité

                // 💬 Messages simulés
                $messages = [
                    [
                        'expediteur' => $client->nom,
                        'contenu' => "Bonjour {$bailleur->nom}, je suis intéressé par votre appartement à {$appartement->adresse}.",
                    ],
                    [
                        'expediteur' => $bailleur->nom,
                        'contenu' => "Bonjour {$client->nom}, merci de votre intérêt ! Il est toujours disponible.",
                    ],
                    [
                        'expediteur' => $client->nom,
                        'contenu' => "Parfait, est-il possible de le visiter demain ?",
                    ],
                ];

                foreach ($messages as $msg) {
                    Message::create([
                        'user_id' => $client->id,          // client
                        'bailleur_id' => $bailleur->id,    // bailleur
                        'appartement_id' => $appartement->id,
                        'contenu' => $msg['contenu'],
                        'lu' => $msg['expediteur'] === $client->nom, // le message du client est lu directement
                    ]);
                }
            }
        }
    }
}
