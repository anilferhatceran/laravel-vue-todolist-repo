<template>
    <div>
        <div v-if="todos.length >= 1" class="flex flex-row">
            <div class="flex flex-col w-1/2 mr-2">
                <h1 class="text-3xl font-semibold mb-6">In Progress</h1>
                <div
                    class="flex flex-row flex-wrap gap-y-4 gap-x-2 border border-gray-100 px-4 py-6 w-full bg-gray-50"
                >
                    <TransitionGroup name="inProgress">
                        <div
                            v-for="todo in inProgressList"
                            :key="todo.id"
                            draggable="true"
                            @dragstart="startDrag($event, todo)"
                            @drop="onDrop($event, todo)"
                            @dragover.prevent
                            @dragenter.prevent
                            class="bg-white h-max rounded overflow-hidden shadow-xl"
                        >
                            <div class="flex px-6 py-4 w-full justify-between">
                                <div
                                    class="font-semibold text-xl mr-2 text-gray-700 hover:text-black hover:underline"
                                >
                                    <RouterLink
                                        :to="`/todos/${todo.id}/edit`"
                                        >{{ todo.title }}</RouterLink
                                    >
                                </div>
                                <button
                                    @click="deleteTodo(todo.id)"
                                    class="text-xl hover:text-red-500 hover:font-bold"
                                >
                                    &times;
                                </button>
                            </div>
                            <div class="px-6 py-2">
                                <p class="text-gray-700 text-base">
                                    {{ todo.description }}
                                </p>
                            </div>
                            <div
                                class="items-center mb-2 px-6 pt-4 pb-2 flex w-max justify-evenly"
                            >
                                <label class="text-sm mr-2">Due Date:</label>
                                <span
                                    class="bg-gray-200 rounded-full px-3 py-1 text-xs font-semibold text-gray-700 mr-2"
                                    >{{ todo.due_date }}</span
                                >
                                <div class="flex items-center justify-center">
                                    <label for="checkbox" class="text-sm mr-2"
                                        >Status:</label
                                    >
                                    <input
                                        id="checkbox"
                                        type="checkbox"
                                        @change="updateTodoStatus(todo)"
                                        v-model="todo.complete"
                                        :checked="todo.complete"
                                        value="{{ todo.complete }}"
                                    />
                                </div>
                            </div>
                        </div>
                    </TransitionGroup>
                </div>
            </div>
            <div class="flex flex-col w-1/2">
                <h1 class="text-3xl font-semibold mb-6">Completed</h1>
                <div
                    class="flex flex-row flex-wrap gap-y-4 gap-x-2 border border-gray-100 px-4 py-6 w-full bg-gray-50"
                >
                    <TransitionGroup name="completed">
                        <div
                            v-for="todo in completedList"
                            :key="todo.id"
                            draggable="true"
                            @dragstart="startDrag($event, todo)"
                            @drop="onDrop($event, todo)"
                            @dragover.prevent
                            @dragenter.prevent
                            class="rounded bg-white h-max overflow-hidden shadow-xl"
                        >
                            <div class="flex px-6 py-4 w-full justify-between">
                                <div
                                    class="font-semibold text-xl mr-2 text-gray-700 hover:text-black hover:underline"
                                >
                                    <RouterLink
                                        :to="`/todos/${todo.id}/edit`"
                                        >{{ todo.title }}</RouterLink
                                    >
                                </div>
                                <button
                                    @click="deleteTodo(todo.id)"
                                    class="text-xl hover:text-red-500 hover:font-bold"
                                >
                                    &times;
                                </button>
                            </div>
                            <div class="px-6 py-2">
                                <p class="text-gray-700 text-base">
                                    {{ todo.description }}
                                </p>
                            </div>
                            <div
                                class="items-center mb-2 px-6 pt-4 pb-2 flex w-max justify-between"
                            >
                                <label class="text-sm mr-2">Due Date:</label>
                                <span
                                    class="bg-gray-200 rounded-full px-3 py-1 text-xs font-semibold text-gray-700 mr-2"
                                    >{{ todo.due_date }}</span
                                >
                                <div class="flex items-center justify-center">
                                    <label for="checkbox" class="text-sm mr-2"
                                        >Status:</label
                                    >
                                    <input
                                        id="checkbox"
                                        type="checkbox"
                                        @change="updateTodoStatus(todo)"
                                        v-model="todo.complete"
                                        :checked="todo.complete"
                                        value="{{ todo.complete }}"
                                    />
                                </div>
                            </div>
                        </div>
                    </TransitionGroup>
                </div>
            </div>
        </div>

        <div v-else-if="currentUser">
            <h1 class="text-gray-500 text-4xl text-center italic font-semibold">
                You do not have any todos added. Start by clicking
                <RouterLink to="/todos/create" class="underline"
                    >"Add todo"</RouterLink
                >
            </h1>
        </div>
        <div v-else>
            <h1 class="text-gray-500 text-4xl text-center italic font-semibold">
                You are not authorized to view this page. Please
                <RouterLink to="/register" class="underline"
                    >register</RouterLink
                >
                or <RouterLink to="/login" class="underline">login.</RouterLink>
            </h1>
        </div>
    </div>
</template>

<script setup>
import axios from "axios";
import { computed, onMounted, ref } from "vue";

axios.defaults.withCredentials = true;

const todos = ref([]);

const currentUser = ref();

const inProgressList = computed(() => {
    return todos.value.filter((todo) => !todo.complete);
});
const completedList = computed(() => {
    return todos.value.filter((todo) => todo.complete);
});

onMounted(async () => {
    try {
        await axios.get("/sanctum/csrf-token");
        const response = await axios.get("/api/user");
        currentUser.value = response.data;

        if (currentUser.value) {
            const todosApi = await axios.get("/api/todos");
            return (todos.value = todosApi.data);
        }
    } catch (error) {
        console.error(error);
    }
});

const updateTodoStatus = async (todo) => {
    try {
        await axios.put(`/api/todos/${todo.id}`, todo);
    } catch (error) {
        console.error(error);
    }
};

const deleteTodo = async (id) => {
    try {
        await axios.delete(`/api/todos/${id}`);
        todos.value = todos.value.filter((todos) => todos.id !== id);
    } catch (error) {
        console.error(error);
    }
};

const startDrag = (event, todo) => {
    event.dataTransfer.dropEffect = "move";
    event.dataTransfer.effectAllowed = "move";
    event.dataTransfer.setData("todoID", todo.id);
};
const onDrop = async (event) => {
    const todoItemID = event.dataTransfer.getData("todoID");
    const todoObj = todos.value.find((todo) => todo.id == todoItemID);

    todoObj.complete = !todoObj.complete;

    await axios.put(`/api/todos/${todoObj.id}`, todoObj);
};
</script>

<style scoped>
.inProgress-enter-active,
.inProgress-leave-active {
    transition: all 0.3s ease;
}
.inProgress-enter-from,
.inProgress-leave-to {
    opacity: 0;
    transform: translateX(30px);
}

.completed-enter-active,
.completed-leave-active {
    transition: all 0.3s ease;
}
.completed-enter-from,
.completed-leave-to {
    opacity: 0;
    transform: translateX(30px);
}
</style>
