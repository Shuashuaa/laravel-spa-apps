# FORM HELPER

# useForm
```
import { useForm } from '@inertiajs/vue3'

const form = useForm({
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
})
```

### Register.vue
```
<script setup>
import { reactive } from 'vue'
import { useForm } from '@inertiajs/vue3'

const form = useForm({
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
})

const submit = () => {
    form.post('/register');
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

### web.php
```
use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
```

### AuthController.php
```
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request){
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed',
        ]);

        dd('pass');
    }
}
```

upon trial it seems that everything's fine (shows 'pass') <br>
but if we intentionally made `password` and `password_confirmation` different <br>
then we will not get any message indicating a matching error.

upon checking in the vue dev tools, we'll see in the Register Component that it has a props called `errors.`
that we can use as our indicator in the front-end.

<br>

# Application of the `errors` message in the frontend
### we can access the form properties provided by `useForm` and apply it.
```
{{ form }}
```
### Register.vue
```
<div class="mb-6">
    <label>Name</label>
    <input type="text" v-model="form.name"/>
    <small>{{ form.errors.name }}</small>
</div>
<div class="mb-6">
    <label>Email</label>
    <input type="text" v-model="form.email"/>
    <small>{{ form.errors.email }}</small>
</div>
<div class="mb-6">
    <label>Password</label>
    <input type="text" v-model="form.password"/>
    <small>{{ form.errors.password }}</small>
</div>
<div class="mb-6">
    <label>Copnfirm Password</label>
    <input type="text" v-model="form.password_confirmation"/>
</div>
```

<br>

# Form Processing
```
<button :disabled="form.processing" class="primary-btn">register</button>
```
### Register.vue
```
<button :disabled="form.processing" class="primary-btn">
    <span v-if="form.processing">Registering...</span>
    <span v-else>Register</span>
</button>
```

<br>

# Form Reset
> it will reset the `password` and `password_confirmation` input fields and leave the `name` and `email` as is if there is an error.
### Register.vue
```
const submit = () => {
    form.post('/register', {
        onError:() => form.reset('password', 'password_confirmation')
    });
}
```

<br>

# Finish the Create function
### AuthController.php
```
<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request){

        // validate
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed',
        ]);

        // register
        $user = User::create($fields);

        // redirect
        return redirect()->route('home');
    }
}

```

# Download the `SQLite3 Editor` in `VSCode` to use `database.sqlite`

### Try to insert data if it will reflect on `database.sqlite`.

<br>

# Use `route()` to post
> we use `ziggy` for vue files to use laravel/php `route()` function/method.
### Register.vue
```
const submit = () => {
    form.post(route('register'), {
        onError:() => form.reset('password', 'password_confirmation')
    });
}
```