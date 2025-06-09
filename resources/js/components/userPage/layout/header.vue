<template>

    <!-- Main Header -->
    <header class="main-header">
    	<div class="top-bar">
        	<div class="top-container">
            	<!--Info Outer-->
                 <div class="info-outer">
                 	<!--Info Box-->
                    <ul class="info-box clearfix">
                    	<li><span class="icon flaticon-interface"></span><a href="#">companyname@mail.com</a></li>
                    	<li><span class="icon flaticon-technology-5"></span><a href="#">(732) 803-010-03</a></li>
                        <li class="social-links-one">
                        	<a href="#" class="facebook img-circle"><span class="fa fa-facebook-f"></span></a>
                            <a href="#" class="twitter img-circle"><span class="fa fa-twitter"></span></a>
                            <a href="#" class="google-plus img-circle"><span class="fa fa-google-plus"></span></a>
                            <a href="#" class="linkedin img-circle"><span class="fa fa-linkedin"></span></a>
                        </li>
                    </ul>
                 </div>
            </div>
        </div>
    	<!-- Header Upper -->
    	<div class="header-upper">
        	<div class="auto-container clearfix">
            	<!-- Logo -->
                <div class="logo">
                    <router-link to="/"><img src="/assets/images/logo-1.png" alt="Greenture"></router-link>
                 </div>

                 <!--Nav Outer-->
                <div class="nav-outer clearfix">

                    <a href="#" class="theme-btn btn-donate" data-toggle="modal" data-target="#donate-popup">Donate Now!</a>

                    <!-- Main Menu -->
                    <nav class="main-menu">

                        <div class="navbar-header">
                            <!-- Toggle Button -->
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>

                        <div class="navbar-collapse collapse clearfix">
                            <ul class="navigation">

                                <li >
                                    <router-link exact-active-class="current" to="/">Home</router-link>
                                </li>
                                <li>
                                    <router-link exact-active-class="current" to="about">About</router-link>
                                </li>
                                <li>
                                    <router-link exact-active-class="current" to="project">Projects</router-link>
                                </li>
                                <li>
                                    <router-link exact-active-class="current" to="event">Events</router-link>
                                </li>
                                <li>
                                    <router-link exact-active-class="current" to="blog">BLog</router-link>
                                </li>
                                <li>
                                    <router-link exact-active-class="current" to="gallery">Gallery</router-link>
                                </li>
                                <li>
                                    <router-link exact-active-class="current" to="contact">Contact Us</router-link>
                                </li>
                            </ul>
                        </div>
                    </nav><!-- Main Menu End-->

                </div>

            </div>
        </div><!-- Header Top End -->

    </header><!--End Main Header -->

</template>

<script setup>

</script>

<style>
    a.current {
        color: #6ac610 !important;
        opacity: 1 !important;
    }
</style>
