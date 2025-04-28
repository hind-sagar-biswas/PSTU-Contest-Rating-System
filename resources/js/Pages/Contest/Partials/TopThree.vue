<script setup>
import Card from './../Components/RankCard.vue';
defineProps({
    data: {
        type: Array,
        required: true
    }
})

</script>
<template>
    <div class="grid grid-cols-3 gap-1 sm:gap-5">
        <div>
            <Card v-if="data.length > 1" :rank="2" :participant="data[1]" />
        </div>
        <div>
            <Card v-if="data.length > 0" :rank="1" :participant="data[0]" />
        </div>
        <div>
            <Card v-if="data.length > 2" :rank="3" :participant="data[2]" />
        </div>
    </div>

</template>
