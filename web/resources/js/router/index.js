import { createRouter, createWebHistory } from "vue-router";
import Login from "../components/Login.vue";

const routes = [
    {
        path: "/",
        component: Login,
        meta: { requiresAuth: false },
    },
    {
        path: "/login",
        component: Login,
        meta: { requiresAuth: false },
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});
export default router;
