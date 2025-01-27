<script setup>
import { useForm } from '@inertiajs/vue3'
import TextInput from '../Components/TextInput.vue'

const form = useForm({
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
    avatar: null,
    preview: null
})

const change = (e) => {
    form.avatar = e.target.files[0];
    form.preview = URL.createObjectURL(e.target.files[0])
}

const submit = () => {
    form.post(route('register'), {
        onError:() => form.reset('password', 'password_confirmation')
    });
}
</script>

<template>
    <Head title="Register"/>

    <h1>Registration Form</h1>

    <div class="w-2/4 mx-auto">
        <form @submit.prevent="submit">
            <div class="grid place-items-center">
                <div class="relative w-28 h-28 rounded-full overflow-hidden border border-slate-300">
                    <label for="avatar" class="absolute inset-0 grid content-end cursor-pointer">
                        <span class="bg-white/70 pb-2 text-center">Avatar</span>
                    </label>
                    <input type="file" @input="change" id="avatar" hidden/>

                    <img class="object-cover w-28 h-28" :src="form.preview ?? 'storage/avatars/default.jpg'" alt=""/>
                </div>

                <p class="error mt-2">{{ form.errors.avatar }}</p>
            </div>

            <TextInput v-model="form.name" name="name" :message="form.errors.name"/>
            <TextInput v-model="form.email" name="email" type="email" :message="form.errors.email"/>
            <TextInput v-model="form.password" name="password" type="password" :message="form.errors.password"/>
            <TextInput v-model="form.password_confirmation" type="password" name="password_confirmation"/>

            <div>
                <p class="text-slate-600 mb-2">Already a user? <a href="#" class="text-link">Login</a> </p>
                <button :disabled="form.processing" class="primary-btn">
                    <span v-if="form.processing">Registering...</span>
                    <span v-else>Register</span>
                </button>
            </div>
        </form>
    </div>
    
</template>