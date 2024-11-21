<script setup>
import { routeState } from '@/router';
import { ref, onMounted, inject, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import api from '@utils/api';

const route = useRoute();
const router = useRouter();
const task = ref({});
const loading = ref(true);
const errors = ref({});
const isModalOpen = ref(false);
const previousRoute = computed(() => routeState.previousRoute);

const fetchTask = async () => {
    const taskId = route.params.id;
    try {
        const response = await api.get(`/task/${taskId}`);
        task.value = response;
        console.log(task.value)
    } catch (error) {
        console.log('Erro ao carregar a tarefa', error);
        errors.value.response = 'Erro ao carregar a tarefa. Tente novamente.';
    } finally {
        loading.value = false;
    }
};

const deleteTask = async () => {
    const taskId = route.params.id;
    try {
        await api.delete(`/task/${taskId}`);
        router.push('/tasks');
    } catch (error) {
        console.log(error);
        errors.value.response = 'Erro ao excluir a tarefa.';
    }
};

const openModal = () => {
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
};

const cancelDelete = () => {
    if (previousRoute && previousRoute.fullPath) {
            router.push(previousRoute.fullPath);
        } else {
            router.push('/');
        }
};

onMounted(() => {
    fetchTask();
});
</script>

<template>
    <div v-if="loading" class="flex justify-center items-center h-screen">
        <span>Carregando...</span>
    </div>
    <div v-else class="flex justify-center items-center h-screen">
        <div class="sm:max-w-md w-11/12 sm:w-full mx-auto p-6 border border-gray-300 rounded-lg bg-gray-50">
            <div v-if="errors.response"
                class="text-center text-gray-100 py-2 px-4 bg-red-500 border border-gray-300 rounded-lg mb-4"
                v-html="errors.response"></div>

            <h2 class="text-xl font-semibold">Tarefa: {{ task.title }}</h2>
            <p class="mt-2">{{ task.description }}</p>
            <p class="mt-2">Status: {{ task.status }}</p>

            <button @click="openModal" class="mt-4 bg-red-500 text-white py-2 px-4 rounded-md">Deletar Tarefa</button>
        </div>
    </div>

    <div v-if="isModalOpen" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-80">
            <h3 class="text-lg font-semibold mb-4">Tem certeza que deseja deletar a tarefa {{ task.title }}?</h3>
            <div class="flex justify-end space-x-4">
                <button @click="cancelDelete" class="bg-gray-300 text-gray-700 py-2 px-4 rounded-md">Cancelar</button>
                <button @click="deleteTask" class="bg-red-500 text-white py-2 px-4 rounded-md">Deletar</button>
            </div>
        </div>
    </div>
</template>

<style scoped>
.fixed {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
}

.bg-gray-500 {
    background-color: rgba(0, 0, 0, 0.5);
}

.bg-white {
    background-color: white;
}
</style>
