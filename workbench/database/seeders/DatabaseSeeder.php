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
        Species::insert([
            ['id' => 1, 'name' => 'Cat'],
            ['id' => 2, 'name' => 'Dog'],
            ['id' => 3, 'name' => 'Horse'],
            ['id' => 4, 'name' => 'Bird'],
            ['id' => 5, 'name' => 'Rabbit'],
            ['id' => 6, 'name' => 'Reptile'],
            ['id' => 7, 'name' => 'Fish'],
            ['id' => 8, 'name' => 'Rodent'],
        ]);

        Breed::insert([
            // Cats
            ['id' => 1, 'name' => 'American Shorthair', 'species_id' => 1],
            ['id' => 2, 'name' => 'Maine Coon', 'species_id' => 1],
            ['id' => 3, 'name' => 'Siamese', 'species_id' => 1],
            ['id' => 4, 'name' => 'Persian', 'species_id' => 1],
            ['id' => 5, 'name' => 'Bengal', 'species_id' => 1],
            // Dogs
            ['id' => 100, 'name' => 'Beagle', 'species_id' => 2],
            ['id' => 101, 'name' => 'Corgi', 'species_id' => 2],
            ['id' => 102, 'name' => 'Labrador', 'species_id' => 2],
            ['id' => 103, 'name' => 'German Shepherd', 'species_id' => 2],
            ['id' => 104, 'name' => 'Poodle', 'species_id' => 2],
            ['id' => 105, 'name' => 'Bulldog', 'species_id' => 2],
            // Horses
            ['id' => 200, 'name' => 'Arabian', 'species_id' => 3],
            ['id' => 201, 'name' => 'Thoroughbred', 'species_id' => 3],
            ['id' => 202, 'name' => 'Mustang', 'species_id' => 3],
            ['id' => 203, 'name' => 'Clydesdale', 'species_id' => 3],
            // Birds
            ['id' => 300, 'name' => 'Parakeet', 'species_id' => 4],
            ['id' => 301, 'name' => 'Cockatiel', 'species_id' => 4],
            ['id' => 302, 'name' => 'Macaw', 'species_id' => 4],
            // Rabbits
            ['id' => 400, 'name' => 'Holland Lop', 'species_id' => 5],
            ['id' => 401, 'name' => 'Netherland Dwarf', 'species_id' => 5],
            // Reptiles
            ['id' => 500, 'name' => 'Leopard Gecko', 'species_id' => 6],
            ['id' => 501, 'name' => 'Bearded Dragon', 'species_id' => 6],
            ['id' => 502, 'name' => 'Corn Snake', 'species_id' => 6],
            // Fish
            ['id' => 600, 'name' => 'Betta', 'species_id' => 7],
            ['id' => 601, 'name' => 'Goldfish', 'species_id' => 7],
            ['id' => 602, 'name' => 'Guppy', 'species_id' => 7],
            // Rodents
            ['id' => 700, 'name' => 'Hamster', 'species_id' => 8],
            ['id' => 701, 'name' => 'Guinea Pig', 'species_id' => 8],
            ['id' => 702, 'name' => 'Gerbil', 'species_id' => 8],
        ]);

        // Named anchor owners (kept for recognisable demo data + existing ids).
        Owner::insert([
            ['id' => 1, 'name' => 'Ben', 'date_of_birth' => '1982-04-07'],
            ['id' => 2, 'name' => 'Tom', 'date_of_birth' => '1985-08-22'],
            ['id' => 3, 'name' => 'Mark', 'date_of_birth' => '1991-03-26'],
            ['id' => 4, 'name' => 'Jake', 'date_of_birth' => '1985-11-12'],
        ]);
        Owner::factory()->count(40)->create();

        // Named anchor pets pinned to the top via a low sort_order.
        Pet::insert([
            ['name' => 'Cartman', 'age' => 22, 'species_id' => 1, 'breed_id' => 2, 'owner_id' => 1, 'last_visit' => '2023-01-04', 'favorite_color' => '#000000', 'is_vaccinated' => true, 'sort_order' => 1],
            ['name' => 'Tux', 'age' => 8, 'species_id' => 1, 'breed_id' => 1, 'owner_id' => 3, 'last_visit' => '2023-02-04', 'favorite_color' => '#FF0000', 'is_vaccinated' => true, 'sort_order' => 2],
            ['name' => 'May', 'age' => 2, 'species_id' => 2, 'breed_id' => 101, 'owner_id' => 4, 'last_visit' => null, 'favorite_color' => '#00FF00', 'is_vaccinated' => false, 'sort_order' => 3],
            ['name' => 'Ben', 'age' => 5, 'species_id' => 3, 'breed_id' => 200, 'owner_id' => 1, 'last_visit' => '2023-04-04', 'favorite_color' => '#0000FF', 'is_vaccinated' => true, 'sort_order' => 4],
            ['name' => 'Chico', 'age' => 7, 'species_id' => 3, 'breed_id' => 202, 'owner_id' => 2, 'last_visit' => '2023-05-04', 'favorite_color' => '#FFFFFF', 'is_vaccinated' => false, 'sort_order' => 5],
        ]);

        // Bulk demo data: enough for multi-page pagination and varied filters,
        // plus a handful of "strays" (no owner / no last visit) for null cases.
        Pet::factory()->count(145)->create();
        Pet::factory()->count(6)->stray()->create();
    }
}
