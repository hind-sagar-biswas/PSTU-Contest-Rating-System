<script setup>
import Layout from '@/Layouts/AuthenticatedLayout.vue';
import Rating from '@/Components/Rating.vue';
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
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div class="bg-base-200 p-4 shadow-sm sm:rounded-lg sm:p-8">
                    <div class="overflow-x-auto">
                        <table class="table table-zebra">
                            <!-- head -->
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Contests</th>
                                    <th class="text-right">Rating</th>
                                </tr>
                            </thead>

                            <!-- body -->
                            <tbody>
                                <template v-if="data.data.length">
                                    <tr v-for="(participant, index) in data.data" :key="index">
                                        <th>{{ index + 1 }}</th>
                                        <td>
                                            <!--Rating :rating="participant.rating" :value="participant.name" /-->
                                            {{ participant.name }}
                                        </td>
                                        <td class="text-right">{{ participant.contests_count }}</td>
                                        <td class="text-right">
                                            <Rating :rating="participant.display_rating" />
                                        </td>
                                    </tr>
                                </template>
                                <tr v-else>
                                    <td colspan="3" class="text-center text-gray-500">No data found</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
