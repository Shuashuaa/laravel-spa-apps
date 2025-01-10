# TEXT INPUT COMPONENT

# Create a TextInput.vue
### pages/Components/TextInput.vue
> info: defineModel macro is only available at vuejs 3.4
```
<script setup>

const model = defineModel({
    type: null,
    required: true
})

defineProps({
    name: {
        type: String,
        required: true
    },
    type: {
        type: String,
        default: 'text'
    },
    message: String
})
</script>

<template>
    <div class="mb-6">
        <label>{{ name }}</label>
        <input :type="type" v-model="model" :class="{'!ring-red-500' : message}"/>
        <small class="text-red-500" v-if="message">{{ message }}</small>
    </div>
</template>

```

# Apply it to `Register.vue`
### Pages/Auth/Register.vue
```
<script setup>
import { useForm } from '@inertiajs/vue3'
import TextInput from '../Components/TextInput.vue'

const form = useForm({
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
})

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
```

