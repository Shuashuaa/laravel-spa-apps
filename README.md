# installation [*](CORE.md)
## LARAVEL-VUE3JS-INERTIA SETUP
> Laravel 11 + Vue 3 with Inertia JS - Install and setup the pages, layouts, Component, use Props

> https://www.youtube.com/watch?v=Zi-LRmnUhdo
```
composer create-project --prefer-dist laravel/laravel:11^ <project-name>
```

## configure .env (database)
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel11tutorial
DB_USERNAME=root
DB_PASSWORD=1234
```

### run dev
```
php artisan serve
```
> when error occured (this means the session table isn't yet migrated to our database)

`SQLSTATE[42S02]: Base table or view not found: 1146 Table 'laravel11tutorial.sessions' doesn't exist (Connection: mysql, SQL: select * from `sessions` where `id` = X4f0sKhEHFfChXwFkIuFkGeq26UyB5YUxx4YREVu limit 1)`

### run
```
php artisan migrate
```

## Laravel Breeze
> https://laravel.com/docs/11.x/starter-kits#laravel-breeze-installation

```
composer require laravel/breeze --dev
```

## Breeze and React/Vue
> https://laravel.com/docs/11.x/starter-kits#breeze-and-inertia
```
php artisan breeze:install vue
```
> Try running `php artisan serve` again and you can now see a `login` and `register` button.

# Create a Controller
```
php artisan make:controller FrontendController
```

### FrontendController.php
```
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class FrontendController extends Controller
{
    public function index(){
        return Inertia::render('Frontend/Home');
    }

    public function about(){
        return Inertia::render('Frontend/About', [
            'title' => 'This is about page'
        ]);
    }
}
```

### web.php
```
<?php
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [FrontendController::class, 'index'])->name('myhome'); ##
Route::get('/about', [FrontendController::class, 'about'])->name('aboutUs'); ##
Route::inertia('/contact', 'Frontend/Contact')->name('contactUs'); ##

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

```

### js/Pages/Frontend/Home.vue
```
<script setup>
import FrontendLayout from '@/Layouts/FrontendLayout.vue';
import { Head } from '@inertiajs/vue3';

</script>

<template>
    <FrontendLayout>

        <Head title="Home Page"/>
        
        <h1>This is the Homepage</h1>

    </FrontendLayout>
</template>
```

### js/Pages/Frontend/About.vue <!-- same format as the Home.vue -->

### js/Pages/Frontend/Contact.vue <!-- same format as the Home.vue -->

### js/Layouts/FrontendLayout.vue
```
<script setup>
import Navbar from '@/Components/Navbar.vue';
</script>

<template>
    <div>
        <Navbar />
        <slot />
    </div>
</template>
```

### js/Components/Navbar.vue
```
<script setup>
import { Link } from '@inertiajs/vue3';

</script>

<template>
    <nav class="flex justify-between p-4 bg-gray-200">
        <div class="text-lg">
            Navbar
        </div>
        <div>
            <ul class="flex gap-x-4 me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <Link class="text-dark" :href="route('myhome')">Home</Link>
                </li>
                <li class="nav-item">
                    <Link class="text-dark" :href="route('aboutUs')">About Us</Link>
                </li>
                <li class="nav-item">
                    <Link class="text-dark" :href="route('contactUs')">Contact Us</Link>
                </li>
                <li class="nav-item">
                    <Link class="text-dark" :href="route('contactUs')">Login</Link>
                </li>
            </ul>
        </div>
    </nav>
</template>
```

### run 

```
npm run dev
&
php artisan serve
```