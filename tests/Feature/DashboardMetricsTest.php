<?php

namespace Tests\Feature;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\Practitioner;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class DashboardMetricsTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_reports_today_status_totals_and_practitioner_counts(): void
    {
        $this->actingAs(User::factory()->create());
        $practitioner = Practitioner::factory()->create(['name' => 'Jordan Avery']);

        Appointment::factory()->for($practitioner)->create([
            'scheduled_at' => today()->setTime(9, 0),
            'status' => AppointmentStatus::Booked,
        ]);
        Appointment::factory()->for($practitioner)->create([
            'scheduled_at' => today()->setTime(10, 0),
            'status' => AppointmentStatus::Done,
        ]);
        Appointment::factory()->for($practitioner)->create([
            'scheduled_at' => today()->setTime(11, 0),
            'status' => AppointmentStatus::Cancelled,
        ]);

        $this->get(route('dashboard'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Dashboard')
                ->where('todayAppointments', 3)
                ->where('todayStatuses.booked', 1)
                ->where('todayStatuses.done', 1)
                ->where('todayStatuses.no_show', 0)
                ->where('todayStatuses.cancelled', 1)
                ->where('practitionerAppointments.0.name', 'Jordan Avery')
                ->where('practitionerAppointments.0.appointments_count', 2));
    }

    public function test_weekly_no_show_rate_uses_completed_and_no_show_appointments_only(): void
    {
        $this->actingAs(User::factory()->create());
        $practitioner = Practitioner::factory()->create();
        $thisWeek = now()->startOfWeek()->setTime(9, 0);

        foreach ([
            AppointmentStatus::Booked,
            AppointmentStatus::Done,
            AppointmentStatus::NoShow,
            AppointmentStatus::NoShow,
            AppointmentStatus::Cancelled,
            AppointmentStatus::Cancelled,
        ] as $index => $status) {
            Appointment::factory()->for($practitioner)->create([
                'scheduled_at' => $thisWeek->copy()->addHours($index),
                'status' => $status,
            ]);
        }

        $this->get(route('dashboard'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->where('weeklyAppointments', 4)
                ->where('weeklyNoShows', 2)
                ->where('weeklyResolvedAppointments', 3)
                ->where('weeklyNoShowRate', 66.7));
    }
}
