# FLASH MESSAGE
### HandleInertiaRequests.php
```
'flash' => [
    'message' => fn () => $request->session()->get('message')
],
```

# Add a `with()` method that has 2 arguments
### AnyController.php
```
return redirect()->intended('dashboard')->with('message', 'Welcome back to laravel inertia vuejs!');
```

# Use it in a Dashboard
### AnyVue.vue
```
<script setup></script>

<template>

    <Head title="Dashboard"/>

    <div>
        <p class="bg-green-300 text-green-900 p-2" v-if="$page.props.flash.message">{{ $page.props.flash.message }}</p>
    </div>
</template>
```