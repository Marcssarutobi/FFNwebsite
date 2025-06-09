import { createRouter, createWebHistory } from "vue-router";

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
                path: 'singleproject',
                component: ()=>import('../userPage/pages/singleproject.vue'),
            },
            {
                path: 'event',
                component: ()=>import('../userPage/pages/event.vue'),
            },
            {
                path: 'eventsingle',
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
        ]
    },
    {
        path:'/admins',
        component: ()=>import('../adminPage/contentWraper.vue'),
        children:[
            {
                path: '',
                component: ()=>import('../adminPage/pages/home.vue'),
            },
            {
                path: 'projects',
                component: ()=>import('../adminPage/pages/project.vue'),
            },
        ]
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

export default router;
