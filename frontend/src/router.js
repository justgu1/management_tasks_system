import { createRouter, createWebHistory } from 'vue-router';

// views
import Guest from '@views/Guest.vue';

const routes = [
    {
        path: '/',
        name: 'Guest',
        component: Guest,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;