<?php

namespace Database\Seeders;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\Practitioner;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::query()->firstOrNew(['email' => 'admin@clinicmetrics.test']);
        $admin->forceFill([
            'name' => 'Clinic Admin',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ])->save();

        $missingPractitioners = 6 - Practitioner::query()->count();

        if ($missingPractitioners > 0) {
            Practitioner::factory()->count($missingPractitioners)->create();
        }

        if (! Appointment::query()->exists()) {
            $practitioners = Practitioner::query()->get();
            $start = now()->startOfDay()->subDays(7);
            $end = now()->endOfDay()->addDays(6);

            foreach (range(0, 79) as $index) {
                $status = match ($index % 10) {
                    0, 1, 2, 3, 4 => AppointmentStatus::Booked,
                    5, 6, 7 => AppointmentStatus::Done,
                    8 => AppointmentStatus::NoShow,
                    default => AppointmentStatus::Cancelled,
                };

                Appointment::factory()->create([
                    'practitioner_id' => $practitioners->random()->id,
                    'scheduled_at' => fake()->dateTimeBetween($start, $end),
                    'status' => $status,
                ]);
            }
        }
    }
}
