<script setup>
import { Link } from '@inertiajs/vue3';
defineProps({
    contest: {
        type: Object,
        required: true
    },
    index: {
        type: Number,
        required: true
    }
})

const padby = (value, pad = 2) => value.toString().padStart(pad, '0');
</script>

<template>

    <li class="list-row">
        <div class="text-4xl font-thin opacity-30 tabular-nums">{{ padby(index, 3) }}</div>
        <div class="list-col-grow">
            <div>{{ contest.date }}</div>
            <div class="text-xs uppercase font-semibold opacity-60">Participants: {{ contest.participants }}</div>
        </div>
        <Link :href="route('contest.show', contest.id)" class="btn btn-square btn-primary">
        <svg class="size-[1.2em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2" fill="none" stroke="currentColor">
                <path d="M6 3L20 12 6 21 6 3z"></path>
            </g>
        </svg>
        </Link>
    </li>


</template>
