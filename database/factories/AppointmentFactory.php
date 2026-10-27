<?php

namespace Database\Factories;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\Practitioner;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Appointment> */
class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    public function definition(): array
    {
        return [
            'practitioner_id' => Practitioner::factory(),
            'scheduled_at' => fake()->dateTimeBetween('-7 days', '+6 days'),
            'status' => fake()->randomElement(AppointmentStatus::cases()),
        ];
    }
}
