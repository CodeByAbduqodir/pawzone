<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Backward-compatible demo seeder.
 *
 * This keeps older references working while delegating to the current seed set.
 */
class PetListingSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            PetSeeder::class,
        ]);
    }
}
