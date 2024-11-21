<script setup>
import { ref, inject } from 'vue';
import FormGroup from "@components/commoms/FormGroup.vue";
import Button from "@components/commoms/Button.vue";
import Link from "@components/commoms/Link.vue";

const api = inject('api');

const router = inject('router');
const route = inject('route');
const errors = ref({});
const form = ref({
    name: '',
    email: '',
    password: '',
});

const validateForm = () => {
    errors.value = {};

    if (!form.value.email) {
        errors.value.email = 'O e-mail é obrigatório.';
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.value.email)) {
        errors.value.email = 'O e-mail não é válido.';
    }

    if (!form.value.password) {
        errors.value.password = 'A senha é obrigatória.';
    }

    return Object.keys(errors.value).length === 0;
};

const submitForm = async (userData) => {
    if (validateForm()) {
        errors.value = {};
        let message = '';
        try {
            const response = await api.post('/user/login', form.value);
            if (response.token) {
                localStorage.setItem('user_token', response.token);
                localStorage.setItem('user_name', response.user.name);
                localStorage.setItem('user_email', response.user.email);
                api.api.defaults.headers.common['Authorization'] = `Bearer ${response.token}`;

                const redirect = route.query.redirect || '/';
                router.push(redirect);
            }
        } catch (error) {
            console.log(error);
            if (error.response?.status === 401) {
                message = 'Credenciais inválidas. Verifique o e-mail e senha.';
            } else {
                message = `Erro ao fazer login: ${error.response?.data?.message || 'Erro desconhecido'}`;
            }
            errors.value.response = `Erro ao criar usuário<br>${message}`
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

            <FormGroup type="email" label="E-mail" id="email" v-model="form.email" :error="errors.email"
                placeholder="Digite seu Email">
            </FormGroup>

            <FormGroup type="password" label="Senha" id="password" v-model="form.password" :error="errors.password"
                placeholder="Digite sua senha">
            </FormGroup>

            <Button type="submit" text="Entrar" />
            <Link href="/register" text="Não tem uma conta? clique aqui" />
        </form>
    </div>
</template>

<script>
export default {
    name: 'Login',
    components: {
        FormGroup,
        Button,
        Link
    },
};
</script>