# NO STARTER KIT

# Install Laravel11
```
composer create-project --prefer-dist laravel/laravel:^11 laravel-inertia-vue-no-breeze
```
```
cd laravel-inertia-vue-no-breeze
```
# Install Vuejs3
```
npm i vue@latest
```
# Install Inertiajs
```
composer require inertiajs/inertia-laravel
```
### root template/document (app.blade.php)
> resource/views/ change `welcome.blade.php` => `app.blade.php`

```
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Starter Kit</title>

    @vite('resources/js/app.js')
    @inertiaHead

</head>
<body>
     @inertia
</body>
</html>
```
### Install Inertia Middleware
> This will create the HandleInertiaRequests.php
```
php artisan inertia:middleware
```
### Register HandleInertiaRequests.php as a web middleware
> bootstrap/app.php
```
use App\Http\Middleware\HandleInertiaRequests;

->withMiddleware(function (Middleware $middleware) {
    $middleware->web(append: [
        HandleInertiaRequests::class,
    ]);
})
```

### Install a Client-Side Adapter for Vue3 framework
```
npm install @inertiajs/vue3
```

### Initialize Inertia app
> resources/js/app.js | This will find a root template which is the `app.blade.php` to render the vue app
```
import './bootstrap';

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    return pages[`./Pages/${name}.vue`]
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .mount(el)
  },
})
```
<br>
<hr>
<br>

### Create a components
js/Pages/Home.vue
```
<script setup>
</script>

<template>
    hello!!
</template>
```

# Install vite plugin for vue
```
npm i @vitejs/plugin-vue
```

### Register vue to the `vite.config.js`
```
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        vue(),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});

```

# Install TailwindCSS

```
npm install -D tailwindcss postcss autoprefixer
npx tailwindcss init -p
```

### tailwind.config.js
```
/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}
```
### Update `app.blade.php`
> add resources/css/app.css
```
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Starter Kit</title>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    @inertiaHead

</head>
<body>
     @inertia
</body>
</html>
```

### Update Home.vue with Tailwindcss
js/Pages/Home.vue
```
<script setup>
</script>

<template>
    <h1 class="text-3xl text-blue-500 font-bold underline">
        Hello world!
    </h1>
</template>
```

# Run

```
php artisan serve
```

```
yarn dev
```