<?php

namespace Tests\Feature;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\Practitioner;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class AppointmentListTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_from_the_appointment_list(): void
    {
        $this->get(route('appointments.index'))
            ->assertRedirect(route('login'));
    }

    public function test_appointment_list_filters_by_date_and_status_and_keeps_pagination(): void
    {
        $this->actingAs(User::factory()->create());
        $practitioner = Practitioner::factory()->create(['name' => 'Jordan Avery']);

        Appointment::factory()->count(13)->for($practitioner)->create([
            'scheduled_at' => '2026-10-15 10:00:00',
            'status' => AppointmentStatus::Booked,
        ]);
        Appointment::factory()->for($practitioner)->create([
            'scheduled_at' => '2026-10-16 10:00:00',
            'status' => AppointmentStatus::NoShow,
        ]);

        $this->get(route('appointments.index', [
            'start_date' => '2026-10-15',
            'end_date' => '2026-10-15',
            'status' => AppointmentStatus::Booked->value,
        ]))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('appointments/Index')
                ->has('appointments.data', 12)
                ->where('appointments.total', 13)
                ->where('appointments.last_page', 2)
                ->where('appointments.data.0.practitioner', 'Jordan Avery')
                ->where('appointments.data.0.status', 'booked')
                ->where('filters.start_date', '2026-10-15')
                ->where('filters.end_date', '2026-10-15')
                ->where('filters.status', 'booked'));
    }

    public function test_invalid_appointment_filters_are_rejected(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get(route('appointments.index', [
            'start_date' => '2026-10-20',
            'end_date' => '2026-10-10',
            'status' => 'arrived',
        ]))
            ->assertSessionHasErrors(['end_date', 'status']);
    }
}
