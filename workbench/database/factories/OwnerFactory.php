<?php

namespace Workbench\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Workbench\App\Models\Owner;

/**
 * @extends Factory<Owner>
 */
class OwnerFactory extends Factory
{
    protected $model = Owner::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'date_of_birth' => fake()->dateTimeBetween('-70 years', '-18 years')->format('Y-m-d'),
        ];
    }
}
