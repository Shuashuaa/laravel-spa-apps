# DASHBOARD AND ACTIVE LINKS

# Create a Dashboard.vue
### Components/Dashboard.vue
```
<template>
    <div>
        <h1 class="title">
            Welcome back {{ $page.props.auth.user.name }}
        </h1>
    </div>
</template>
```

# Create a Route for the Dashboard
### web.php
```
Route::inertia('/dashboard', 'Components/Dashboard')->name('dashboard');
```

# Update Layout.vue, add the Dashboard
### Layouts/Layout.vue
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
                
                <div v-if="$page.props.auth.user" class="flex"> 
                    <Link :href="route('dashboard')" class="nav-link">Dashboard</Link>
                    <Link :href="route('logout')" method="post" as="button" class="nav-link">Logout</Link>
                    <p class="nav-link">|</p>
                    <p class="rounded-md px-3 py-2 text-sm font-medium text-white">hello!, <span class="uppercase">{{ $page.props.auth.user.name }}</span></p>
                </div>
                <div v-else class="space-x-6">
                    <Link :href="route('register')" class="nav-link">Register</Link>
                    <Link :href="route('login')" class="nav-link">Login</Link>
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

# Add an Active Links Classes
```
:class="{'bg-slate-700' : $page.component === 'Home'}"
```
### Layouts/Layout.vue
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
                    <Link :href="route('home')" class="nav-link" :class="{'bg-slate-700' : $page.component === 'Home'}">Home</Link>
                </div>
                
                <div v-if="$page.props.auth.user" class="flex"> 
                    <Link :href="route('dashboard')" class="nav-link" :class="{'bg-slate-700' : $page.component === 'Components/Dashboard'}">Dashboard</Link>
                    <Link :href="route('logout')" method="post" as="button" class="nav-link">Logout</Link>
                    <p class="nav-link">|</p>
                    <p class="rounded-md px-3 py-2 text-sm font-medium text-white">hello!, <span class="uppercase">{{ $page.props.auth.user.name }}</span></p>
                </div>
                <div v-else class="space-x-6">
                    <Link :href="route('register')" class="nav-link" :class="{'bg-slate-700' : $page.component === 'Auth/Register'}">Register</Link>
                    <Link :href="route('login')" class="nav-link" :class="{'bg-slate-700' : $page.component === 'Auth/Login'}">Login</Link>
                </div>
            </nav>
        </header>

        <main class="p-4">
            <slot />
        </main>
    </div>
</template>
```