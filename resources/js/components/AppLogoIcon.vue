<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

type Props = {
    className?: HTMLAttributes['class'];
};

defineProps<Props>();
</script>

<template>
    <svg
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 40 42"
        :class="className"
        v-bind="$attrs"
    >
        <rect
            x="5"
            y="8"
            width="30"
            height="28"
            rx="4"
            fill="none"
            stroke="currentColor"
            stroke-width="2.5"
        />
        <path
            d="M5 16h30M13 5v6M27 5v6M12 22v8M20 22v8M28 22v8"
            fill="none"
            stroke="currentColor"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2.5"
        />
    </svg>
</template>
