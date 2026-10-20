<template>

    <!--Page Title-->
    <section class="page-title" style="background-image:url(/assets/images/background/imagesMenu.jpeg);">
        <div class="auto-container">
            <div class="sec-title">
                <h1>Reports</h1>
                <div class="bread-crumb"><RouterLink to="/">Home</RouterLink> / <RouterLink to="/reports" class="current">Reports</RouterLink></div>
            </div>
        </div>
    </section>


    <!--Contenu à venir-->
    <ComingSoon title="Reports" />


    <!--field Section-->
    <!-- Services Section -->



       <!--end Section-->


    <PartnersSection />

    <!--Intro Section-->
    <section class="subscribe-intro">
    	<div class="auto-container">
        	<div class="row clearfix">
            	<!--Column-->
                <div class="column col-md-9 col-sm-12 col-xs-12">
                	<h2>Join our mission</h2>
                    Want to support our work, become a partner or volunteer? Get in touch with our team.
                </div>
                <!--Column-->
                <div class="column col-md-3 col-sm-12 col-xs-12">
                	<div class="text-right padd-top-20">
                        <RouterLink to="/contact" class="theme-btn btn-style-one">Contact Us</RouterLink>
                		
                    </div>
                </div>
            </div>
        </div>
    </section>


</template>

<script  setup>
    import ComingSoon from '../components/ComingSoon.vue';
    import PartnersSection from '../components/PartnersSection.vue';
import { RouterLink } from 'vue-router';


</script>

<style>

</style>
