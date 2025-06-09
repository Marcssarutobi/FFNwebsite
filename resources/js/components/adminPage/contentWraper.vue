<template>
  <div class="app-wrapper">
    <sidebars />
    <div class="app-content ">
        <div>
            <headers />
            <router-view />
        </div>
    </div>

  </div>
</template>

<script  setup>

    import sidebars from './layout/sidebar.vue'
    import headers from './layout/header.vue'
    import {themeInitAdmin} from '../plugin/themeInitAdmin'
    import { useRoute } from "vue-router";
    import { onMounted, watch, ref, nextTick } from 'vue';

    const route = useRoute();

    onMounted(()=>{
        setTimeout(() => {
            themeInitAdmin();
        }, 0);
    })

    watch(route, async () => {
        await nextTick(); // attendre que le DOM se mette à jour
        themeInitAdmin();
    });

</script>

<style>

</style>
