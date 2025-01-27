<script setup>
import { Link, useForm } from '@inertiajs/vue3';

defineProps({
    books: Object,
    carts: Object
})

const form = useForm({});

const addtocart = (data) => {
    form.post(route('carts.store', data));
}

const updateBookPcs = (id, type) => {
    form.post(route('carts.increment_decrement', {id, type}));
}

const removeBook = (id) => {
    if(confirm('Are you sure you want to add this book to cart?')){
        form.delete(route('carts.destroy', id));
    }
}
</script>

<template>
    <div class="flex mt-2 mr-2">
        <div v-if="carts.length > 0">
            <!-- {{ carts }} -->
            <h1 class="m-2 text-lg">Cart</h1>
            <table class="w-3/4 m-2">
                <thead>
                    <tr class="*:border *:border-gray-400 *:p-2">
                        <th>title</th>
                        <th>pcs</th>
                        <th>image</th>
                        <th>price</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="*:border *:border-gray-400 *:p-2" 
                    v-for="(item, index) in carts" :key="index"
                    >
                        <td>{{ item.name }}</td>
                        <td>
                            <b class="flex gap-2 items-center">
                                <Link @click="updateBookPcs(item.id, 'decrement')" class="border border-gray-300 p-2 cursor-pointer">-</Link>
                                <p>{{ item.pcs }}</p>
                                <Link @click="updateBookPcs(item.id, 'increment')" class="border border-gray-300 p-2 cursor-pointer">+</Link>
                            </b>
                        </td>
                        <td>{{ item.cover_img }}</td>
                        <td>${{ item.price * item.pcs }}</td>
                        <td>
                            <Link @click="removeBook(item.id)" class="border border-gray-500 p-2 hover:bg-red-300 cursor-pointer">
                                remove
                            </Link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div>
            <h2>hello!, <b>{{ $page.props.auth.user.name }}</b></h2>
            <Link :href="route('logout')" method="post" as="button" class="nav-link">Logout</Link>
        </div>
    </div>
    

    <div class="flex flex-wrap justify-center gap-2 mt-2">
        <div class="text-center w-[300px] border border-slate-400 p-3 shadow-lg" 
        v-for="(book, index) in books" :key="index"
        >
            <h3 class="text-3xl">{{book.title}}</h3>
            <p class="text-xl">${{book.price}}</p>
            <img class="mx-auto mb-2" :src="book.cover_img" width="100" alt="">
            <Link class="border border-gray-400 p-2 rounded-md cursor-pointer" @click="addtocart(book)">add to cart</Link>
        </div>
    </div>

</template>