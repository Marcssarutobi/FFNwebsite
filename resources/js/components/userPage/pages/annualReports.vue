<template>

    <!--Page Title-->
    <section class="page-title" style="background-image:url(/assets/images/background/imagesMenu.jpeg);">
        <div class="auto-container">
            <div class="sec-title">
                <h1>Annual Reports</h1>
                <div class="bread-crumb"><RouterLink to="/">Home</RouterLink> / <RouterLink to="/annualReports" class="current">Annual Reports</RouterLink></div>
            </div>
        </div>
    </section>


    <!--Default Section-->
    <section class="default-section">
    	<div class="auto-container">
        	<div class="row clearfix">

                <!--Column-->
               

                <!--Column-->
                <div class="column default-text-column with-margin col-md-12 col-sm-12 col-xs-12">
                	<article class="inner-box wow fadeInRight" data-wow-delay="0ms" data-wow-duration="1500ms">
                		<h2> <span class="theme_color normal-font">Annual Reports</span></h2>
                        
                    </article>
                </div>

            </div>

        </div>
    </section>


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
    import PartnersSection from '../components/PartnersSection.vue';
import { RouterLink } from 'vue-router';


</script>

<style>

</style>
