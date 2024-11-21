<script setup>
import { ref, inject } from 'vue';
import FormGroup from "@components/commoms/FormGroup.vue";
import Button from "@components/commoms/Button.vue";

const api = inject('api');
const router = inject('router');
const errors = ref({});
const form = ref({
    title: '',
    description: '',
    status: '',
});

const validateForm = () => {
    errors.value = {};

    if (!form.value.title) {
        errors.value.title = 'O título é obrigatório.';
    }

    if (!form.value.description) {
        errors.value.description = 'A descrição é obrigatória.';
    }

    if (!form.value.status) {
        errors.value.status = 'O status é obrigatório.';
    }

    return Object.keys(errors.value).length === 0;
};

const submitForm = async () => {
    if (validateForm()) {
        errors.value = {};
        try {
            const response = await api.post('/task', form.value);
            console.log('Tarefa criada:', response);
            if (response) {
                router.push('/tasks');
            }
        } catch (error) {
            console.error(error);
            errors.value.response = `Erro ao criar tarefa: ${error.response?.data?.message || 'Erro desconhecido'
                }`;
        }
    }
};
</script>

<template>
    <div class="flex justify-center items-center h-screen bg-gray-50">
        <form @submit.prevent="submitForm"
            class="sm:max-w-md w-11/12 sm:w-full mx-auto p-6 border border-gray-300 rounded-lg bg-white shadow-md">
            <h1 class="text-xl font-semibold text-gray-800 mb-4">Adicionar Nova Tarefa</h1>

            <div v-if="errors.response"
                class="text-center text-white py-2 px-4 bg-red-500 border border-red-400 rounded mb-4"
                v-html="errors.response"></div>

            <FormGroup id="title" type="text" label="Título" v-model="form.title" :error="errors.title"
                placeholder="Digite o título da tarefa" />

            <FormGroup id="description" type="textarea" label="Descrição" v-model="form.description"
                :error="errors.description" placeholder="Digite a descrição da tarefa" />

            <FormGroup id="status" type="radio" label="Status" v-model="form.status" :error="errors.status"
                :options="['pendente', 'em andamento', 'concluída']" />

            <Button type="submit" text="Salvar Tarefa" class="w-full mt-4" />
        </form>
    </div>
</template>