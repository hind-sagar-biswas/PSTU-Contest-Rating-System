<script setup>
import Rating from '@/Components/Rating.vue';
defineProps({
    participant: {
        type: Object,
        required: true
    }
})
</script>
<template>
    <div class="bg-base-200 p-4 shadow-sm sm:rounded-lg sm:p-8">
        <div class="font-semibold opacity-60">
            <Rating :rating="participant.display_rating" class="text-2xl sm:text-4xl" />
        </div>
        <h2 class="text-2xl font-semibold leading-tight mb-1">{{ participant.name }}</h2>
        <p class="text-xs uppercase font-semibold opacity-60">
            Contests Participated: {{ participant.contests_count }}
        </p>
        <p class="text-xs opacity-60 my-3">Joined {{ participant.created_at }}</p>
        <a :href="`https://codeforces.com/profile/${participant.name}`" target="_blank" class="btn btn-sm btn-accent">
            Codeforces Profile
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="size-[1.2em]">
                <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2" fill="none" stroke="currentColor">
                    <path d="M6 3L20 12 6 21 6 3z"></path>
                </g>
            </svg>
        </a>
    </div>
</template>
