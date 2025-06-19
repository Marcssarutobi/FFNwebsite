import { createRouter, createWebHistory } from "vue-router";
import axiosInstance from "../plugin/axios"

const routes = [
    {
        path:'/',
        component: ()=>import('../userPage/contentWrapper.vue'),
        children:[
            {
                path: '',
                component: ()=>import('../userPage/pages/home.vue'),
            },
            {
                path: 'about',
                component: ()=>import('../userPage/pages/about.vue'),
            },
            {
                path: 'project',
                component: ()=>import('../userPage/pages/project.vue'),
            },
            {
                path: 'singleproject/:slug',
                component: ()=>import('../userPage/pages/singleproject.vue'),
            },
            {
                path: 'event',
                component: ()=>import('../userPage/pages/event.vue'),
            },
            {
                path: 'eventsingle/:slug',
                component: ()=>import('../userPage/pages/eventsingle.vue'),
            },
            {
                path: 'blog',
                component: ()=>import('../userPage/pages/blog.vue'),
            },
            {
                path: 'blogsingle',
                component: ()=>import('../userPage/pages/blogsingle.vue'),
            },
            {
                path: 'gallery',
                component: ()=>import('../userPage/pages/gallery.vue'),
            },
            {
                path: 'contact',
                component: ()=>import('../userPage/pages/contact.vue'),
            },
            {
                path: 'projectpreview/:id',
                meta: {requiresAuth: true},
                component: ()=>import('../userPage/pages/projectpreview.vue'),
            },
            {
                path: 'eventpreview/:id',
                meta: {requiresAuth: true},
                component: ()=>import('../userPage/pages/eventpreview.vue'),
            },
            {
                path: 'blogpreview/:id',
                meta: {requiresAuth: true},
                component: ()=>import('../userPage/pages/blogpreview.vue'),
            },
        ]
    },
    {
        path:'/admins',
        component: ()=>import('../adminPage/contentWraper.vue'),
        meta: {requiresAuth: true},
        children:[
            {
                path: '',
                name: 'adminHome',
                component: ()=>import('../adminPage/pages/home.vue'),
            },
            {
                path: 'projects',
                component: ()=>import('../adminPage/pages/project.vue'),
            },
            {
                path: 'category',
                component: ()=>import('../adminPage/pages/category.vue'),
            },
            {
                path: 'events',
                component: ()=>import('../adminPage/pages/event.vue'),
            },
            {
                path: 'blogs',
                component: ()=>import('../adminPage/pages/blog.vue'),
            },
        ]
    },
    {
        path:'/admins/login',
        component: ()=>import('../adminPage/pages/login.vue'),
    }
]


const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior(to, from, savedPosition){
        if (to.hash) {
            return {
                el: to.hash,
                behavior: 'smooth',
                top: 0
            }
        } else {
            return { top: 0 }
        }
    }
})

export async function isAuthenticated() {
    try {
        const res = await axiosInstance.get('/user',{
            headers: {
                Authorization: `Bearer ${localStorage.getItem("token")}`,
            },
        })
        if (res.status === 200) {
            return res.data.user
        }
    } catch (error) {
        console.error(
            "Erreur lors de la vérification de l'authentification :",
            error
        );
        return null;
    }
}

router.beforeEach(async (to, from, next) => {
    if (to.matched.some((record) => record.meta.requiresAuth)) {
        try {
            const auth = await isAuthenticated()
            const token = localStorage.getItem("token");
            if (auth && token) {

                // Vérifier si le statut de l'utilisateur est égal à 0
                if (auth.is_active === 0) {
                    localStorage.removeItem("token");
                    return next('/admins/login');
                }

                // const requiredRoles = to.meta.roles;
                // if (requiredRoles && !requiredRoles.includes(auth.role)) {
                //     return next('/unauthorized')
                // }

                next()
            }else{
                next('/admins/login')
            }
        } catch (error) {
            console.error(
                "Erreur lors de la vérification de l'authentification :",
                error
            );
            next("/admins/login");
        }
    }else{
        // Rediriger les utilisateurs authentifiés accédant à la page de connexion
        if (to.path === '/admins/login') {
            const auth = await isAuthenticated()
            const token = localStorage.getItem("token");
            if (auth && token) {
                next('/admins')
            } else {
                next()
            }
        } else {
            next();
        }
    }
})

export default router;
