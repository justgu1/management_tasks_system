<script setup>
import { useRouter } from 'vue-router';
import { ref, inject } from 'vue';
import FormGroup from "@components/commoms/FormGroup.vue";
import Button from "@components/commoms/Button.vue";
import Link from "@components/commoms/Link.vue";

const api = inject('api');
const router = useRouter();
const errors = ref({});
const form = ref({
    name: '',
    email: '',
    password: '',
});

const validateForm = () => {
    errors.value = {};

    if (!form.value.name) {
        errors.value.name = 'O nome é obrigatório.';
    }

    if (!form.value.email) {
        errors.value.email = 'O e-mail é obrigatório.';
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.value.email)) {
        errors.value.email = 'O e-mail não é válido.';
    }

    if (!form.value.password) {
        errors.value.password = 'A senha é obrigatória.';
    } else if (form.value.password.length < 6) {
        errors.value.password = 'A senha deve ter pelo menos 6 caracteres.';
    }

    return Object.keys(errors.value).length === 0;
};

const submitForm = async (userData) => {
    if (validateForm()) {
        try {
            const response = await api.post('/user/register', form.value);

            router.push('/login/?registered=true');
        } catch (error) {
            let message = '';
            errors.value = {};
            switch (error.response.status) {
                case 422:
                    message = 'Já existe uma conta com este email.';
                    break;

                default:
                    message = error.response.data.message;
                    break;
            }
            errors.value.response = `Erro ao criar usuário.<br> ${message}`
        }
    }
};
</script>

<template>
    <div class="flex justify-center items-center align-center h-screen">
        <form @submit.prevent="submitForm"
            class="sm:max-w-md w-11/12 sm:w-full mx-auto p-6 border border-gray-300 rounded-lg bg-gray-50">
            <div v-if="errors.response"
                class=" text-center text-gray-100 py-2 px-4 bg-red-500 border border-gray-300 rounded-lg bg-gray-50 mb-4"
                v-html="errors.response"></div>

            <FormGroup type="text" label="Nome" id="name" v-model="form.name" :error="errors.name"
                placeholder="Digite seu nome">
            </FormGroup>

            <FormGroup type="email" label="E-mail" id="email" v-model="form.email" :error="errors.email"
                placeholder="Digite seu Email">
            </FormGroup>

            <FormGroup type="password" label="Senha" id="password" v-model="form.password" :error="errors.password"
                placeholder="Digite sua senha">
            </FormGroup>

            <Button type="submit" text="Entrar" />
            <Link href="/login" text="Não tem uma conta? clique aqui" />
        </form>
    </div>
</template>

<script>
export default {
    name: 'Register',
    components: {
        FormGroup,
        Button,
        Link
    },
};
</script>