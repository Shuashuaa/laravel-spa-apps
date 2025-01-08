# ROUTES using INERTIA

## web.php
```
<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
});
```

## or we can use a `helper function`

```
<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
});

Route::get('/about', function () {
    return inertia('About');
});
```

## Array of Props
### web.php
```
<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
});

Route::get('/about', function () {
    return inertia('About', [
        'user' => 'josh'
    ]);
});

```

### pages/About.vue
```
<script setup>

defineProps({
    user: String
})
</script>

<template>
    <h1 class="text-3xl text-blue-500 font-bold underline">
        About {{ user }}
    </h1>
</template>

```

## What if you don't need a callback function
```
<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
});

Route::inertia('/about', 'About', ['user' => 'josh']);
```