# NAMED ROUTES

# Install Ziggy to use `route()` in vue components
```
composer require tightenco/ziggy
```

## Register as a new plugin
```
import { ZiggyVue } from '../../vendor/tightenco/ziggy'

.use(ZiggyVue)
```
### app.js
```
import './bootstrap';

import { createApp, h } from 'vue'
import { createInertiaApp, Head, Link } from '@inertiajs/vue3'
import { ZiggyVue } from '../../vendor/tightenco/ziggy'
import Layout from './Layouts/Layout.vue'

createInertiaApp({
  title: (title) => `My App ${title}`,
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    let page = pages[`./Pages/${name}.vue`]
    page.default.layout = page.default.layout || Layout;
    return page;
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue)
      .component('Head', Head)
      .component('Link', Link)
      .mount(el)
  },
})
```

## add `@routes` in root template
### app.blade.php
```
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    @inertiaHead
    @routes
</head>
<body>
    @inertia
</body>
</html>
```

<br>
<hr>
<br>

# Use `route()`
> instead of uri, we can now use named routes
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
        <header class=bg-indigo-500 text-white>
            
            <nav class="flex items-center justify-between p-4 max-w-screen-lg mx-auto">
                <h1>{{ $page.props.user }}</h1>
                <div class="space-x-6">
                    <Link :href="route('home')">Home</Link>
                    <Link :href="route('about')">About</Link>
                </div>
            </nav>
        </header>

        <main class="p-4">
            <slot />
        </main>
    </div>
</template>
```

## setup the routes
### web.php
```
<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

Route::inertia('/about', 'About', ['user' => 'josh'])->name('about');

```