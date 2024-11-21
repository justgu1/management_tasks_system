import { createRouter, createWebHistory } from 'vue-router';
import { reactive } from 'vue';

// views
import Login from '@views/user/Login.vue';
import Register from '@views/user/Register.vue';
import Logout from '@views/user/Logout.vue';
import Dashboard from '@views/Dashboard.vue';
import About from '@views/About.vue';
import Tasks from '@views/tasks/index.vue';
import TasksAdd from '@views/tasks/add.vue';
import TasksEdit from '@views/tasks/edit.vue';
import TasksDelete from '@views/tasks/delete.vue';
import NotFound from '@/views/NotFound.vue';
import api from '@utils/api';

const routeState = reactive({
    previousRoute: null,
});

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
        meta: { requiresAuth: true },
    },
    {
        path: '/tasks/add',
        name: 'Adicionar Tarefa',
        component: TasksAdd,
        meta: { requiresAuth: true },
    },
    {
        path: '/tasks/edit/:id',
        name: 'Editar Tarefa',
        component: TasksEdit,
        meta: { requiresAuth: true },
    },
    {
        path: '/tasks/delete/:id',
        name: 'Excluir Tarefa',
        component: TasksDelete,
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
        component: NotFound,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach(async (to, from, next) => {
    routeState.previousRoute = from;

    const ignoreRoutes = ['Login', 'Register'];
    if (ignoreRoutes.includes(to.name)) {
        return next();
    }
    if (to.meta.requiresAuth) {
        const token = localStorage.getItem('user_token');

        if (token) {
            try {
                await api.get('/user/verify');
                return next();
            } catch (error) {
                console.log(error);
                localStorage.removeItem('user_token');
                return next({ name: 'Login', query: { redirect: to.fullPath } });
            }
        } else {
            return next({ name: 'Login', query: { redirect: to.fullPath } });
        }
    }
    next();
});

export { routeState };
export default router;