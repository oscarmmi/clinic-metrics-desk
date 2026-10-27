<?php

namespace App\Http\Requests;

use App\Enums\AppointmentStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, array<int, mixed>> */
    public function rules(): array
    {
        return [
            'practitioner_id' => ['required', 'integer', Rule::exists('practitioners', 'id')],
            'scheduled_at' => ['required', 'date'],
            'status' => ['required', Rule::enum(AppointmentStatus::class)],
        ];
    }
}
