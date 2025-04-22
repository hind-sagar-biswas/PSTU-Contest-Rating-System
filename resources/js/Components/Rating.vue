<script setup>
import { computed } from 'vue';

const props = defineProps({
    rating: {
        type: Number,
        required: true,
    },
    value: {
        required: false,
        default: null,
    }
});

const ratingRange = [Number.NEGATIVE_INFINITY, 1200, 1400, 1600, 1900, 2200, 2400];
const rangeIndex = computed(() => Math.max(-1, ratingRange.findIndex((elem) => elem > props.rating) - 1));
</script>

<template>
    <b :class="{
        'text-gray-500': rangeIndex === 0,
        'text-green-500': rangeIndex === 1,
        'text-cyan-500': rangeIndex === 2,
        'text-blue-500': rangeIndex === 3,
        'text-violet-500': rangeIndex === 4,
        'text-orange-500': rangeIndex === 5,
        'text-red-500': rangeIndex === 6
    }">{{ props.value ?? props.rating }}</b>
</template>
