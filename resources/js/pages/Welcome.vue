<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    ArrowRight,
    CalendarDays,
    ChartNoAxesCombined,
    ShieldCheck,
} from '@lucide/vue';
import { dashboard, login } from '@/routes';
</script>

<template>
    <Head title="Clinic Metrics Desk">
        <meta
            name="description"
            content="A clear, privacy-conscious overview of clinic appointments and daily operations."
        />
    </Head>

    <div
        class="min-h-screen overflow-hidden bg-[#f7faf9] text-slate-950 dark:bg-slate-950 dark:text-white"
    >
        <header
            class="mx-auto flex w-full max-w-7xl items-center justify-between px-6 py-6 lg:px-10"
        >
            <Link
                href="/"
                class="flex items-center gap-3 rounded-lg focus-visible:ring-2 focus-visible:ring-teal-600 focus-visible:outline-none"
            >
                <span
                    class="flex size-10 items-center justify-center rounded-xl bg-teal-800 text-white shadow-sm dark:bg-teal-600"
                >
                    <CalendarDays class="size-5" />
                </span>
                <span class="text-sm font-semibold tracking-tight"
                    >Clinic Metrics Desk</span
                >
            </Link>
            <Link
                v-if="$page.props.auth.user"
                :href="dashboard()"
                class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:border-teal-300 hover:text-teal-800 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-200"
            >
                Open dashboard <ArrowRight class="size-4" />
            </Link>
            <Link
                v-else
                :href="login()"
                class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:border-teal-300 hover:text-teal-800 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-200"
            >
                Admin sign in <ArrowRight class="size-4" />
            </Link>
        </header>

        <main
            class="mx-auto grid w-full max-w-7xl items-center gap-14 px-6 pt-12 pb-20 lg:grid-cols-[1.05fr_0.95fr] lg:px-10 lg:pt-20 lg:pb-28"
        >
            <section class="max-w-2xl">
                <p
                    class="inline-flex items-center gap-2 rounded-full border border-teal-200 bg-white/80 px-3 py-1.5 text-xs font-semibold tracking-wide text-teal-800 shadow-sm dark:border-teal-900 dark:bg-slate-900 dark:text-teal-200"
                >
                    <span class="size-1.5 rounded-full bg-teal-500" /> CLINIC
                    OPERATIONS, MADE CLEAR
                </p>
                <h1
                    class="mt-7 text-5xl leading-[1.08] font-semibold tracking-tight text-slate-950 sm:text-6xl dark:text-white"
                >
                    A calmer start to the clinic day.
                </h1>
                <p
                    class="mt-6 max-w-xl text-lg leading-8 text-slate-600 dark:text-slate-400"
                >
                    See today’s appointment picture, understand weekly
                    attendance, and keep your team’s schedule close at hand.
                </p>
                <div class="mt-9 flex flex-wrap items-center gap-3">
                    <Link
                        v-if="$page.props.auth.user"
                        :href="dashboard()"
                        class="inline-flex items-center gap-2 rounded-xl bg-teal-800 px-5 py-3 text-sm font-semibold text-white shadow-md shadow-teal-900/10 transition hover:-translate-y-0.5 hover:bg-teal-900 focus-visible:ring-2 focus-visible:ring-teal-600 focus-visible:ring-offset-2 focus-visible:outline-none dark:bg-teal-600 dark:hover:bg-teal-500"
                    >
                        Go to your dashboard <ArrowRight class="size-4" />
                    </Link>
                    <Link
                        v-else
                        :href="login()"
                        class="inline-flex items-center gap-2 rounded-xl bg-teal-800 px-5 py-3 text-sm font-semibold text-white shadow-md shadow-teal-900/10 transition hover:-translate-y-0.5 hover:bg-teal-900 focus-visible:ring-2 focus-visible:ring-teal-600 focus-visible:ring-offset-2 focus-visible:outline-none dark:bg-teal-600 dark:hover:bg-teal-500"
                    >
                        Sign in to your desk <ArrowRight class="size-4" />
                    </Link>
                    <span class="text-sm text-slate-500 dark:text-slate-400"
                        >Private admin workspace</span
                    >
                </div>

                <div
                    class="mt-14 grid gap-5 border-t border-slate-200 pt-7 sm:grid-cols-3 dark:border-slate-800"
                >
                    <div class="flex gap-3">
                        <CalendarDays
                            class="mt-0.5 size-5 shrink-0 text-teal-700 dark:text-teal-300"
                        />
                        <div>
                            <h2 class="text-sm font-semibold">
                                Daily overview
                            </h2>
                            <p
                                class="mt-1 text-xs leading-5 text-slate-500 dark:text-slate-400"
                            >
                                A quick read on what’s happening today.
                            </p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <ChartNoAxesCombined
                            class="mt-0.5 size-5 shrink-0 text-teal-700 dark:text-teal-300"
                        />
                        <div>
                            <h2 class="text-sm font-semibold">
                                Simple reporting
                            </h2>
                            <p
                                class="mt-1 text-xs leading-5 text-slate-500 dark:text-slate-400"
                            >
                                Attendance patterns and team totals.
                            </p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <ShieldCheck
                            class="mt-0.5 size-5 shrink-0 text-teal-700 dark:text-teal-300"
                        />
                        <div>
                            <h2 class="text-sm font-semibold">Minimal data</h2>
                            <p
                                class="mt-1 text-xs leading-5 text-slate-500 dark:text-slate-400"
                            >
                                No patient names or clinical notes.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <aside
                aria-label="Clinic Metrics Desk features"
                class="relative mx-auto w-full max-w-xl"
            >
                <div
                    class="absolute -inset-8 rounded-[2.5rem] bg-gradient-to-br from-teal-100 via-cyan-50 to-amber-50 blur-2xl dark:from-teal-950/60 dark:via-slate-900 dark:to-amber-950/30"
                />
                <div
                    class="relative rounded-[2rem] border border-white/80 bg-white/85 p-6 shadow-2xl shadow-slate-900/10 backdrop-blur dark:border-slate-800 dark:bg-slate-900/90"
                >
                    <div
                        class="flex items-center justify-between border-b border-slate-100 pb-5 dark:border-slate-800"
                    >
                        <div class="flex items-center gap-3">
                            <span
                                class="flex size-10 items-center justify-center rounded-xl bg-teal-50 text-teal-800 dark:bg-teal-950 dark:text-teal-200"
                            >
                                <CalendarDays class="size-5" />
                            </span>
                            <div>
                                <p class="text-sm font-semibold">
                                    Your operations desk
                                </p>
                                <p
                                    class="mt-0.5 text-xs text-slate-500 dark:text-slate-400"
                                >
                                    Appointments, thoughtfully summarized
                                </p>
                            </div>
                        </div>
                        <span
                            class="rounded-full bg-emerald-50 px-2.5 py-1 text-[10px] font-semibold tracking-wide text-emerald-700 uppercase dark:bg-emerald-950 dark:text-emerald-300"
                            >Admin only</span
                        >
                    </div>
                    <div class="mt-5 space-y-3">
                        <div
                            class="rounded-xl border border-slate-100 bg-slate-50/80 p-4 dark:border-slate-800 dark:bg-slate-950/60"
                        >
                            <p
                                class="text-xs font-medium tracking-wide text-slate-500 uppercase dark:text-slate-400"
                            >
                                At a glance
                            </p>
                            <div class="mt-4 grid grid-cols-3 gap-3">
                                <div
                                    v-for="label in [
                                        'Today',
                                        'This week',
                                        'Your team',
                                    ]"
                                    :key="label"
                                    class="rounded-lg bg-white p-3 dark:bg-slate-900"
                                >
                                    <div
                                        class="h-2 w-12 rounded-full bg-slate-200 dark:bg-slate-700"
                                    />
                                    <p
                                        class="mt-3 text-[10px] font-medium text-slate-500 dark:text-slate-400"
                                    >
                                        {{ label }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div
                            class="rounded-xl border border-slate-100 p-4 dark:border-slate-800"
                        >
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-semibold">
                                        A focused view
                                    </p>
                                    <p
                                        class="mt-1 text-xs text-slate-500 dark:text-slate-400"
                                    >
                                        Quick filters, clear status, useful
                                        totals.
                                    </p>
                                </div>
                                <ChartNoAxesCombined
                                    class="size-5 text-teal-700 dark:text-teal-300"
                                />
                            </div>
                            <div
                                class="mt-4 flex h-16 items-end gap-2"
                                aria-hidden="true"
                            >
                                <span
                                    v-for="height in [
                                        '35%',
                                        '58%',
                                        '42%',
                                        '78%',
                                        '52%',
                                        '90%',
                                        '66%',
                                        '82%',
                                    ]"
                                    :key="height"
                                    class="flex-1 rounded-t-md bg-gradient-to-t from-teal-700 to-teal-400/70 dark:from-teal-600 dark:to-teal-300/70"
                                    :style="{ height }"
                                />
                            </div>
                        </div>
                        <p
                            class="flex items-center justify-center gap-2 pt-1 text-xs text-slate-500 dark:text-slate-400"
                        >
                            <ShieldCheck
                                class="size-4 text-teal-700 dark:text-teal-300"
                            />
                            Synthetic demo records only. No patient data.
                        </p>
                    </div>
                </div>
            </aside>
        </main>
    </div>
</template>
