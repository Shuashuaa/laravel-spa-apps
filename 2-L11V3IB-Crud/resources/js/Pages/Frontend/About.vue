<script setup>
import FrontendLayout from '@/Layouts/FrontendLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    title: String
});

</script>

<template>
    <FrontendLayout>

    <Head title="About Page"/>
    <h1>{{ title }}</h1>

    </FrontendLayout>
</template>