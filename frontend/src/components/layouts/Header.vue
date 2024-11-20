<script setup>
import { computed, inject, nextTick } from 'vue';
import { useRouter, useRoute } from 'vue-router';

const routes = inject('routes');
const router = useRouter();
const user = inject('user');
const currentRoute = useRoute();
const children = computed(() => {
    const matchedRoute = currentRoute.matched.find(record => record.path === currentRoute.path);
    return matchedRoute?.children || [];
});
const nav = computed(() => {
    return routes.filter((route) => {
        if (route.name === 'Login' || route.name === 'Register' || route.name === 'Logout' || route.name === 'Nao Existe' || route.name === 'Adicionar Tarefa' || route.name === 'Editar Tarefa' || route.name === 'Excluir Tarefa') {
            return false;
        }

        return true;
    });
});
</script>

<template>
    <header class="grid py-4 px-4 sm:px-10 bg-blue-500 text-white font-bold xl-text-xl grid-cols-12 gap-3 uppercase">
        <nav class="col-span-12 sm:col-span-9">
            <ul class="flex gap-6">
                <li v-for="route in nav" :key="route.name">
                    <router-link :to="route.path">{{ route.name }}</router-link>
                </li>
            </ul>
        </nav>
        <div class="profile col-span-3">
            <div class="top">

            </div>
            <div class="bottom">
                <ul class="flex gap-4 justify-end" v-if="user.length == 0">
                    <li>
                        <router-link :to="'/Login'">Login</router-link>
                    </li>
                    <li>
                        <router-link :to="'/register'">Inscrever-se</router-link>
                    </li>
                </ul>
                <ul class="flex gap-4" v-else>
                    <li>
                        <router-link :to="'/profile'">Perfil</router-link>
                    </li>
                    <li>
                        <router-link :to="'/logout'">Logout</router-link>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <div
        class="py-2 px-4 sm:px-10 text-blue-500 shadow font-bold xl-text-xl grid-cols-12 gap-3 uppercase flex submenu items-center">
        <h2 class="text-2xl text-gray-600 pr-8">
            {{ currentRoute.name }}
        </h2>
        <nav class="col-span-6" v-if="children.length > 0">
            <ul class="flex gap-4">
                <li>
                    <router-link to="/tasks/add"
                        :class="{ 'my-active-class': currentRoute.path === '/tasks/add' }">Adicionar</router-link>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
export default {
    name: 'Header',
};
</script>