<?php

namespace App\Http\Controllers;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\Practitioner;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(): Response
    {
        $today = today();
        $weekStart = now()->startOfWeek(Carbon::MONDAY)->startOfDay();
        $weekEnd = now()->endOfWeek(Carbon::SUNDAY)->endOfDay();

        $todayStatusCounts = Appointment::query()
            ->whereDate('scheduled_at', $today)
            ->selectRaw('status, COUNT(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status');

        $todayStatuses = collect(AppointmentStatus::cases())
            ->mapWithKeys(fn (AppointmentStatus $status) => [
                $status->value => (int) ($todayStatusCounts[$status->value] ?? 0),
            ]);

        $weeklyAppointments = Appointment::query()
            ->whereBetween('scheduled_at', [$weekStart, $weekEnd])
            ->whereIn('status', [
                AppointmentStatus::Booked->value,
                AppointmentStatus::Done->value,
                AppointmentStatus::NoShow->value,
            ])
            ->count();

        $weeklyNoShows = Appointment::query()
            ->whereBetween('scheduled_at', [$weekStart, $weekEnd])
            ->where('status', AppointmentStatus::NoShow->value)
            ->count();

        $weeklyResolvedAppointments = Appointment::query()
            ->whereBetween('scheduled_at', [$weekStart, $weekEnd])
            ->whereIn('status', [
                AppointmentStatus::Done->value,
                AppointmentStatus::NoShow->value,
            ])
            ->count();

        $practitionerAppointments = Practitioner::query()
            ->withCount(['appointments as appointments_count' => fn (Builder $query) => $query
                ->whereBetween('scheduled_at', [$weekStart, $weekEnd])
                ->where('status', '!=', AppointmentStatus::Cancelled->value)])
            ->orderBy('name')
            ->get(['id', 'name'])
            ->map(fn (Practitioner $practitioner) => [
                'id' => $practitioner->id,
                'name' => $practitioner->name,
                'appointments_count' => $practitioner->appointments_count,
            ]);

        return Inertia::render('Dashboard', [
            'today' => $today->toDateString(),
            'todayAppointments' => $todayStatuses->sum(),
            'todayStatuses' => $todayStatuses,
            'weeklyAppointments' => $weeklyAppointments,
            'weeklyNoShows' => $weeklyNoShows,
            'weeklyResolvedAppointments' => $weeklyResolvedAppointments,
            'weeklyNoShowRate' => $weeklyResolvedAppointments === 0
                ? 0
                : round(($weeklyNoShows / $weeklyResolvedAppointments) * 100, 1),
            'practitionerAppointments' => $practitionerAppointments,
        ]);
    }
}
