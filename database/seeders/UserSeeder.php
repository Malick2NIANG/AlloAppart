<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 🧑‍💼 Administrateur
        User::create([
            'nom' => 'Admin Principal',
            'email' => 'admin@alloappart.sn',
            'telephone' => '770000001',
            'role' => 'admin',
            'password' => Hash::make('admin123'),
            'adresse' => 'Siège AlloAppart, Dakar',
        ]);

        // 🏠 Bailleurs
        $bailleurs = [
            ['nom' => 'Sow', 'email' => 'sow@alloappart.sn', 'telephone' => '770000002', 'adresse' => 'Mermoz'],
            ['nom' => 'Ba', 'email' => 'ba@alloappart.sn', 'telephone' => '770000003', 'adresse' => 'Yoff'],
            ['nom' => 'Diallo', 'email' => 'diallo@alloappart.sn', 'telephone' => '770000004', 'adresse' => 'Sacré-Cœur'],
        ];

        foreach ($bailleurs as $bailleur) {
            User::create([
                'nom' => $bailleur['nom'],
                'email' => $bailleur['email'],
                'telephone' => $bailleur['telephone'],
                'role' => 'bailleur',
                'password' => Hash::make('bailleur123'),
                'adresse' => $bailleur['adresse'],
            ]);
        }

        // 👥 Clients
        $clients = [
            ['nom' => 'Ndiaye', 'email' => 'ndiaye@alloappart.sn', 'telephone' => '770000005'],
            ['nom' => 'Fall', 'email' => 'fall@alloappart.sn', 'telephone' => '770000006'],
            ['nom' => 'Diop', 'email' => 'diop@alloappart.sn', 'telephone' => '770000007'],
        ];

        foreach ($clients as $client) {
            User::create([
                'nom' => $client['nom'],
                'email' => $client['email'],
                'telephone' => $client['telephone'],
                'role' => 'client',
                'password' => Hash::make('client123'),
                'adresse' => 'Dakar',
            ]);
        }
    }
}
