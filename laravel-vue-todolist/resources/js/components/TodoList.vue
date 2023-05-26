<template>
    <h1 class="text-3xl font-semibold mb-6">Your Todos</h1>
<div class="flex flex-wrap gap-8 m-2">
    <div v-for="todo in todos" :key="todos.id" class="max-w-sm rounded overflow-hidden shadow-xl flex-wrap flex">
        <div class="flex px-6 py-4 w-full justify-between">
            <div class="font-semibold text-xl">{{ todo.title }}</div>
            <button  class="text-xl hover:text-red-500 hover:font-bold" >&times;</button>
        </div>
        <div class="px-6 py-2">
            <p class="text-gray-700 text-base">
                {{ todo.description }}
            </p>
        </div>

        <div class="flex items-center mb-2 px-6 pt-4 pb-2 flex w-full justify-between">
            <span class="bg-gray-200 rounded-full px-3 py-1 text-xs font-semibold text-gray-700 mr-2">{{todo.due_date}}</span>
            <div class="flex items-center justify-center">
                <label for="checkbox" class="text-sm mr-2">Mark as complete:</label>
                <input id="checkbox" type="checkbox" class="" name="complete">
            </div>
        </div>

    </div>
</div>



</template>


<script setup>
import axios from 'axios';
import {onMounted, ref} from "vue";

const todos = ref([]);

onMounted(async() => {
    try {
        const response = await axios.get("/api/todos");
        todos.value = response.data;
    }
    catch (error){
        console.error(error);
    }
});





</script>
