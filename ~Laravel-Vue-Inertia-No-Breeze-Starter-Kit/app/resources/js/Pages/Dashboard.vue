<script setup></script>
<template>

    <Head title="Dashboard"/>

    <div>
        <p class="bg-green-300 text-green-900 p-2" v-if="$page.props.flash.message">{{ $page.props.flash.message }}</p>
        <h1 class="title">
            Welcome back {{ $page.props.auth.user.name }}
        </h1>
    </div>
</template>