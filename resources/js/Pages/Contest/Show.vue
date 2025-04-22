<script setup>
import Layout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    contest: Object,
})
</script>

<template>

    <Head title="Dashboard" />

    <Layout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight">
                Contest {{ contest.date }}
            </h2>
            <p class="text-info" v-if="!contest.calculated">Calculating rating changes... Refresh in a few moments to
                see the results</p>
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
                                    <th class="text-center">Solved</th>
                                    <th class="text-right">Penalty</th>
                                    <th class="text-right">Delta</th>
                                </tr>
                            </thead>

                            <!-- body -->
                            <tbody>
                                <template v-if="contest.results.length">
                                    <tr v-for="(result, index) in contest.results" :key="index">
                                        <th>{{ result.standing }}</th>
                                        <td class="text-primary">{{ result.participant.name }}</td>
                                        <th class="text-center">{{ result.solved }}</th>
                                        <th class="text-right">{{ result.penalty }}</th>
                                        <td class="text-right">
                                            <template v-if="result.delta">
                                                <b v-if="result.delta > 0" class="text-success">+{{ result.delta }}</b>
                                                <b v-else class="text-error">{{ result.delta }}</b>
                                            </template>
                                            <span v-else class="loading loading-spinner"></span>
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
