<?php

namespace Tests\Feature;

use App\Enums\AppointmentStatus;
use App\Http\Requests\StoreAppointmentRequest;
use App\Models\Appointment;
use App\Models\Practitioner;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class AppointmentModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_appointment_belongs_to_a_practitioner_and_casts_its_status(): void
    {
        $practitioner = Practitioner::factory()->create();
        $appointment = Appointment::factory()->for($practitioner)->create([
            'status' => AppointmentStatus::NoShow,
        ]);

        $this->assertSame($practitioner->id, $appointment->practitioner->id);
        $this->assertSame(AppointmentStatus::NoShow, $appointment->status);
        $this->assertCount(1, $practitioner->appointments);
    }

    public function test_appointment_validation_accepts_only_supported_statuses_and_practitioners(): void
    {
        $practitioner = Practitioner::factory()->create();
        $rules = (new StoreAppointmentRequest)->rules();

        $valid = Validator::make([
            'practitioner_id' => $practitioner->id,
            'scheduled_at' => now()->toDateTimeString(),
            'status' => AppointmentStatus::Booked->value,
        ], $rules);

        $invalid = Validator::make([
            'practitioner_id' => 999,
            'scheduled_at' => 'not-a-date',
            'status' => 'pending',
        ], $rules);

        $this->assertTrue($valid->passes());
        $this->assertTrue($invalid->fails());
        $this->assertSame(AppointmentStatus::values(), ['booked', 'done', 'no_show', 'cancelled']);
    }
}
