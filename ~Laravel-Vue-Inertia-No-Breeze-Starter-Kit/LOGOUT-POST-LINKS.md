# LOGOUT | POST LINKS

# Make a <Link> a Post link
```
method="post"
```
### anyvue.vue
> <Link> is basically an anchor tag, add a property to it to make a post link.
```
<Link :href="route('logout')" method="post" class="nav-link">Logout</Link>
```

# And for the users not to be able to `open in new table`.
> render it as a button
```
as="button"
```
### anyvue.vue
> we can also add a type="button" to it. just to make sure.
```
<Link :href="route('logout')" method="post" as="button" type="button" class="nav-link">Logout</Link>
```

# Add a logout to layout
### js/Layouts/Layout.vue
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

# Add logout to routes
### web.php
```
Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // running to function as an anchor tag and not a useForm Post
```

# Add logout function to AuthController.php
### AuthController.php
```
public function logout(Request $request){

    Auth::logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken(); //csrf token

    return redirect()->route('home');
}
```