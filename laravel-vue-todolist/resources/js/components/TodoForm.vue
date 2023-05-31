<template>
    <div class="flex justify-center items-center mt-8">
    <form @submit.prevent="submitForm" class="w-full py-8 max-w-lg bg-gray-50 border-2 border-gray-100 rounded px-8">
        <h1 class="font-semibold text-2xl text-center mb-6 uppercase">{{ !isEditTodo ? 'Add Todo' : 'Edit Todo' }}</h1>
        <div class="md:flex md:items-center mb-6">
            <div class="md:w-1/3">
                <label class="block uppercase text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="title">
                    Title
                </label>
            </div>
            <div class="md:w-2/3">
                <input 
                id="title" 
                v-model="todo.title" 
                class="bg-gray-200 appearance-none rounded border-2 w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-black" 
                type="text" 
                placeholder="Title.."
                required
                >
            </div>
        </div>
        <div class="md:flex md:items-center mb-6">
            <div class="md:w-1/3">
                <label class="block uppercase text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="description">
                    Description
                </label>
            </div>
            <div class="md:w-2/3">
                <textarea 
                id="description" 
                v-model="todo.description" 
                class="bg-gray-200 focus:bg-white py-2 px-4 text-gray-700 border-2 focus:border-black focus:outline-none leading-tight appearance-none rounded resize overflow-hidden max-w-full w-full" placeholder="Description.."
                required   
                ></textarea>
            </div>
        </div>
        <div class="md:flex md:items-center mb-6">
            <div class="md:w-1/3">
                <label class="block uppercase text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="due_date">
                    Due Date
                </label>
            </div>
            <div class="md:w-2/3">
                <input id="due_date" v-model="todo.due_date" type="datetime-local" class="bg-gray-200 appearance-none rounded border-2 w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-black" >
                
                <div v-if="isEditTodo" class="flex items-center justify-center">
                    <label for="checkbox" class="text-sm mr-2">Status:</label>
                    <input id="checkbox" type="checkbox" :checked="todo.complete" v-model="todo.complete" class="" name="complete" value="{{ todo.complete }}">
                </div>
            </div>
        </div>
            <div class="flex justify-end">
                <button type="submit" class="shadow uppercase bg-blue-500 hover:bg-blue-600 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">
                    {{ !isEditTodo ? 'Add Todo' : 'Update Todo' }}
                </button>
            </div>
    </form>
    </div>
</template>

<script setup>

import {computed, onMounted, ref} from "vue";
import moment from "moment";
import axios from "axios";
import {useRouter, useRoute} from "vue-router";

const todo = ref({
    title:'',
    description: '',
    due_date: moment().format('MM-DD-YYYY hh:mm'),
    complete: false
});

const router = useRouter();
const route = useRoute();

// base route /todos
// If the current route doesn't include /edit
const isEditTodo = computed(() => {
    return route.path.includes('edit');
});

onMounted(async () => {
        if(isEditTodo.value == true){
            const response = await axios.get(`/api/todos/${route.params.id}`);
            todo.value.due_date = moment().format('MM-DD-YYYY hh:mm');
            todo.value = response.data;
        }
    
})

const submitForm = async () =>{
    try {
        console.log(isEditTodo.value);
        if (isEditTodo.value == false){
            await axios.post('/api/todos', todo.value);
        }
        else {
            console.log(isEditTodo.value);
            await axios.put(`/api/todos/${route.params.id}`, todo.value);
        }
        router.push('/');
    } catch (error){
        console.error(error);
    }
}


</script>
