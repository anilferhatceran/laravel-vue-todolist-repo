<template>
    <nav class="flex items-center justify-between flex-wrap bg-white p-6">
        <div class="flex items-center flex-shrink-0 mr-6">
            <span class="font-semibold text-2xl tracking-tight mr-2"><RouterLink to="/">wecode</RouterLink></span>
            <RouterLink to="/" class="mx-2 text-gray-700 hover:text-black">Home</RouterLink>
            <RouterLink to="/todos/create" class="ml-2 text-gray-700 hover:text-black">Add Todo</RouterLink>
        </div>

        <div v-if="currentUser">
            <span class="font-semibold text-gray-600">{{currentUser && currentUser.name}}</span>
        </div>

        <div>
            <RouterLink to="/register" class="text-gray-700 hover:text-black">{{currentUser ? 'Register another account' : 'Register'}}</RouterLink>
            <RouterLink to="/login" class="ml-2 text-gray-700 hover:text-black">{{currentUser ? 'Change account' : 'Login'}}</RouterLink>
        </div>
    </nav>
    <div class="p-6">
        <RouterView></RouterView>
    </div>

</template>
<script setup>
import axios from "axios";
import {onMounted, onUpdated, ref} from "vue";
axios.defaults.withCredentials = true;

let refreshKey = false;

const currentUser = ref();

onMounted(async() => {
    try {
            await axios.get('/sanctum/csrf-token');
            const response = await axios.get('/api/user');

            refreshKey = true;
            return currentUser.value = response.data;

    }catch (error){
        console.error(error);

    }
})



</script>
