<?php

namespace Workbench\Database\Seeders;

use Illuminate\Database\Seeder;
use Workbench\App\Models\Breed;
use Workbench\App\Models\Owner;
use Workbench\App\Models\Pet;
use Workbench\App\Models\Species;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Owner::insert([
            ['id' => 1, 'name' => 'Ben', 'date_of_birth' => '1982-04-07'],
            ['id' => 2, 'name' => 'Tom', 'date_of_birth' => '1985-08-22'],
            ['id' => 3, 'name' => 'Mark', 'date_of_birth' => '1991-03-26'],
            ['id' => 4, 'name' => 'Jake', 'date_of_birth' => '1985-11-12'],
        ]);

        Species::insert([
            ['id' => 1, 'name' => 'Cat'],
            ['id' => 2, 'name' => 'Dog'],
            ['id' => 3, 'name' => 'Horse'],
            ['id' => 4, 'name' => 'Bird'],
        ]);

        Breed::insert([
            ['id' => 1, 'name' => 'American Shorthair', 'species_id' => 1],
            ['id' => 2, 'name' => 'Maine Coon', 'species_id' => 1],
            ['id' => 100, 'name' => 'Beagle', 'species_id' => 2],
            ['id' => 101, 'name' => 'Corgi', 'species_id' => 2],
            ['id' => 200, 'name' => 'Arabian', 'species_id' => 3],
            ['id' => 202, 'name' => 'Mustang', 'species_id' => 3],
        ]);

        Pet::insert([
            ['name' => 'Cartman', 'age' => 22, 'species_id' => 1, 'breed_id' => 2, 'owner_id' => 1, 'last_visit' => '2023-01-04', 'favorite_color' => '#000000', 'is_vaccinated' => true, 'sort_order' => 1],
            ['name' => 'Tux', 'age' => 8, 'species_id' => 1, 'breed_id' => 1, 'owner_id' => 3, 'last_visit' => '2023-02-04', 'favorite_color' => '#FF0000', 'is_vaccinated' => true, 'sort_order' => 2],
            ['name' => 'May', 'age' => 2, 'species_id' => 2, 'breed_id' => 101, 'owner_id' => 4, 'last_visit' => null, 'favorite_color' => '#00FF00', 'is_vaccinated' => false, 'sort_order' => 3],
            ['name' => 'Ben', 'age' => 5, 'species_id' => 3, 'breed_id' => 200, 'owner_id' => 1, 'last_visit' => '2023-04-04', 'favorite_color' => '#0000FF', 'is_vaccinated' => true, 'sort_order' => 4],
            ['name' => 'Chico', 'age' => 7, 'species_id' => 3, 'breed_id' => 202, 'owner_id' => 2, 'last_visit' => '2023-05-04', 'favorite_color' => '#FFFFFF', 'is_vaccinated' => false, 'sort_order' => 5],
        ]);
    }
}
