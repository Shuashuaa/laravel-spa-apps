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
                    <Link :href="route('dashboard')" class="nav-link" :class="{'bg-slate-700' : $page.component === 'Dashboard'}">Dashboard</Link>
                    <Link :href="route('logout')" method="post" as="button" class="nav-link">Logout</Link>
                    <p class="nav-link">|</p>
                    <p class="rounded-md px-3 py-2 text-sm font-medium text-white">hello!, <span class="uppercase">{{ $page.props.auth.user.name }}</span></p>
                    <img class="avatar" :src="$page.props.auth.user.avatar ? ('storage/' + $page.props.auth.user.avatar) : ('storage/avatars/default.jpg')" width="100" alt="">
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