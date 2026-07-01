<?php

namespace Workbench\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Workbench\App\Models\Breed;
use Workbench\App\Models\Owner;
use Workbench\App\Models\Pet;

/**
 * @extends Factory<Pet>
 */
class PetFactory extends Factory
{
    protected $model = Pet::class;

    public function definition(): array
    {
        // Cache the taxonomy for the duration of a single seeding run so we
        // don't issue a query per pet. Breeds carry the species, so picking a
        // breed keeps species_id / breed_id consistent.
        static $breeds;
        static $ownerIds;

        $breeds ??= Breed::all(['id', 'species_id']);
        $ownerIds ??= Owner::pluck('id')->all();

        $breed = $breeds->random();

        return [
            'name' => fake()->firstName(),
            'age' => fake()->numberBetween(1, 20),
            'species_id' => $breed->species_id,
            'breed_id' => $breed->id,
            'owner_id' => fake()->optional(0.9)->randomElement($ownerIds),
            'last_visit' => fake()->optional(0.8)->dateTimeBetween('-2 years', 'now')?->format('Y-m-d'),
            'favorite_color' => fake()->hexColor(),
            'is_vaccinated' => fake()->boolean(70),
            'sort_order' => fake()->numberBetween(10, 999),
        ];
    }

    /**
     * A pet that has never been to the vet (null last_visit / no owner).
     */
    public function stray(): static
    {
        return $this->state(fn () => [
            'owner_id' => null,
            'last_visit' => null,
            'is_vaccinated' => false,
        ]);
    }
}
