import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '../modules/auth/auth.store';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            name: 'home',
            meta: { title: 'Home' },
            redirect: 'login',
            children: [
                {
                    path: '/login',
                    name: 'login',
                    meta: { title: 'Iniciar sesion', requiresAuth: false },
                    component: async () => await import('../modules/auth/login/login.vue'),
                },
                {
                    path: '/register',
                    name: 'register',
                    meta: { title: 'register', requiresAuth: false },
                    component: async () => await import('../modules/auth/register/register.vue'),
                },
                {
                    path: '/menu',
                    name: 'menu',
                    meta: { title: 'Menu', requiresAuth: true },
                    component: async () => await import('../modules/menu/menu.vue'),
                },
                {
                    path: '/menu/config',
                    name: 'config',
                    meta: { title: 'Configuracion', requiresAuth: true },
                    component: async () => await import('../modules/configuracion/configuracion.vue'),
                },
                {
                    path: '/empleados',
                    name: 'empleados',
                    meta: { title: 'empleados', requiresAuth: true },
                    component: async () => await import('../modules/empleados/empleados.vue'),
                }

            ],
        }
    ]
})

router.beforeEach(async (to, from, next) => {
    document.title = `WebApp - ${to.meta.title}`;
    const auth = useAuthStore();
    auth.Action_User();
    console.log(auth.isAuthenticated);
    if(to.meta.requiresAuth && !auth.isAuthenticated){
        location.href = "/login";
    }else if(!to.meta.requiresAuth && auth.isAuthenticated){
        location.href = "/menu";
    } else {
        next();
    }
})
export default router
