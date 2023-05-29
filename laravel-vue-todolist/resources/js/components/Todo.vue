<template>
    <div>
        <h1>Title</h1>
        <p>{{ todo.title }}</p>

        <h1>Description</h1>
        <p>{{ todo.description }}</p>

        <h1>Due Date</h1>
        <p>{{ todo.due_date }}</p>

        <h1>Complete</h1>
        <p>{{ todo.complete }}</p>

        <Button class=""><RouterLink to="`/todos/${todo.id}/edit`" >Edit</RouterLink></Button>
    </div>
</template>

<script setup>

import axios from 'axios';
import { onMounted } from 'vue';
import { useRoute } from 'vue-router';

const todo = {};
const route = useRoute();

onMounted(async() => {
try {
    const response = await axios.get(`/api/todos/${route.params.id}`);
    todo.value = response.data;
} catch (error) {
    console.error(error);
}
})

</script>
