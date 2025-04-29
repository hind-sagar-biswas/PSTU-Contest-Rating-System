<script setup>
import Layout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Chart from './Partials/RatingChart.vue';
import Info from './Partials/Info.vue';

const props = defineProps({
    results: {
        type: Array,
        required: true
    },
    participant: {
        type: Object,
        required: true
    }
})
</script>
<template>

    <Head :title="participant.name" />
    <Layout>
        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 px-2 sm:px-6 lg:px-8">
                <Info :participant="participant" />
                <Chart :results="results" />
            </div>
        </div>
    </Layout>
</template>
