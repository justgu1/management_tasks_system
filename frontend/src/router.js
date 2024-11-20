import { createRouter, createWebHistory } from 'vue-router';

// views
import Login from '@views/user/Login.vue';
import Register from '@views/user/Register.vue';
import Logout from '@views/user/Logout.vue';
import Dashboard from '@views/Dashboard.vue';
import About from '@views/About.vue';
import Tasks from '@views/tasks/index.vue';
import NotFound from '@/views/NotFound.vue';
import api from '@utils/api';
const routes = [
    {
        path: '/login',
        name: 'Login',
        component: Login,
    },
    {
        path: '/register',
        name: 'Register',
        component: Register,
    },
    {
        path: '/logout',
        name: 'Logout',
        component: Logout,
        meta: { requiresAuth: true },
    },
    {
        path: '/',
        name: 'Dashboard',
        component: Dashboard,
        meta: { requiresAuth: true },
    },
    {
        path: '/tasks',
        name: 'Tarefas',
        component: Tasks,
        children: [
            {
                path: 'add',
                name: 'Adicionar Tarefa',
                component: About,
            },
            {
                path: 'edit',
                name: 'Editar Tarefa',
                component: About,
            },
            {
                path: 'remove',
                name: 'Excluir Tarefa',
                component: About,
            },
        ],
        meta: { requiresAuth: true },
    },
    {
        path: '/about',
        name: 'Sobre',
        component: About,
        meta: { requiresAuth: true },
    },
    {
        path: '/:catchAll(.*)',
        name: 'Nao Existe',
        component: () => import('@/views/NotFound.vue'), // Página 404
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach(async (to, from, next) => {
    if (to.meta.requiresAuth) {
        const token = localStorage.getItem('user_token');

        if (token) {
            try {
                await api.get('/user/verify');
                next();
            } catch (error) {
                console.log(error);
                localStorage.removeItem('user_token');
                next({ name: 'Login', query: { redirect: to.fullPath } });
            }
        } else {
            next({ name: 'Login', query: { redirect: to.fullPath } });
        }
    } else {
        next();
    }
});

export default router;