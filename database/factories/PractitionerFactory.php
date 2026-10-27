<?php

namespace Database\Factories;

use App\Models\Practitioner;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Practitioner> */
class PractitionerFactory extends Factory
{
    protected $model = Practitioner::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
        ];
    }
}
