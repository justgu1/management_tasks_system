<script setup>
import { ref, onMounted, inject } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import FormGroup from '@components/commoms/FormGroup.vue';
import Button from '@components/commoms/Button.vue';
import api from '@utils/api';

const route = useRoute();
const router = useRouter();

const form = ref({
    title: '',
    description: '',
    status: '',
});

const errors = ref({});
const loading = ref(true);

const fetchTask = async () => {
    const taskId = route.params.id;
    try {
        const response = await api.get(`/task/${taskId}`);
        form.value = {
            title: response.title,
            description: response.description,
            status: response.status,
        };
    } catch (error) {
        console.log('Erro ao carregar a task', error);
        errors.value.response = 'Erro ao carregar a tarefa. Tente novamente.';
    } finally {
        loading.value = false;
    }
};

const validateForm = () => {
    errors.value = {};

    if (!form.value.title) {
        errors.value.title = 'O título é obrigatório.';
    }

    if (!form.value.status) {
        errors.value.status = 'O status é obrigatório.';
    }

    return Object.keys(errors.value).length === 0;
};

const submitForm = async () => {
    if (validateForm()) {
        errors.value = {};
        const taskId = route.params.id;
        try {
            await api.put(`/task/${taskId}`, form.value);
            router.push('/tasks');
        } catch (error) {
            console.log(error);
            errors.value.response = 'Erro ao atualizar a task.';
        }
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
        <form @submit.prevent="submitForm"
            class="sm:max-w-md w-11/12 sm:w-full mx-auto p-6 border border-gray-300 rounded-lg bg-gray-50">
            <div v-if="errors.response"
                class="text-center text-gray-100 py-2 px-4 bg-red-500 border border-gray-300 rounded-lg bg-gray-50 mb-4"
                v-html="errors.response"></div>

            <FormGroup label="Título" id="title" v-model="form.title" :error="errors.title"
                placeholder="Digite o título da tarefa" />

            <FormGroup label="Descrição" id="description" v-model="form.description" :error="errors.description"
                placeholder="Digite a descrição da tarefa" type="textarea" />

            <FormGroup label="Status" id="status" v-model="form.status" :error="errors.status"
                :options="['pendente', 'em andamento', 'concluída']" type="radio" />

            <Button type="submit" text="Salvar alterações" />
        </form>
    </div>
</template>

<script>
export default {
    name: 'EditTask',
    components: {
        FormGroup,
        Button,
    },
};
</script>
