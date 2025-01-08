# SHARED DATA
> it is best if your browser has a vue devtools installed.

## in inertia component, find a props.
### Home.vue
> this will display what's in the Home.vue Inertia $page props
```
<script setup>
</script>

<template>
    <Head title="- Home"/>
    <h1 class="text-3xl text-blue-500 font-bold underline">
        {{ $page }}
    </h1>
</template>
```

## use the component name for title
### Home.vue
```
<script setup>
</script>

<template>
    <Head :title="`- ${$page.component }`"/>
    <h1 class="text-3xl text-blue-500 font-bold underline">
        Home
    </h1>
</template>
```

<br>
<hr>
<br>

# Access the Props from Middleware
### HandleInertiaRequests.php
```
public function share(Request $request): array
{
    return array_merge(parent::share($request), [
        //
        'user' => 'josh'
    ]);
}
```

### Home.vue
> access it in Home.vue
```
<script setup>
</script>

<template>
    <Head :title="`- ${$page.component }`"/>
    <h1 class="text-3xl text-blue-500 font-bold underline">
        Hello!, {{ $page.props.user }}
    </h1>
</template>
```

<hr>

# Proper way
### HandleInertiaRequests.php
```
public function share(Request $request): array
{
    return array_merge(parent::share($request), [
        //
        'auth.user' => 'josh' ?? null
    ]);
}
```

### Home.vue
```
<script setup>
</script>

<template>
    <Head :title="`- ${$page.component }`"/>
    <h1 class="text-3xl text-blue-500 font-bold underline">
        Hello!, {{ $page.props.auth.user }}
    </h1>
</template>
```

<hr>

# Limiting Exposed Data
### HandleInertiaRequests.php
```
public function share(Request $request): array
{
    return array_merge(parent::share($request), [
        // Synchronously...
        'auth.user' => 'josh' ?? null

        // Lazily...
        'auth.user' => fn () => $request->user()
            ? $request->user()->only('id', 'name', 'email')
            : null,
    ]);
}
```