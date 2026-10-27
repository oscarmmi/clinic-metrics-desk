<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import {
    CalendarDays,
    ChevronLeft,
    ChevronRight,
    SlidersHorizontal,
} from '@lucide/vue';
import { reactive } from 'vue';

type AppointmentStatus = 'booked' | 'done' | 'no_show' | 'cancelled';

type Appointment = {
    id: number;
    scheduled_at: string;
    status: AppointmentStatus;
    practitioner: string;
};

type PaginationLink = {
    url: string | null;
    label: string;
    active: boolean;
};

const props = defineProps<{
    appointments: {
        data: Appointment[];
        links: PaginationLink[];
        current_page: number;
        last_page: number;
        from: number | null;
        to: number | null;
        total: number;
    };
    filters: {
        start_date: string;
        end_date: string;
        status: string;
    };
}>();

const form = reactive({ ...props.filters });

const statusLabels: Record<AppointmentStatus, string> = {
    booked: 'Booked',
    done: 'Completed',
    no_show: 'No-show',
    cancelled: 'Cancelled',
};

function applyFilters(): void {
    const query = Object.fromEntries(
        Object.entries(form).filter(([, value]) => value !== ''),
    );

    router.get('/appointments', query, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
    });
}

function clearFilters(): void {
    form.start_date = '';
    form.end_date = '';
    form.status = '';
    applyFilters();
}

function statusStyle(status: AppointmentStatus): string {
    return {
        booked: 'bg-blue-50 text-blue-700 dark:bg-blue-950/50 dark:text-blue-300',
        done: 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/50 dark:text-emerald-300',
        no_show:
            'bg-rose-50 text-rose-700 dark:bg-rose-950/50 dark:text-rose-300',
        cancelled:
            'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300',
    }[status];
}
</script>

