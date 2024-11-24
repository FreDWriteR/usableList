import { createRouter, createWebHistory } from 'vue-router';
import ExpandableList from '../Components/ExpandableList.vue';

const routes = [
    {
        path: '/',
        name: 'home',
        component: ExpandableList,
    },
];

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes,
});

export default router;
