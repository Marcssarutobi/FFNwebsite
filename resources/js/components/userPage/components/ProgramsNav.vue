<template>
    <div class="widget popular-categories ffn-programs-nav">
        <div class="sidebar-title"><h3>Our programs</h3></div>
        <ul class="list">
            <li v-for="p in programs" :key="p.to" :class="{ active: route.path === p.to }">
                <RouterLink :to="p.to" class="clearfix">{{ p.label }}</RouterLink>
            </li>
        </ul>
    </div>
</template>

<script setup>
import { RouterLink, useRoute } from 'vue-router';

const route = useRoute();
const programs = [
    { to: '/mycrl', label: 'Mycological Research (MycRI)' },
    { to: '/agrisa', label: 'Agriculture & Food (AgriSA)' },
    { to: '/edumyco', label: 'Education (EduMyco)' },
    { to: '/mycoenv', label: 'Environment (MycoEnv)' },
    { to: '/bioclim', label: 'Biodiversity & Climate (BioClim)' },
    { to: '/ecomyco', label: 'Conservation (EcoMyCo)' },
];
</script>

<style>
.ffn-programs-nav li.active > a{ color: #179607; font-weight: 700; }
</style>
