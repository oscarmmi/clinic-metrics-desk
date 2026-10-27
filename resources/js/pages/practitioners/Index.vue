<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { UsersRound } from '@lucide/vue';

type Practitioner = {
    id: number;
    name: string;
};

defineProps<{
    practitioners: Practitioner[];
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Practitioners',
                href: '/practitioners',
            },
        ],
    },
});
</script>

<template>
    <Head title="Practitioners" />

    <main class="mx-auto w-full max-w-6xl space-y-8 p-6 lg:p-10">
        <header
            class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end"
        >
            <div>
                <p
                    class="text-sm font-medium tracking-wide text-teal-700 dark:text-teal-300"
                >
                    YOUR CARE TEAM
                </p>
                <h1
                    class="mt-2 text-3xl font-semibold tracking-tight text-slate-950 dark:text-white"
                >
                    Practitioners
                </h1>
                <p
                    class="mt-2 max-w-xl text-sm leading-6 text-slate-600 dark:text-slate-400"
                >
                    A clear view of the people behind your clinic’s
                    appointments.
                </p>
            </div>
            <div
                class="inline-flex items-center gap-2 self-start rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm sm:self-auto dark:border-slate-800 dark:bg-slate-900 dark:text-slate-200"
            >
                <UsersRound class="size-4 text-teal-700 dark:text-teal-300" />
                {{ practitioners.length }} team members
            </div>
        </header>

        <section
            class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900"
        >
            <div
                class="border-b border-slate-100 px-6 py-4 dark:border-slate-800"
            >
                <h2
                    class="text-sm font-semibold text-slate-900 dark:text-slate-100"
                >
                    Team directory
                </h2>
            </div>

            <ul
                v-if="practitioners.length"
                class="divide-y divide-slate-100 dark:divide-slate-800"
            >
                <li
                    v-for="(practitioner, index) in practitioners"
                    :key="practitioner.id"
                    class="flex items-center gap-4 px-6 py-4"
                >
                    <div
                        class="flex size-11 shrink-0 items-center justify-center rounded-full bg-teal-50 text-sm font-semibold text-teal-800 dark:bg-teal-950 dark:text-teal-200"
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
                        <p
                            class="truncate font-medium text-slate-900 dark:text-slate-100"
                        >
                            {{ practitioner.name }}
                        </p>
                        <p
                            class="mt-0.5 text-sm text-slate-500 dark:text-slate-400"
                        >
                            Care team member
                        </p>
                    </div>
                    <span
                        class="hidden text-xs font-medium tracking-wide text-slate-400 sm:inline"
                        >TEAM MEMBER
                        {{ String(index + 1).padStart(2, '0') }}</span
                    >
                </li>
            </ul>

            <div v-else class="px-6 py-16 text-center">
                <div
                    class="mx-auto flex size-12 items-center justify-center rounded-full bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-300"
                >
                    <UsersRound class="size-5" />
                </div>
                <h3
                    class="mt-4 font-semibold text-slate-900 dark:text-slate-100"
                >
                    No practitioners yet
                </h3>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Practitioners will appear here when they are added.
                </p>
            </div>
        </section>
    </main>
</template>
