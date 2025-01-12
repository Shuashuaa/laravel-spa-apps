# SEEDERS

# seed the database
```
<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(30)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
```
### run the seeder
> check the db using SQLite3 Editor
```
php artisan db:seed
```

# Add a props to the inertia route
```
Route::inertia('/', 'Home', ["users" => User::all()])->name('home');

// or specify only what you need
// Route::inertia('/', 'Home', ["users" => User::all('name')])->name('home');
```

# Sample fetch and display in the Home
### Home.vue
```
<script setup>

defineProps({
    users: Object
})
</script>

<template>
    <Head :title="`- ${$page.component }`"/>
    <h1>Home Page</h1>
    <div class="border p-2 flex flex-wrap gap-3 justify-around">
        <p class="border px-2" v-for="(user, index) in users" :key="index">
            {{ user. name }}
        </p>
    </div>
    
</template> 
```

<br>
<br>
<br>
<br>
<br>
<br>

# PAGINATION

# Add a props to the inertia route and use `paginate()`
```
Route::inertia('/', 'Home', ["users" => User::paginate(5)])->name('home');
```

# Configure the `paginator`
```
<Link 
    v-for="(link, index) in users.links" 
    :key="index" 
    v-html="link.label" 
    :href="link.url"
    class="py-1 px-2 mr-1 border"
    :class="{ 'text-slate-300' : !link.url, 'text-blue-500': link.active }"
>
</Link>
```

# Create a table for Home
### Home.vue
```
<script setup>

defineProps({
    users: Object
})

const getDate = (date) => 
    new Date(date).toLocaleDateString("en-us", {
        year: "numeric",
        month: "long",
        day: "numeric",
    });

</script>

<template>
    <Head :title="`- ${$page.component }`"/>
    <h1>Home Page</h1>
    <div>
        <table>
            <thead>
                <tr>
                    <th>no.</th>
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

    <Link 
        v-for="(link, index) in users.links" 
        :key="index" 
        v-html="link.label" 
        :href="link.url"
        class="py-1 px-2 mr-1 border"
        :class="{ 'text-slate-300' : !link.url, 'text-blue-500': link.active }"
    >
    </Link>
</template> 
```

# Create a Separated Pagination Component
### Components/PaginationLinks.vue
```
<script setup>
defineProps({
    paginator: {
        type: Object,
        required: true
    },
})

const makeLabel = (label) => {
    if (label.includes("Previous")) {
        return "<<";
    }else if (label.includes("Next")){
        return ">>";
    } else {
        return label;
    }
};
</script>

<template>
    <div class="flex justify-between items-start">
        <div class="flex items-center rounded-md shadow-lg">
            <div v-for="(link, index) in paginator.links" :key="index">
                <!-- {{ link }} -->
                  <component 
                    :is="link.url && !link.active ? 'Link' : 'span'"
                    :href="link.url"
                    v-html="makeLabel(link.label)"
                    class="border-x border-slate-50 w-12 h-12 grid place-items-center bg-white"
                    :class="{
                        'hover:bg-slate-300' : link.url,
                        'text-zinc-400' : !link.url,
                        'font-bold text-blue-500' : link.active
                    }"
                  />
            </div>
        </div>

        <p class="text-slate-600 text-sm">
            Showing {{ paginator.from }} to {{ paginator.to }} of {{ paginator.total }} results
        </p>
    </div>
    
</template>
```

# Import it to the Home page
```
import PaginationLinks from './Components/PaginationLinks.vue';
...
<PaginationLinks :paginator="users"/>
```
### Home.vue
```
<script setup>
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

</script>

<template>
    <Head :title="`- ${$page.component }`"/>
    <h1>Home Page</h1>
    <div>
        <table>
            <thead>
                <tr>
                    <th>no.</th>
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

    <PaginationLinks :paginator="users"/>
</template> 
```