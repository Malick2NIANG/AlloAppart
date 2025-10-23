<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            AppartementSeeder::class,
            ImageAppartementSeeder::class,
            FavoriSeeder::class,
            MessageSeeder::class,
            PaiementSeeder::class,
            PubliciteSeeder::class,
            RealImageSeeder::class, // <-- ajouté ici
        ]);
    }

}
