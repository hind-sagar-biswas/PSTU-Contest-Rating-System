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

const title = 'PSTU Weekly Stantings';
const description = 'PSTU Weekly Contest Stantings | CSE Club | Patuakhali Science and Technology University';

</script>


<template>

    <Head>
        <title>{{ title }}</title>
        <meta name="description" :content="description">
        <meta name="keywords" content="PSTU, CSE, CSE Club, Competitive Programming, Ratings">
        <meta name="author" content="Hind Sagar Biswas | CSE Club, PSTU">
        <meta name="twitter:title" :content="title" />
        <meta property="og:type" content="website" />
        <meta property="og:site_name" :content="title" />
        <meta property="og:url" content="https://pstu-cp.hindbiswas.com" />
        <meta property="og:title" :content="title" />
        <meta property="og:description" :content="description" />
    </Head>

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
