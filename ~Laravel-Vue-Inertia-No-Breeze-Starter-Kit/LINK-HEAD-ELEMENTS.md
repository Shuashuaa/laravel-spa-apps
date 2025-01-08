# LINK AND HEAD ELEMENTS

## js/Layout/Layout.vue
> prevent the server call 
```
<script setup>
import { Link } from '@inertiajs/vue3'
</script>

<template>
    <div>
        <header class=bg-indigo-500 text-white>
            <nav class="flex items-center justify-between p-4 max-w-screen-lg mx-auto">
                <div class="space-x-6">
                    <Link href="/">Home</Link>
                    <Link href="/about">About</Link>
                </div>
            </nav>
        </header>

        <main class="p-4">
            <slot />
        </main>
    </div>
</template>
```

<hr>

## js/Layout/Layout.vue
> added a Head component for title and meta
```
<script setup>
import { Link, Head } from '@inertiajs/vue3'
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
                <div class="space-x-6">
                    <Link href="/">Home</Link>
                    <Link href="/about">About</Link>
                </div>
            </nav>
        </header>

        <main class="p-4">
            <slot />
        </main>
    </div>
</template>
```

<br>
<hr>
<br>

# Set a Global Title for the app

```
title: (title) => `My App ${title}`,
```

### app.js
```
import './bootstrap';

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
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
      .mount(el)
  },
})
```

### Home.vue
```
<script setup>
import { Head } from '@inertiajs/vue3'
</script>

<template>
    <Head title="- Home"/>
    <h1 class="text-3xl text-blue-500 font-bold underline">
        Hello world!
    </h1>
</template>
```

## About.vue
```
<script setup>
import { Head } from '@inertiajs/vue3'
</script>

<template>
    <Head title="- About"/>
    <h1 class="text-3xl text-blue-500 font-bold underline">
        About
    </h1>
</template>
```

# Register Global Components
> to prevent repetition of imports
```
import { createInertiaApp, Head, Link } from '@inertiajs/vue3'

.component('Head', Head)
.component('Link', Link)
```
### app.js
```
import './bootstrap';

import { createApp, h } from 'vue'
import { createInertiaApp, Head, Link } from '@inertiajs/vue3'
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
      .component('Head', Head)
      .component('Link', Link)
      .mount(el)
  },
})
```

## now, use the components without the need of importing it.
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
        <header class=bg-indigo-500 text-white>
            <nav class="flex items-center justify-between p-4 max-w-screen-lg mx-auto">
                <div class="space-x-6">
                    <Link href="/">Home</Link>
                    <Link href="/about">About</Link>
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
    <Head title="- Home"/>
    <h1 class="text-3xl text-blue-500 font-bold underline">
        Hello world!
    </h1>
</template>
```