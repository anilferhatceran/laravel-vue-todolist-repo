<template>
    <div>
        <h1>This is App</h1>

        <RouterLink to="/">Home</RouterLink>
        <RouterLink to="/todos/create">Add Todo</RouterLink>
        <RouterView></RouterView>
    </div>
</template>
<script setup>

import {onMounted} from "vue";

onMounted(() => {
    console.log('App mounted');
})

</script>
