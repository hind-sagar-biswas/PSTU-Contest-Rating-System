<script setup>
import Layout from '@/Layouts/AuthenticatedLayout.vue';
import Item from './Components/ContestItem.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    contests: Object
})
</script>

<template>

    <Head title="Contests List" />

    <Layout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight">
                Contests List
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 px-2 sm:px-6 lg:px-8">

                <div class="text-center text-gray-500" v-if="!contests.data.length">
                    <p>No data found</p>
                </div>
                <template v-else>
                    <ul class="list bg-base-100 rounded-box shadow-md">

                        <li class="p-4 pb-2 text-xs opacity-60 tracking-wide">Previous Contests</li>

                        <Item v-for="(contest, index) in contests.data" :key="index"
                            :index="contests.data.length - index" :contest="contest" />
                    </ul>
                </template>

            </div>
        </div>
    </Layout>
</template>
