<template>
    <section class="ffn-coming-soon">
        <div class="auto-container">
            <div class="icon"><span class="fa fa-leaf"></span></div>
            <h2>{{ title }} <span class="normal-font theme_color">coming soon</span></h2>
            <p>{{ text }}</p>
            <RouterLink to="/contact" class="theme-btn btn-style-one">Contact us</RouterLink>
        </div>
    </section>
</template>

<script setup>
import { RouterLink } from 'vue-router';

defineProps({
    title: { type: String, required: true },
    text: { type: String, default: 'We are preparing this section. Come back soon or contact us to learn more.' },
});
</script>
