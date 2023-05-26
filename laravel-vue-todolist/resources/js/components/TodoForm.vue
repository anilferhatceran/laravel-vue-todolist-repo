<template>
    <div class="flex justify-center mt-6">
    <form @submit.prevent="submitForm" class="w-full max-w-lg bg-gray-50 border-2 border-gray-100 py-8 rounded px-8">
        <h1 class="font-semibold text-2xl text-center mb-6 uppercase">Add todo</h1>
        <div class="md:flex md:items-center mb-6">
            <div class="md:w-1/3">
                <label class="block uppercase text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="title">
                    Title
                </label>
            </div>
            <div class="md:w-2/3">
                <input class="bg-gray-200 appearance-none rounded border-2 w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-black" id="inline-full-name" type="text" placeholder="Title..">
            </div>
        </div>
        <div class="md:flex md:items-center mb-6">
            <div class="md:w-1/3">
                <label class="block uppercase text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="description">
                    Description
                </label>
            </div>
            <div class="md:w-2/3">
                <textarea class="bg-gray-200 focus:bg-white py-2 px-4 text-gray-700 border-2 focus:border-black focus:outline-none leading-tight appearance-none rounded resize overflow-hidden max-w-full w-full" placeholder="Description.."></textarea>
            </div>
        </div>
        <div class="md:flex md:items-center mb-6">
            <div class="md:w-1/3">
                <label class="block uppercase text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="due_date">
                    Due Date
                </label>
            </div>
            <div class="md:w-2/3">
                <input type="datetime-local" class="bg-gray-200 appearance-none rounded border-2 w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-black" >
            </div>
        </div>
            <div class="flex justify-end">
                <button class="shadow uppercase bg-blue-500 hover:bg-blue-600 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" type="button">
                    Add Todo
                </button>
            </div>
    </form>
    </div>
</template>

<script setup>

import {onMounted} from "vue";
import axios from "axios";

const todo = {
    title:'',
    description: '',
    due_date: '',
}

function isNewTodo() {
    // base route /todos
    // If the current route doesn't include /edit
    return !this.$route.path.includes('edit');
}

onMounted(async () => {
    if(!this.isNewTodo){
        const response = await axios.get(`/api/todos/${this.$route.params.id}`);
        todo.value = response.data;
    }
})

async function submitForm(){
    try {
        if (this.isNewTodo){
            await axios.post('/api/todos', todo.value);
        }
        else {
            await axios.put(`/api/todos/${this.$route.params.id}`, todo.value);
        }
        await this.$router.push('/');
    } catch (error){
        console.error(error);
    }
}


</script>
