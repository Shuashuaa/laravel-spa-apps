<script setup>
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    avatar: null,
    preview: null
})

const change = (e) => {
    form.avatar = e.target.files[0];
    form.preview = URL.createObjectURL(e.target.files[0]);
    console.log(form.avatar)
}

const submit = () => {
    form.post('/upload',{
        onSuccess: () => form.reset()
    });
}
</script>

<template>
    <form @submit.prevent="submit">
        <div class="flex flex-col items-center justify-center gap-5 h-100 bg-gray-300">
            <h1 class="text-3xl font-bold underline">
                An aws file uploading app
            </h1>
        
            <div class="relative w-28 h-28 rounded-full overflow-hidden border border-slate-300 hover:border-2 hover:border-white">
                <label for="avatar" class="absolute inset-0 grid content-end cursor-pointer">
                    <span class="bg-white/70 pb-2 text-center">Avatar</span>
                </label>
                <input type="file" @input="change" id="avatar" hidden/>
        
                <img class="object-cover w-28 h-28" :src="form.preview ?? 'storage/default.jpg'" alt=""/>
            </div>
            <button class="border border-slate-600 rounded-lg py-1 px-2">Submit</button>
        </div>
        
    </form>
    
</template>