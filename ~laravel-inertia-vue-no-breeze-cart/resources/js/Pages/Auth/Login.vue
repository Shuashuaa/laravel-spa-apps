<script setup>
import { useForm } from '@inertiajs/vue3'
import TextInput from '../Components/TextInput.vue'

const form = useForm({
    email: null,
    password: null,
    remember: null
})

const submit = () => {
    form.post(route('login'), {
        onError:() => form.reset('password')
    });
}
</script>

<template>
    <Head title="Login"/>

    <h1>Login to your account</h1>

    <div class="w-2/4 mx-auto">
        <form @submit.prevent="submit">

            <TextInput v-model="form.email" name="email" type="email" :message="form.errors.email"/>
            <TextInput v-model="form.password" name="password" type="password" :message="form.errors.password"/>

            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-2">
                    <label for="remember">Remember me</label>
                    <input type="checkbox" v-model="form.remember" id="remember"/>
                </div>

                <p class="text-slate-600">
                Need an account? <a :href="route('register')" class="text-link">Register</a> </p>
            </div>

            <div>
                <button :disabled="form.processing" class="primary-btn">
                    <span v-if="form.processing">Logging in...</span>
                    <span v-else>Login</span>
                </button>
            </div>
        </form>
    </div>
    
</template>