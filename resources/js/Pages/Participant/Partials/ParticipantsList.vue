<script setup>
import Item from './../Components/ParticipantListItem.vue';
defineProps({
    caption: {
        type: String,
        required: false,
        default: null
    },
    data: {
        type: Array,
        required: true
    }
})
</script>

<template>
    <ul class="list bg-base-100 rounded-box shadow-md mt-2">

        <li class="p-4 pb-2 text-xs opacity-60 tracking-wide" v-if="caption">{{ caption }}</li>

        <Item v-for="(participant, index) in data" :key="index" :rank="index + 4" :participant="participant" />

    </ul>
</template>
