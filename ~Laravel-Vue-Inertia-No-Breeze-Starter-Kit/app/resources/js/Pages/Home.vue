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