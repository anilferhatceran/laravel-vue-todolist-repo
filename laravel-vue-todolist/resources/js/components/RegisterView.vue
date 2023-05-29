<template>
    <div class="flex justify-center mt-6">
    <form @submit.prevent="submitForm" class="w-full max-w-lg bg-gray-50 border-2 border-gray-100 py-8 rounded px-8">
        <h1 class="font-semibold text-2xl text-center mb-6 uppercase">Register</h1>
        <div class="md:flex md:items-center mb-6">
            <div class="md:w-1/3">
                <label class="block uppercase text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="name">
                    Name
                </label>
            </div>
            <div class="md:w-2/3">
                <input 
                id="name" 
                v-model="user.name" 
                class="bg-gray-200 appearance-none rounded border-2 w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-black" 
                type="text" 
                placeholder="Your name.."
                required
                >
            </div>
        </div>
        <div class="md:flex md:items-center mb-6">
            <div class="md:w-1/3">
                <label class="block uppercase text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="email">
                    Email
                </label>
            </div>
            <div class="md:w-2/3">
                <input 
                id="email" 
                v-model="user.email" 
                class="bg-gray-200 appearance-none rounded border-2 w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-black" 
                type="email" 
                placeholder="Your email.."
                required
                >
            </div>
        </div>
        <div class="md:flex md:items-center mb-6">
            <div class="md:w-1/3">
                <label class="block uppercase text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="password">
                    Password
                </label>
            </div>
            <div class="md:w-2/3">
                <input 
                id="password" 
                v-model="user.password" 
                class="bg-gray-200 appearance-none rounded border-2 w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-black" 
                type="password" 
                placeholder="Your password.."
                required
                >
            </div>
        </div>
            <div class="flex justify-end">
                <button type="submit" class="shadow uppercase bg-blue-500 hover:bg-blue-600 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">
                    Register
                </button>
            </div>
    </form>
    </div>
</template>

<script setup>
import axios from "axios";
import { ref } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();


const user = ref({
    'name': '',
    'email':'',
    'password': ''
});

const submitForm = async() => {
    try {
        await axios.post('/api/register', user.value);
        router.push('/');
    } catch (error) {
        console.error(error);
    }
}


</script>
