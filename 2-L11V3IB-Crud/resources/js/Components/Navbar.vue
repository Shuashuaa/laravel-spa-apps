<script setup>
import { Link } from '@inertiajs/vue3';

</script>

<template>
    <nav class="flex justify-between p-4 bg-gray-200">
        <div class="text-lg">
            Navbar
        </div>
        <div>
            <ul class="flex gap-x-4 me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <Link class="text-dark" :href="route('myhome')">Home</Link>
                </li>
                <li class="nav-item">
                    <Link class="text-dark" :href="route('aboutUs')">About Us</Link>
                </li>
                <li class="nav-item">
                    <Link class="text-dark" :href="route('products.index')">Products</Link>
                </li>
                <li class="nav-item">
                    <Link class="text-dark" :href="route('contactUs')">Contact Us</Link>
                </li>
                <li class="nav-item">
                    <Link class="text-dark" :href="route('contactUs')">Login</Link>
                </li>
            </ul>
        </div>
    </nav>
</template>