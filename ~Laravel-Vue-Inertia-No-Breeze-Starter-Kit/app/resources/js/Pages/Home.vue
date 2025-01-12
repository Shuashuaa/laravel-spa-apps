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

    <PaginationLinks :paginator="users"/>
</template> 