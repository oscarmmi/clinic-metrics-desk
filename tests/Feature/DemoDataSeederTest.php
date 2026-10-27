<?php

namespace Tests\Feature;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DemoDataSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeder_creates_80_fake_visits_in_a_fourteen_day_window(): void
    {
        $this->seed();

        $start = today()->subDays(7)->toDateTimeString();
        $end = today()->addDays(6)->endOfDay()->toDateTimeString();

        $this->assertDatabaseCount('appointments', 80);
        $this->assertDatabaseCount('practitioners', 6);
        $this->assertDatabaseMissing('appointments', ['scheduled_at' => null]);
        $this->assertDatabaseMissing('appointments', ['practitioner_id' => null]);
        $this->assertGreaterThanOrEqual($start, Appointment::query()->min('scheduled_at'));
        $this->assertLessThanOrEqual($end, Appointment::query()->max('scheduled_at'));
        $this->assertSame(40, Appointment::query()->where('status', AppointmentStatus::Booked->value)->count());
        $this->assertSame(24, Appointment::query()->where('status', AppointmentStatus::Done->value)->count());
        $this->assertSame(8, Appointment::query()->where('status', AppointmentStatus::NoShow->value)->count());
        $this->assertSame(8, Appointment::query()->where('status', AppointmentStatus::Cancelled->value)->count());
    }
}
