<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import {
    CalendarDays,
    CheckCheck,
    CircleAlert,
    Clock3,
    UsersRound,
} from '@lucide/vue';

type AppointmentStatus = 'booked' | 'done' | 'no_show' | 'cancelled';

type PractitionerAppointments = {
    id: number;
    name: string;
    appointments_count: number;
};

const props = defineProps<{
    today: string;
    todayAppointments: number;
    todayStatuses: Record<AppointmentStatus, number>;
    weeklyAppointments: number;
    weeklyNoShows: number;
    weeklyResolvedAppointments: number;
    weeklyNoShowRate: number;
    practitionerAppointments: PractitionerAppointments[];
}>();

const todayLabel = new Intl.DateTimeFormat('en', {
    weekday: 'long',
    month: 'long',
    day: 'numeric',
}).format(new Date(`${props.today}T12:00:00`));

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Overview',
                href: '/dashboard',
            },
        ],
    },
});
</script>

<template>
    <Head title="Overview" />

    <main class="mx-auto w-full max-w-6xl space-y-8 p-6 lg:p-10">
        <header
            class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end"
        >
            <div>
                <p
                    class="text-sm font-medium tracking-wide text-teal-700 dark:text-teal-300"
                >
                    CLINIC OPERATIONS
                </p>
                <h1
                    class="mt-2 text-3xl font-semibold tracking-tight text-slate-950 dark:text-white"
                >
                    Good morning
                </h1>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                    Here’s your appointment overview for {{ todayLabel }}.
                </p>
            </div>
            <div
                class="inline-flex items-center gap-2 self-start rounded-full border border-slate-200 bg-white px-4 py-2 text-sm text-slate-600 shadow-sm sm:self-auto dark:border-slate-800 dark:bg-slate-900 dark:text-slate-300"
            >
                <CalendarDays class="size-4 text-teal-700 dark:text-teal-300" />
                {{ todayAppointments }} appointments today
            </div>
        </header>

        <section
            aria-label="Today's appointments"
            class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4"
        >
            <article
                v-for="metric in [
                    {
                        label: 'Booked',
                        count: todayStatuses.booked,
                        icon: Clock3,
                        tone: 'text-blue-700 bg-blue-50 dark:text-blue-300 dark:bg-blue-950/50',
                    },
                    {
                        label: 'Completed',
                        count: todayStatuses.done,
                        icon: CheckCheck,
                        tone: 'text-emerald-700 bg-emerald-50 dark:text-emerald-300 dark:bg-emerald-950/50',
                    },
                    {
                        label: 'No-shows',
                        count: todayStatuses.no_show,
                        icon: CircleAlert,
                        tone: 'text-rose-700 bg-rose-50 dark:text-rose-300 dark:bg-rose-950/50',
                    },
                    {
                        label: 'Cancelled',
                        count: todayStatuses.cancelled,
                        icon: CalendarDays,
                        tone: 'text-slate-600 bg-slate-100 dark:text-slate-300 dark:bg-slate-800',
                    },
                ]"
                :key="metric.label"
                class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900"
            >
                <div class="flex items-center justify-between">
                    <span
                        class="text-sm font-medium text-slate-600 dark:text-slate-400"
                        >{{ metric.label }}</span
                    >
                    <span
                        :class="[
                            'flex size-10 items-center justify-center rounded-xl',
                            metric.tone,
                        ]"
                        ><component :is="metric.icon" class="size-5"
                    /></span>
                </div>
                <p
                    class="mt-5 text-3xl font-semibold tracking-tight text-slate-950 dark:text-white"
                >
                    {{ metric.count }}
                </p>
                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                    Scheduled for today
                </p>
            </article>
        </section>

        <section class="grid gap-5 lg:grid-cols-[0.8fr_1.2fr]">
            <article
                class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900"
            >
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h2
                            class="font-semibold text-slate-950 dark:text-white"
                        >
                            Weekly no-show rate
                        </h2>
                        <p
                            class="mt-1 text-sm text-slate-500 dark:text-slate-400"
                        >
                            No-shows divided by completed or missed appointments
                        </p>
                    </div>
                    <span
                        class="rounded-full bg-rose-50 px-3 py-1 text-xs font-medium text-rose-700 dark:bg-rose-950/50 dark:text-rose-300"
                        >This week</span
                    >
                </div>
                <p
                    class="mt-8 text-5xl font-semibold tracking-tight text-slate-950 dark:text-white"
                >
                    {{ weeklyNoShowRate
                    }}<span class="text-2xl text-slate-400">%</span>
                </p>
                <div
                    class="mt-5 h-2 overflow-hidden rounded-full bg-slate-100 dark:bg-slate-800"
                >
                    <div
                        class="h-full rounded-full bg-rose-500 transition-all"
                        :style="{
                            width: `${Math.min(weeklyNoShowRate, 100)}%`,
                        }"
                    />
                </div>
                <p class="mt-3 text-sm text-slate-500 dark:text-slate-400">
                    {{ weeklyNoShows }} no-shows among
                    {{ weeklyResolvedAppointments }} resolved appointments
                </p>
            </article>

            <article
                class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900"
            >
                <div
                    class="flex items-center justify-between border-b border-slate-100 px-6 py-5 dark:border-slate-800"
                >
                    <div>
                        <h2
                            class="font-semibold text-slate-950 dark:text-white"
                        >
                            Appointments by practitioner
                        </h2>
                        <p
                            class="mt-1 text-sm text-slate-500 dark:text-slate-400"
                        >
                            This week, excluding cancellations
                        </p>
                    </div>
                    <UsersRound
                        class="size-5 text-teal-700 dark:text-teal-300"
                    />
                </div>
                <ul
                    v-if="practitionerAppointments.length"
                    class="divide-y divide-slate-100 dark:divide-slate-800"
                >
                    <li
                        v-for="practitioner in practitionerAppointments"
                        :key="practitioner.id"
                        class="flex items-center gap-4 px-6 py-4"
                    >
                        <div
                            class="flex size-10 shrink-0 items-center justify-center rounded-full bg-teal-50 text-sm font-semibold text-teal-800 dark:bg-teal-950 dark:text-teal-200"
                        >
                            {{
                                practitioner.name
                                    .split(' ')
                                    .map((part) => part[0])
                                    .slice(0, 2)
                                    .join('')
                            }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <div
                                class="flex items-center justify-between gap-4 text-sm"
                            >
                                <span
                                    class="truncate font-medium text-slate-800 dark:text-slate-200"
                                    >{{ practitioner.name }}</span
                                >
                                <span
                                    class="shrink-0 font-semibold text-slate-900 tabular-nums dark:text-white"
                                    >{{ practitioner.appointments_count }}</span
                                >
                            </div>
                            <div
                                class="mt-2 h-1.5 overflow-hidden rounded-full bg-slate-100 dark:bg-slate-800"
                            >
                                <div
                                    class="h-full rounded-full bg-teal-600 dark:bg-teal-400"
                                    :style="{
                                        width: `${weeklyAppointments === 0 ? 0 : (practitioner.appointments_count / weeklyAppointments) * 100}%`,
                                    }"
                                />
                            </div>
                        </div>
                    </li>
                </ul>
                <div v-else class="px-6 py-12 text-center">
                    <UsersRound
                        class="mx-auto size-8 text-slate-300 dark:text-slate-600"
                    />
                    <p
                        class="mt-3 text-sm font-medium text-slate-800 dark:text-slate-200"
                    >
                        No practitioners yet
                    </p>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                        Add practitioners to see their appointment totals.
                    </p>
                </div>
            </article>
        </section>
    </main>
</template>
