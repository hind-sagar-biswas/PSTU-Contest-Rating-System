<script setup>
import Rating from '@/Components/Rating.vue';
import { Link } from '@inertiajs/vue3';
defineProps({
    rank: {
        type: Number,
        required: true
    },
    participant: {
        type: Object,
        required: true
    }
})


const padby = (value, pad = 2) => value.toString().padStart(pad, '0');

</script>

<template>
    <li class="list-row">
        <div class="text-4xl font-thin opacity-30 tabular-nums">{{ padby(rank) }}</div>
        <!--div><img class="size-10 rounded-box" src="https://img.daisyui.com/images/profile/demo/1@94.webp" /></div-->
        <div class="list-col-grow">
            <div>{{ participant.name }}</div>
            <div class="text-xs uppercase font-semibold opacity-60">
                <Rating :rating="participant.display_rating" />
            </div>
        </div>
        <Link :href="route('participant.show', participant.name)" class="btn btn-square btn-primary">
        <svg class="size-[1.2em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2" fill="none" stroke="currentColor">
                <path d="M6 3L20 12 6 21 6 3z"></path>
            </g>
        </svg>
        </Link>
    </li>
</template>
