<template>

    <!-- Main Header -->
    <header class="main-header">
    	<div class="top-bar">
        	<div class="top-container">
            	<!--Info Outer-->
                 <div class="info-outer">
                 	<!--Info Box-->
                    <ul class="info-box clearfix">
                    	<li><span class="icon flaticon-interface"></span><a href="mailto:contact@fungifornature.com">contact@fungifornature.com</a></li>
                    	<li><span class="icon flaticon-technology-5"></span><a href="#">(+229) 0196975772</a></li>
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
                            <button type="button" class="navbar-toggle " data-toggle="collapse" data-target=".navbar-collapse" style="font-size: 18px; background-color: #179607; color: #fff;">
                                <i class="fas fa-bars"></i>
                            </button>
                        </div>

                        <div class="navbar-collapse collapse clearfix">
                            <ul class="navigation">

                                <li >
                                    <router-link exact-active-class="current" to="/">Home</router-link>
                                </li>
                                
                                <li>
                                    <router-link exact-active-class="current" to="/project">Projects</router-link>
                                </li>
                                <li>
                                    <router-link exact-active-class="current" to="/event">Events</router-link>
                                </li>
                                
                                <li>
                                    <router-link exact-active-class="current" to="/gallery">Gallery</router-link>
                                </li>
                                <li>
                                    <router-link exact-active-class="current" to="/blog">BLog</router-link>
                                </li>
                                <li>
                                    <router-link exact-active-class="current" to="/about">About</router-link>
                                </li>
                                <li>
                                    <router-link exact-active-class="current" to="/contact">Contact Us</router-link>
                                </li>
                            </ul>
                        </div>
                    </nav>

                </div>

            </div>
        </div><!-- Header Top End -->

    </header><!--End Main Header -->

</template>

<script setup>

</script>

<style>
    a.current {
        color: #179607 !important;
        opacity: 1 !important;
    }
    @media screen and (max-width: 767px) {

    .main-header .top-bar .info-outer {
        position: relative;
        text-align: center;
        padding: 10px 15px;
        border-radius: 0;
    }

    .main-header .top-bar .info-outer:before {
        display: none;
    }

    .main-header .top-bar .info-box {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
        padding: 0;
        margin: 0;
    }

    .main-header .top-bar .info-box li {
        float: none;
        padding-left: 15px;
        margin: 5px 0;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .main-header .top-bar .info-box li:after {
        display: none;
    }

    .main-header .top-bar .info-box li .icon {
        position: relative;
        left: 0;
        top: 0;
        margin-right: 8px;
    }

    .main-header .top-bar .info-box li.social-links-one {
        display: flex;
        gap: 10px;
        justify-content: center;
    }

    .main-header .top-bar .info-box li.social-links-one a {
        margin: 0;
    }

    .main-header .nav-outer {
        text-align: center;
        margin-top: 0px !important;
    }

    .main-header .logo {
        text-align: center;
        margin-bottom: 10px;
    }

    .main-header .header-upper .auto-container {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .main-header .theme-btn.btn-donate {
        display: inline-block;
        margin: 10px 0;
    }

    .main-header .main-menu {
        width: 100%;
    }

    .main-header .main-menu .navigation {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 5px;
    }

    .main-header .main-menu .navigation li {
        float: none;
        width: 100%;
    }
}

</style>
