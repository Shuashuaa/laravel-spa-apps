# FILTERS OR SEARCH

# Add Inertia Router - Inertia Manual Visits
> to add a `get request` in the same page and `include a search term to the url`.
```
import { router } from '@inertiajs/vue3'

router.get(url, data, options)
```
### Home.vue
> now that the search string is visible in the url in each keystroke, but the the problem is there's a request in each keystroke.
we can prevent that by using `lodash`'s delay functions.
```
<script setup>
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3'
import PaginationLinks from './Components/PaginationLinks.vue';

defineProps({
    users: Object
})

const getDate = (date) => 
    new Date(date).toLocaleDateString("en-us", {
        year: "numeric",
        month: "long",
        day: "numeric",
    });

const search = ref("");

watch(search, (q) => router.get('/', { search: q }, { preserveState: true }))

</script>

<template>
    <Head :title="`- ${$page.component }`"/>
    <h1>Home Page</h1>
    <div>

        <div class="flex justify-end mb-4">
            <div class="w-1/4">
                <input type="search" placeholder="Search" v-model="search">
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>no</th>
                    <th>avatar</th>
                    <th>name</th>
                    <th>email</th>
                    <th>registration date</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(user, index) in users.data" :key="index">
                    <td>{{ ((users.current_page - 1) * users.per_page) + index + 1  }}</td>
                    <td>
                        <img class="avatar" :src="user.avatar ? ('storage/' + user.avatar) : ('storage/avatars/default.jpg')" alt="">
                    </td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ getDate(user.created_at) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div>
        <PaginationLinks :paginator="users"/>
    </div>
    
</template> 
```

<br>
<br>
<br>

# `Install Lodash` - for `throttle` or `debounce` functions
```
npm i--save lodash
```
### Application
> Instead of using just a callback function `(q) => router.get('/', { search: q }, { preserveState: true })`
let's include lodash' throttle.
```
import { throttle } from "lodash";

throttle(callback function, delay)
```
### Home.vue
> we applied a call back function for the first arguement, and the delay in milliseconds for the second arguement
### but instead of throttle we use `debounce` instead, since debounce can only request after the user finished the input.
```
<script setup>
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3'
import PaginationLinks from './Components/PaginationLinks.vue';
import { debounce } from 'lodash';

defineProps({
    users: Object
})

const getDate = (date) => 
    new Date(date).toLocaleDateString("en-us", {
        year: "numeric",
        month: "long",
        day: "numeric",
    });

const search = ref("");

watch(search, debounce(
    (q) => router.get('/', { search: q }, { preserveState: true }),
    500
)
)

</script>

<template>
    <Head :title="`- ${$page.component }`"/>
    <h1>Home Page</h1>
    <div>

        <div class="flex justify-end mb-4">
            <div class="w-1/4">
                <input type="search" placeholder="Search" v-model="search">
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>no</th>
                    <th>avatar</th>
                    <th>name</th>
                    <th>email</th>
                    <th>registration date</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(user, index) in users.data" :key="index">
                    <td>{{ ((users.current_page - 1) * users.per_page) + index + 1  }}</td>
                    <td>
                        <img class="avatar" :src="user.avatar ? ('storage/' + user.avatar) : ('storage/avatars/default.jpg')" alt="">
                    </td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ getDate(user.created_at) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div>
        <PaginationLinks :paginator="users"/>
    </div>
    
</template> 
```

<br>
<br>
<br>

# Send the search term to the url and `grab` it using the `request object in the laravel app`.

### web.php
> change the inertia home, into get.
```
Route::inertia('/', 'Home', ["users" => User::paginate(5)])->name('home');
```
<br>

### into
> for more room to function
```
Route::get('/', function(){
    return inertia('Home', [
        "users" => User::paginate(5)
    ]);
})->name('home');
```

### into
> this has a bug when search ex.("m"), click for page 2, then we notice that the m in the search bar is gone and when we enter an "m" again it will broke the pagination
```
Route::get('/', function(Request $request){
    return inertia('Home', [
        // if there is a `$request->search` then pass a closure `function $query`
        "users" => User::when($request->search, function($query) use ($request ){
            // condition records like the search
            $query->where('name', 'like', '%' . $request->search . '%');
            //paginate and added the withQueryString() for us not to lose the query string on paginate
        })->paginate(5)->withQueryString(),
    ]);
})->name('home');
```

<br>
<br>

# The resolve is to pass the search value back to the frontend as a prop.
### web.php
> `searchTerm`
```
Route::get('/', function(Request $request){
    return inertia('Home', [
        "users" => User::when($request->search, function($query) use ($request ){
            $query->where('name', 'like', '%' . $request->search . '%');
        })->paginate(5)->withQueryString(),

        "searchTerm" => $request->search
    ]);
})->name('home');
```
### Home.vue
```
const props = defineProps({
    users: Object,
    searchTerm: String
})

const search = ref(props.searchTerm);
```

<br>
<br>
<br>
<br>
<br>

# extra.
> if adding a new criteria to the search
```
Route::get('/', function(Request $request){
    return inertia('Home', [
        "users" => User::when($request->search, function($query) use ($request ){
            $query
            ->where('name', 'like', '%' . $request->search . '%')
            // this
            ->orWhere();
        })->paginate(5)->withQueryString(),

        "searchTerm" => $request->search
    ]);
})->name('home');
```