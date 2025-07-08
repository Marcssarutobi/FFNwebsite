<template>

    <!--Page Title-->
    <section class="page-title" style="background-image:url(/assets/images/background/imagesMenu.jpeg);">
        <div class="auto-container">
            <div class="sec-title">
                <h1>Annual Reports</h1>
                <div class="bread-crumb"><RouterLink to="/">Home</RouterLink> / <RouterLink to="annualReports" class="current">Annual Reports</RouterLink></div>
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


    <!--Sponsors Section-->
    <section class="sponsors-section">
        <div class="auto-container">
            <div class="slider-outer">
                <!--Sponsors Slider-->
                <ul class="sponsors-slider">
                    <li><a href="#"><img src="/assets/images/clients/01.png" alt=""></a></li>
                    <li><a href="#"><img src="/assets/images/clients/03.jpg" alt=""></a></li>
                    <li><a href="#"><img src="/assets/images/clients/04.jpg" alt=""></a></li>
                    <li><a href="#"><img src="/assets/images/clients/05.jpg" alt=""></a></li>
                    <li><a href="#"><img src="/assets/images/clients/06.png" alt=""></a></li>
                    <li><a href="#"><img src="/assets/images/clients/07.jpeg" alt=""></a></li>
                </ul>
            </div>

        </div>
    </section>

    <!--Intro Section-->
    <section class="subscribe-intro">
    	<div class="auto-container">
        	<div class="row clearfix">
            	<!--Column-->
                <div class="column col-md-9 col-sm-12 col-xs-12">
                	<h2>Subcribe for Newsletter</h2>
                    Receive our latest news and special offers directly to your inbox.
                </div>
                <!--Column-->
                <div class="column col-md-3 col-sm-12 col-xs-12">
                	<div class="text-right padd-top-20">
                        <RouterLink to="/contact" class="theme-btn btn-style-one">Subscribe Now</RouterLink>
                		
                    </div>
                </div>
            </div>
        </div>
    </section>


</template>

<script  setup>
import { RouterLink } from 'vue-router';


</script>

<style>

</style>
