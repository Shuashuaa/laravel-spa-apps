# FORMS
> copy the css in app.css

# setup the template
### Layout.vue
```
<script setup>
</script>

<template>
    <Head>
        <meta 
            head-key="description" 
            name="description" 
            content="This is a sample laravel-inertia-app"
        />
    </Head>
    <div>
        <header>
            <nav>
                <div class="space-x-6">
                    <Link :href="route('home')" class="nav-link">Home</Link>
                </div>
                <div class="space-x-6">
                    <Link :href="route('register')" class="nav-link">Register</Link>
                </div>
            </nav>
        </header>

        <main class="p-4">
            <slot />
        </main>
    </div>
</template>
```

### Home.vue
```
<script setup>
</script>

<template>
    <Head :title="`- ${$page.component }`"/>

    <h1>Home Page</h1>
</template> 
```

### web.php
> add register.vue
```
<?php

use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Home')->name('home');

Route::inertia('/register', 'Auth/Register')->name('register');
```

<hr>

### Pages/Auth/Register.vue
```
<script setup>
import { reactive } from 'vue'

const form = reactive({
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
})

const submit = () => {
    console.log(form)
}
</script>

<template>
    <Head title="Register"/>

    <h1>Registration Form</h1>

    <div class="w-2/4 mx-auto">
        <form @submit.prevent="submit">
            <div class="mb-6">
                <label>Name</label>
                <input type="text" v-model="form.name"/>
            </div>
            <div class="mb-6">
                <label>Email</label>
                <input type="email" v-model="form.email"/>
            </div>
            <div class="mb-6">
                <label>Password</label>
                <input type="text" v-model="form.password"/>
            </div>
            <div class="mb-6">
                <label>Copnfirm Password</label>
                <input type="text" v-model="form.password_confirmation"/>
            </div>

            <div>
                <p class="text-slate-600 mb-2">Already a user? <a href="#" class="text-link">Login</a> </p>
                <button class="primary-btn">Register</button>
            </div>
        </form>
    </div>
    
</template>
```