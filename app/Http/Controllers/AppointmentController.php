<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppointmentIndexRequest;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Builder;
use Inertia\Inertia;
use Inertia\Response;

class AppointmentController extends Controller
{
    public function index(AppointmentIndexRequest $request): Response
    {
        $filters = $request->validated();

        $appointments = Appointment::query()
            ->with('practitioner:id,name')
            ->when($filters['start_date'] ?? null, fn (Builder $query, string $date) => $query
                ->whereDate('scheduled_at', '>=', $date))
            ->when($filters['end_date'] ?? null, fn (Builder $query, string $date) => $query
                ->whereDate('scheduled_at', '<=', $date))
            ->when($filters['status'] ?? null, fn (Builder $query, string $status) => $query
                ->where('status', $status))
            ->orderByDesc('scheduled_at')
            ->paginate(12)
            ->withQueryString()
            ->through(fn (Appointment $appointment) => [
                'id' => $appointment->id,
                'scheduled_at' => $appointment->scheduled_at->toIso8601String(),
                'status' => $appointment->status->value,
                'practitioner' => $appointment->practitioner->name,
            ]);

        return Inertia::render('appointments/Index', [
            'appointments' => $appointments,
            'filters' => [
                'start_date' => $filters['start_date'] ?? '',
                'end_date' => $filters['end_date'] ?? '',
                'status' => $filters['status'] ?? '',
            ],
        ]);
    }
}
