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
                path: 'domain',
                component: ()=>import('../userPage/pages/domain.vue'),
            },
            {
                path: 'aboutUs',
                component: ()=>import('../userPage/pages/aboutUs.vue'),
            },
            {
                path: 'advisor',
                component: ()=>import('../userPage/pages/advisor.vue'),
            },
            {
                path: 'team',
                component: ()=>import('../userPage/pages/team.vue'),
            },
            {
                path: 'project',
                component: ()=>import('../userPage/pages/project.vue'),
            },
            {
                path: 'fungiEducation',
                component: ()=>import('../userPage/pages/fungiEducation.vue'),
            },
            {
                path: 'expeditions',
                component: ()=>import('../userPage/pages/expeditions.vue'),
            },
            {
                path: 'scientificPapers',
                component: ()=>import('../userPage/pages/scientificPapers.vue'),
            },
            {
                path: 'mycrl',
                component: ()=>import('../userPage/pages/mycrl.vue'),
            },
            {
                path: 'agrisa',
                component: ()=>import('../userPage/pages/agrisa.vue'),
            },
            {
                path: 'edumyco',
                component: ()=>import('../userPage/pages/edumyco.vue'),
            },
            {
                path: 'mycoenv',
                component: ()=>import('../userPage/pages/mycoenv.vue'),
            },
            {
                path: 'bioclim',
                component: ()=>import('../userPage/pages/bioclim.vue'),
            },
            {
                path: 'ecomyco',
                component: ()=>import('../userPage/pages/ecomyco.vue'),
            },
            {
                path: 'reports',
                component: ()=>import('../userPage/pages/reports.vue'),
            },
            {
                path: 'annualReports',
                component: ()=>import('../userPage/pages/annualReports.vue'),
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
                path: 'blogsingle/:slug',
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
                meta: {requiresAuth: true,roles:['superadmin','approver']},
                component: ()=>import('../userPage/pages/projectpreview.vue'),
            },
            {
                path: 'eventpreview/:id',
                meta: {requiresAuth: true,roles:['superadmin','approver']},
                component: ()=>import('../userPage/pages/eventpreview.vue'),
            },
            {
                path: 'blogpreview/:id',
                meta: {requiresAuth: true,roles:['superadmin','approver']},
                component: ()=>import('../userPage/pages/blogpreview.vue'),
            },
            {
                path: 'catDetails/:id',
                component: ()=>import('../userPage/pages/catProject.vue'),
            },
            {
                path: 'fungiEducationpreview/:id',
                meta: {requiresAuth: true,roles:['superadmin','approver']},
                component: ()=>import('../userPage/pages/fungiEducationpreview.vue'),
            }
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
                meta:{
                    roles:['superadmin','admin','author','viewer','approver']
                }
            },
            {
                path: 'projects',
                component: ()=>import('../adminPage/pages/project.vue'),
                meta:{
                    roles:['superadmin','admin','author','viewer','approver']
                }
            },
            {
                path: 'fungiEducation',
                component: ()=>import('../adminPage/pages/fungiEducation.vue'),
                meta:{
                    roles:['superadmin','admin','author','viewer','approver']
                }
            },
            {
                path: 'category',
                component: ()=>import('../adminPage/pages/category.vue'),
                meta:{
                    roles:['superadmin','admin']
                }
            },
            {
                path: 'events',
                component: ()=>import('../adminPage/pages/event.vue'),
                meta:{
                    roles:['superadmin','admin','author','viewer','approver']
                }
            },
            {
                path: 'blogs',
                component: ()=>import('../adminPage/pages/blog.vue'),
                meta:{
                    roles:['superadmin','admin','author','viewer','approver']
                }
            },
            {
                path: 'contact',
                component: ()=>import('../adminPage/pages/contact.vue'),
                meta:{
                    roles:['superadmin','admin']
                }
            },
            {
                path: 'gallery',
                component: ()=>import('../adminPage/pages/gallery.vue'),
                meta:{
                    roles:['superadmin','admin','author','viewer','approver']
                }
            },
            {
                path: 'settings',
                component: ()=>import('../adminPage/pages/setting.vue'),
                meta:{
                    roles:['superadmin','admin','author','viewer','approver']
                },
                children:[
                    {
                        path:'',
                        component: ()=>import('../adminPage/pages/profils.vue'),
                    },
                    {
                        path:'password',
                        component: ()=>import('../adminPage/pages/password.vue'),
                    },
                ]
            },
            {
                path: 'user',
                component: ()=>import('../adminPage/pages/user.vue'),
                meta:{
                    roles:['superadmin','admin']
                }
            },
        ]
    },
    {
        path:'/admins/login',
        component: ()=>import('../adminPage/pages/login.vue'),
    },
    {
        path:'/admins/unauthorized',
        component: ()=>import('../adminPage/pages/unauthorized.vue'),
    },
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

                const requiredRoles = to.meta.roles;
                const userRole = auth.role?.name ;

                if (requiredRoles && !requiredRoles.includes(userRole)) {
                    return next('/admins/unauthorized'); // page d'accès interdit
                }

                next()
            }else{
                localStorage.setItem('redirectAfterLogin', to.fullPath); // <- ici
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
