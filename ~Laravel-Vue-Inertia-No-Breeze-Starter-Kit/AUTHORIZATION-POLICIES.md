# AUTHORIZATION - POLICIES

# Make a Policy
```
php artisan make:policy UserPolicy
```

<br>
<br>
<br>

# Configure the policy

### app/Policies/UserPolicy.php
> authenticate the user if email is equal to `j@j`
```
<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function delete(User $user)
    {
        return $user->email === 'j@j';
    }
}
```

<br>
<br>

# `can()` Checks if a user has permission to perform a specific action on a given resource.
```
'can' => [
    'delete_user' => Auth::user() 
        ? Auth::user()->can('delete', User::class) 
        : null
]
```
### web.php
```
<?php

use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function(Request $request){
    return inertia('Home', [
        'users' => User::when($request->search, function($query) use ($request ){
            $query
            ->where('name', 'like', '%' . $request->search . '%')
            // this
            ->orWhere();
        })->paginate(5)->withQueryString(),

        'searchTerm' => $request->search,
        
        //convention from inertia docs | This checks the permission declared in the UserPolicy
        'can' => [
            'delete_user' => Auth::user() 
                ? Auth::user()->can('delete', User::class) 
                : null
        ]
    ]);
})->name('home');

```

<br>
<br>

# Use the `can.delete_user` props to hide and show content
```
const props = defineProps({
    users: Object,
    searchTerm: String,
    can: Object
})

<th v-if="can.delete_user">delete</th>

<td v-if="can.delete_user">
    <button class="h-15 w-15 rounded-3xl p-5 bg-red-400"></button>
</td>
```
### Home.vue
```
<script setup>
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3'
import PaginationLinks from './Components/PaginationLinks.vue';
import { debounce } from 'lodash';

const props = defineProps({
    users: Object,
    searchTerm: String,
    can: Object
})

const search = ref(props.searchTerm);

watch(search, debounce(
    (q) => router.get('/', { search: q }, { preserveState: true }),
    500
)
)

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
                    <th v-if="can.delete_user">delete</th>
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
                    <td v-if="can.delete_user">
                        <button class="h-15 w-15 rounded-3xl p-5 bg-red-400"></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div>
        <PaginationLinks :paginator="users"/>
    </div>
    
</template> 
```