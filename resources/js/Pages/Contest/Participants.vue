<script setup>
import Layout from '@/Layouts/AuthenticatedLayout.vue';
import List from './Partials/ParticipantsList.vue';
import TopThree from './Partials/TopThree.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    data: {
        type: Object
    },
});


</script>


<template>

    <Head title="PSTU Weekly Stantings" />

    <Layout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight">
                PSTU Contest Participants
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 px-2 sm:px-6 lg:px-8">

                <div class="text-center text-gray-500" v-if="!data.data.length">
                    <p>No data found</p>
                </div>
                <template v-else>
                    <TopThree :data="data.data.slice(0, 3)" />
                    <List caption="Participants" v-if="data.data.length > 3" :data="data.data.slice(3)" />
                </template>

            </div>
        </div>
    </Layout>
</template>
