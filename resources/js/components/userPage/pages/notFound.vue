<template>
    <!--Page Title-->
    <section class="page-title" style="background-image:url(/assets/images/background/imagesMenu.jpeg);">
        <div class="auto-container">
            <div class="sec-title">
                <h1>Page <span class="normal-font">not found</span></h1>
                <div class="bread-crumb"><RouterLink to="/">Home</RouterLink>  / <a href="#" class="current">404</a></div>
            </div>
        </div>
    </section>

    <section class="ffn-not-found">
        <div class="auto-container text-center">
            <div class="ffn-not-found-code">404</div>
            <h2>This page does not exist</h2>
            <p>The page you are looking for may have been moved or removed. You can go back to the home page or explore our work.</p>
            <div class="ffn-not-found-actions">
                <RouterLink to="/" class="theme-btn btn-style-one">Back to home</RouterLink>
                <RouterLink to="/project" class="theme-btn btn-style-two">Our projects</RouterLink>
                <RouterLink to="/contact" class="theme-btn btn-style-two">Contact us</RouterLink>
            </div>
        </div>
    </section>
</template>

<script setup>
    import { RouterLink } from 'vue-router';
</script>

<style scoped>
    .ffn-not-found{
        padding: 80px 0 100px;
    }
    .ffn-not-found-code{
        font-size: 96px;
        font-weight: 800;
        line-height: 1;
        color: #179607;
        opacity: .2;
        margin-bottom: 10px;
    }
    .ffn-not-found h2{
        margin-bottom: 15px;
    }
    .ffn-not-found p{
        max-width: 560px;
        margin: 0 auto 30px;
    }
    .ffn-not-found-actions{
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 12px;
    }
</style>
