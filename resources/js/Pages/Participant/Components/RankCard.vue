<script setup>
import Rating from '@/Components/Rating.vue';
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    rank: {
        type: Number,
        required: true
    },
    participant: {
        type: Object,
        required: true
    }
})

const image = computed(() => {
    if (props.rank == 1) {
        return '/images/gold.png'
    } else if (props.rank == 2) {
        return '/images/silver.png'
    } else if (props.rank == 3) {
        return '/images/bronze.png'
    }
})
const AltText = computed(() => {
    if (props.rank == 1) {
        return 'Gold Medal'
    } else if (props.rank == 2) {
        return 'Silver Medal'
    } else if (props.rank == 3) {
        return 'Bronze Medal'
    }
})
</script>

<template>
    <div class="w-full p-3 pb-5 bg-base-200 rounded-box shadow-md border flex flex-col items-center justify-center gap-2 sm:gap-4 relative"
        :class="{ 'border-yellow-500': rank == 1, 'border-zinc-500 mt-5': rank == 2, 'border-amber-500 mt-6': rank == 3 }">

        <img :src="image" :alt="AltText"
            class="absolute aspect-square w-[70px] top-[-35px] sm:w-[100px] sm:top-[-50px] left-[50%] translate-x-[-50%]">
        <br>
        <div class="text-xl sm:text-2xl font-semibold"
            :class="{ 'text-yellow-500': rank == 1, 'text-zinc-500': rank == 2, 'text-amber-500': rank == 3 }">
            {{ participant.name }}
        </div>
        <div class="font-semibold opacity-60">
            <Rating :rating="participant.display_rating" class="text-2xl sm:text-4xl" />
        </div>
        <div class="text-xs uppercase font-semibold opacity-60 hidden sm:block">
            Contests Participated: {{ participant.contests_count }}
        </div>
        <Link :href="route('participant.show', participant.name)" class="btn btn-primary">
        <span class="hidden sm:inline">View Profile</span>
        <svg class="size-[1.2em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2" fill="none" stroke="currentColor">
                <path d="M6 3L20 12 6 21 6 3z"></path>
            </g>
        </svg>

        </Link>
    </div>

</template>
