<script setup>
import Navbar from '@/Components/Navbar.vue';
</script>

<template>
    <div>
        <Navbar />

        <div v-if="$page.props.flash.message" class="alert text-green-600 mt-4 ml-4">
            {{ $page.props.flash.message }}
        </div>

        <slot />
    </div>
</template>