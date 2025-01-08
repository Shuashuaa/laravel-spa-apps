# LAYOUTS

## js/Layouts/Layout.vue
```
<script setup>
</script>

<template>
    <div>
        <header class=bg-indigo-500 text-white>
            <nav class="flex items-center justify-between p-4 max-w-screen-lg mx-auto">
                <div class="space-x-6">
                    <a href="/">Home</a>
                    <a href="/about">About</a>
                </div>
            </nav>
        </header>

        <main class="p-4">
            <slot />
        </main>
    </div>
</template>
```

## Home.vue
```
<script setup>
import Layout from '../Layouts/Layout.vue';
</script>

<template>
    <Layout>
        <h1 class="text-3xl text-blue-500 font-bold underline">
            Hello world!
        </h1>
    </Layout>
    
</template>
```

when you see in vue devtools the `Layout` is inside of `Home` so to fix that

## Home.vue
```
<script setup>
import Layout from '../Layouts/Layout.vue';

defineOptions({
    layout: Layout
})
</script>

<template>
    <h1 class="text-3xl text-blue-500 font-bold underline">
        Hello world!
    </h1>
</template>
```
<br>
<hr>
<br>

# Implement a default `layout`

### app.js
```
import './bootstrap';

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import Layout from './Layouts/Layout.vue'

createInertiaApp({
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

# Create a specific layout
### js/Layout/Demo.vue
```
<script setup>
</script>

<template>
    <div>
        <header class=bg-green-500 text-white>
            <nav class="flex items-center justify-between p-4 max-w-screen-lg mx-auto">
                <div class="space-x-6">
                    <a href="/">Home</a>
                    <a href="/about">About</a>
                </div>
            </nav>
        </header>

        <main class="p-4">
            <slot />
        </main>
    </div>
</template>
```

## Home.vue
```
<script setup>
import Demo from '../Layouts/Demo.vue';

defineOptions({
    layout: Demo
})
</script>

<template>
    <h1 class="text-3xl text-blue-500 font-bold underline">
        Hello world!
    </h1>
</template>
```