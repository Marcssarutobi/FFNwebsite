<template>
  <div class="page-wrapper">
    <headers></headers>
    <RouterView></RouterView>
    <footers></footers>
  </div>

  <!--Scroll to top-->
<div class="scroll-to-top scroll-to-target" data-target=".main-header" role="button" tabindex="0" aria-label="Back to top" title="Back to top"><span class="fa-solid fa-arrow-up"></span></div>



</template>

<script setup>

    import {themeInit} from '../plugin/themeInit'
    import { useRoute } from "vue-router";
    import { onMounted, watch, ref, nextTick } from 'vue';
    import { RouterView } from 'vue-router';
    import headers from './layout/header.vue';
    import footers from './layout/footer.vue';

    const route = useRoute();

    onMounted(()=>{
        setTimeout(() => {
            themeInit();
        }, 0);
    })

    watch(route, async () => {
        await nextTick(); // attendre que le DOM se mette à jour
        themeInit();
    });

</script>

<style>

</style>
