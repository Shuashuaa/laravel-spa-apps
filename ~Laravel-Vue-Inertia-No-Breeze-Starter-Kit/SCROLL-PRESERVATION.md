# SCROLL PRESERVATION
> This is useful if you need to request and load the page without going back to the top of the page
- Likes a post,
- Make a comment,
- etc.

### Home.vue
```
<script setup></script>

<template>
    <Head :title="` - ${$page.component}`"/>

    <Link class="mt-[600px] block" href="/">Refresh<Link>
</template>
```