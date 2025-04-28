<script setup>
import Layout from '@/Layouts/AuthenticatedLayout.vue';
defineProps({
    contests: {
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
    <Layout>
        <!--
        <a :href="`https://codeforces.com/profile/${participant.name}`" target="_blank">
        -->

    </Layout>
</template>
