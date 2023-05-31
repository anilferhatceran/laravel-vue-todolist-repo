<template>
    <nav class="flex items-center justify-between flex-wrap bg-white p-6">
        <div class="flex items-center flex-shrink-0 mr-6">
            <span class="font-semibold text-2xl tracking-tight mr-2"><RouterLink to="/">wecode</RouterLink></span>
            <RouterLink to="/" class="mx-2 text-gray-700 hover:text-black">Home</RouterLink>
            <RouterLink to="/todos/create" class="ml-2 text-gray-700 hover:text-black">Add Todo</RouterLink>
        </div>

        <div>
            <RouterLink to="/register" class="text-gray-700 hover:text-black">Register</RouterLink>
            <RouterLink to="/login" class="ml-2 text-gray-700 hover:text-black">Login</RouterLink>
        </div>

    </nav>
    <div class="p-6">
        <RouterView></RouterView>
    </div>
</template>
<script setup>

</script>