<template>
    <Head title="Appointments" />

    <main class="mx-auto w-full max-w-6xl space-y-8 p-6 lg:p-10">
        <header
            class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end"
        >
            <div>
                <p
                    class="text-sm font-medium tracking-wide text-teal-700 dark:text-teal-300"
                >
                    SCHEDULE
                </p>
                <h1
                    class="mt-2 text-3xl font-semibold tracking-tight text-slate-950 dark:text-white"
                >
                    Appointments
                </h1>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                    Browse scheduled visits by date and status.
                </p>
            </div>
            <div
                class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm text-slate-600 shadow-sm dark:border-slate-800 dark:bg-slate-900 dark:text-slate-300"
            >
                <CalendarDays class="size-4 text-teal-700 dark:text-teal-300" />
                {{ appointments.total }} total
            </div>
        </header>

        <form
            class="grid gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:grid-cols-2 lg:grid-cols-[1fr_1fr_1fr_auto_auto] lg:items-end dark:border-slate-800 dark:bg-slate-900"
            @submit.prevent="applyFilters"
        >
            <label
                class="grid gap-2 text-sm font-medium text-slate-700 dark:text-slate-300"
            >
                From
                <input
                    v-model="form.start_date"
                    type="date"
                    class="h-10 rounded-lg border border-slate-200 bg-white px-3 text-sm text-slate-800 transition outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-600/15 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100"
                />
            </label>
            <label
                class="grid gap-2 text-sm font-medium text-slate-700 dark:text-slate-300"
            >
                To
                <input
                    v-model="form.end_date"
                    type="date"
                    class="h-10 rounded-lg border border-slate-200 bg-white px-3 text-sm text-slate-800 transition outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-600/15 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100"
                />
            </label>
            <label
                class="grid gap-2 text-sm font-medium text-slate-700 dark:text-slate-300"
            >
                Status
                <select
                    v-model="form.status"
                    class="h-10 rounded-lg border border-slate-200 bg-white px-3 text-sm text-slate-800 transition outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-600/15 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100"
                >
                    <option value="">All statuses</option>
                    <option
                        v-for="(label, status) in statusLabels"
                        :key="status"
                        :value="status"
                    >
                        {{ label }}
                    </option>
                </select>
            </label>
            <button
                type="submit"
                class="inline-flex h-10 items-center justify-center gap-2 rounded-lg bg-teal-700 px-4 text-sm font-medium text-white transition hover:bg-teal-800 focus-visible:ring-2 focus-visible:ring-teal-600 focus-visible:ring-offset-2 focus-visible:outline-none dark:bg-teal-600 dark:hover:bg-teal-500"
            >
                <SlidersHorizontal class="size-4" />
                Apply
            </button>
            <button
                type="button"
                class="h-10 rounded-lg px-3 text-sm font-medium text-slate-600 transition hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800"
                @click="clearFilters"
            >
                Clear
            </button>
        </form>

        <section
            class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900"
        >
            <div
                class="flex items-center justify-between border-b border-slate-100 px-6 py-4 dark:border-slate-800"
            >
                <div>
                    <h2
                        class="text-sm font-semibold text-slate-950 dark:text-white"
                    >
                        Appointment records
                    </h2>
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                        Patient information is not collected in this demo.
                    </p>
                </div>
                <span
                    class="text-sm text-slate-500 tabular-nums dark:text-slate-400"
                    >{{ appointments.from ?? 0 }}–{{ appointments.to ?? 0 }} of
                    {{ appointments.total }}</span
                >
            </div>

            <div v-if="appointments.data.length" class="overflow-x-auto">
                <table class="w-full min-w-[640px] text-left text-sm">
                    <thead
                        class="bg-slate-50 text-xs font-medium tracking-wide text-slate-500 uppercase dark:bg-slate-950/50 dark:text-slate-400"
                    >
                        <tr>
                            <th class="px-6 py-3">Date and time</th>
                            <th class="px-6 py-3">Practitioner</th>
                            <th class="px-6 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody
                        class="divide-y divide-slate-100 dark:divide-slate-800"
                    >
                        <tr
                            v-for="appointment in appointments.data"
                            :key="appointment.id"
                            class="transition hover:bg-slate-50/70 dark:hover:bg-slate-800/30"
                        >
                            <td
                                class="px-6 py-4 font-medium text-slate-800 dark:text-slate-200"
                            >
                                {{
                                    new Intl.DateTimeFormat('en', {
                                        dateStyle: 'medium',
                                        timeStyle: 'short',
                                    }).format(
                                        new Date(appointment.scheduled_at),
                                    )
                                }}
                            </td>
                            <td
                                class="px-6 py-4 text-slate-600 dark:text-slate-300"
                            >
                                {{ appointment.practitioner }}
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    :class="[
                                        'inline-flex rounded-full px-2.5 py-1 text-xs font-medium',
                                        statusStyle(appointment.status),
                                    ]"
                                    >{{
                                        statusLabels[appointment.status]
                                    }}</span
                                >
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-else class="px-6 py-16 text-center">
                <div
                    class="mx-auto flex size-12 items-center justify-center rounded-full bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-300"
                >
                    <CalendarDays class="size-5" />
                </div>
                <h3
                    class="mt-4 font-semibold text-slate-900 dark:text-slate-100"
                >
                    No appointments found
                </h3>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Try another date range or clear your filters.
                </p>
                <button
                    type="button"
                    class="mt-4 text-sm font-medium text-teal-700 hover:underline dark:text-teal-300"
                    @click="clearFilters"
                >
                    Clear filters
                </button>
            </div>

            <nav
                v-if="appointments.last_page > 1"
                aria-label="Pagination"
                class="flex items-center justify-between border-t border-slate-100 px-4 py-4 sm:px-6 dark:border-slate-800"
            >
                <span class="text-sm text-slate-500 dark:text-slate-400"
                    >Page {{ appointments.current_page }} of
                    {{ appointments.last_page }}</span
                >
                <div class="flex items-center gap-1">
                    <template
                        v-for="(link, index) in appointments.links"
                        :key="`${index}-${link.label}`"
                    >
                        <Link
                            v-if="link.url"
                            :href="link.url"
                            :class="[
                                'inline-flex size-9 items-center justify-center rounded-lg text-sm transition',
                                link.active
                                    ? 'bg-teal-700 font-semibold text-white dark:bg-teal-600'
                                    : 'text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800',
                            ]"
                            :aria-current="link.active ? 'page' : undefined"
                        >
                            <ChevronLeft
                                v-if="link.label.includes('Previous')"
                                class="size-4"
                            />
                            <ChevronRight
                                v-else-if="link.label.includes('Next')"
                                class="size-4"
                            />
                            <span v-else>{{ link.label }}</span>
                        </Link>
                        <span
                            v-else
                            class="inline-flex size-9 items-center justify-center text-slate-300 dark:text-slate-600"
                        >
                            <ChevronLeft
                                v-if="link.label.includes('Previous')"
                                class="size-4"
                            />
                            <ChevronRight
                                v-else-if="link.label.includes('Next')"
                                class="size-4"
                            />
                            <span v-else>{{ link.label }}</span>
                        </span>
                    </template>
                </div>
            </nav>
        </section>
    </main>
</template>
