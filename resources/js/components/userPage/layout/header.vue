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
                        	<a href="#" class="facebook img-circle"><span class="fa-brands fa-facebook-f"></span></a>
                            <a href="#" class="twitter img-circle"><span class="fa-brands fa-x-twitter"></span></a>
                            <a href="#" class="google-plus img-circle"><span class="fa-brands fa-instagram"></span></a>
                            <a href="#" class="linkedin img-circle"><span class="fa-brands fa-linkedin"></span></a>
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
                    <router-link to="/"><img src="/assets/images/logo.png" alt="Fungi For Nature"></router-link>
                    <button type="button" @click="isMenuOpen = !isMenuOpen" class="navbar-toggle "  style="font-size: 18px; background-color: #179607; color: #fff;">
                        <i class="fas fa-bars"></i>
                    </button>
                 </div>

                 <!--Nav Outer-->
                <div class="nav-outer clearfix">



                    <!-- Main Menu -->
                    <nav class="main-menu">

                        <div class="navbar-header">
                            <!-- <div class="gtranslate_wrapper mobile"></div> -->
                            <!-- Toggle Button -->

                        </div>

                        <div class="navbar-collapse collapse clearfix" :class="{ show: isMenuOpen }">
                            <ul class="navigation">

                                <li >
                                    <router-link exact-active-class="current" @click="closeMenu" to="/">Home</router-link>
                                </li>

                                <li class="dropdown" @mouseenter="openDropdownAbout = true" @mouseleave="openDropdownAbout = false">
                                    <a href="#" @click.prevent>About</a>
                                    <ul v-show="openDropdownAbout" :class="{ 'dropdown-mobile': isMobile() }" style="display: block;">
                                        <li><router-link @click="closeDropdowns"  to="/aboutUs">About us</router-link></li>
                                        <li><router-link @click="closeDropdowns"  to="/domain">Field of ​​intervention</router-link></li>
                                        <li><router-link @click="closeDropdowns"  to="/advisor">Advisor</router-link></li>
                                        <li><router-link @click="closeDropdowns"  to="/team">Teams</router-link></li>
                                    </ul>
                                </li>

                             <!--    <li>
                                    <router-link exact-active-class="current" @click="closeMenu" to="/project">Projects</router-link>
                                </li>  -->

                                <li class="dropdown" @mouseenter="openDropdownPrograms = true" @mouseleave="openDropdownPrograms = false">
                                    <a href="#" @click.prevent>Programs</a>
                                    <ul v-show="openDropdownPrograms" :class="{ 'dropdown-mobile': isMobile() }" style="display: block;">
                                        <li><router-link @click="closeDropdowns" to="/fungiEducation">Fungi Education</router-link></li>
                                        <li><router-link @click="closeDropdowns" to="/expeditions">Expeditions</router-link></li>
                                        <li><router-link @click="closeDropdowns" to="/project">Projects</router-link></li>
                                    </ul>
                                </li>

                                <li class="dropdown" @mouseenter="openDropdownPublications = true" @mouseleave="openDropdownPublications = false">
                                    <a href="#" @click.prevent>Publications</a>
                                    <ul v-show="openDropdownPublications" :class="{ 'dropdown-mobile': isMobile() }" style="display: block;">
                                        <li><router-link @click="closeDropdowns" to="/scientificPapers">Scientific Papers</router-link></li>
                                        <li><router-link @click="closeDropdowns" to="/reports">Reports</router-link></li>
                                        <li><router-link @click="closeDropdowns" to="/annualReports">Annual Reports </router-link></li>
                                    </ul>
                                </li>

                                <li class="dropdown" @mouseenter="openDropdown = true" @mouseleave="openDropdown = false">
                                    <a href="#" @click.prevent>Media & New </a>
                                    <ul v-show="openDropdown" :class="{ 'dropdown-mobile': isMobile() }" style="display: block;">
                                        <li><router-link @click="closeDropdowns" to="/event">Events</router-link></li>
                                        <li><router-link @click="closeDropdowns" to="/gallery">Gallery</router-link></li>
                                    </ul>
                                </li>
                                 <li>
                                    <router-link exact-active-class="current" @click="closeMenu" to="/blog">BLog</router-link>
                                </li> 
                                <li>
                                    <router-link exact-active-class="current" @click="closeMenu" to="/contact">Contact Us</router-link>
                                </li>
                            </ul>
                        </div>

                        <div class="gtranslate_wrapper desktop"></div>
                    </nav>



                </div>

            </div>
        </div><!-- Header Top End -->

    </header><!--End Main Header -->

</template>

<script setup>

    import { onMounted, ref } from 'vue';

    const openDropdown = ref(false)
    const openDropdownAbout = ref(false)
    const openDropdownPrograms = ref(false)
    const openDropdownPublications = ref(false)

    const isMobile = () => window.innerWidth <= 767
    const isMenuOpen = ref(false)

    const closeMenu = () => {
        isMenuOpen.value = false
        openDropdown.value = false
        openDropdownAbout.value = false
        openDropdownPrograms.value = false
        openDropdownPublications.value = false
    }

    const closeDropdowns = () => {
        openDropdown.value = false
        openDropdownAbout.value = false
        openDropdownPrograms.value = false
        openDropdownPublications.value = false
        isMenuOpen.value = false
    }

    // onMounted(() => {
    //     // Injecter les paramètres de configuration
    //     window.gtranslateSettings = {
    //         default_language: "en",
    //         languages: ["en", "fr"],
    //         wrapper_selector: ".gtranslate_wrapper",
    //         switcher_horizontal_position: "inline",
    //         alt_flags: {
    //         en: "usa"
    //         }
    //     };

    //     // Éviter d’ajouter plusieurs fois le script si déjà présent
    //     if (!document.querySelector('script[src="https://cdn.gtranslate.net/widgets/latest/dwf.js"]')) {
    //         const script = document.createElement("script");
    //         script.src = "https://cdn.gtranslate.net/widgets/latest/dwf.js";
    //         script.defer = true;
    //         document.head.appendChild(script);
    //     }
    // })

    onMounted(() => {
        // 1. Définir la configuration
        window.gtranslateSettings = {
            default_language: 'en',
            languages: ['en', 'fr'],
            wrapper_selector: '.gtranslate_wrapper',
            flag_size: 24
        }

        // 2. Créer le tag script
        const script = document.createElement('script')
        script.src = 'https://cdn.gtranslate.net/widgets/latest/fc.js'
        script.defer = true

        // 3. Ajouter le script dans le DOM
        document.head.appendChild(script)
    })
</script>

<style>

    .dropdown-mobile {
        position: static !important;
        background: transparent !important;
        box-shadow: none !important;
        padding-left: 20px;
        width: 100% !important;
    }

    /* ----- Desktop (par défaut) ----- */
    .nav-outer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        padding: 0px !important;
    }

    .main-menu {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex: 1;
        width: 100%;
    }

    .navbar-collapse {
        flex: 1;
    }

    .navigation {
        display: flex;
        align-items: center;
        gap: 0px;
    }

    .gtranslate_wrapper {
        min-width: 80px;
        max-width: 135px;
        font-size: 13px;
        display: flex;
        align-items: center;
        justify-content: flex-end;
    }

    .gtranslate_wrapper .gt_switcher{
        min-width: 80px;
        max-width: 135px;
    }

    .gtranslate_wrapper .gt_switcher .gt_selected,
    .gtranslate_wrapper .gt_switcher .gt_selected a{
        min-width: 80px;
        max-width: 135px;
    }



    .desktop{
        display: block !important;
    }

    .mobile{
        display: none !important;
    }

    .logo a{
        width: 250px;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;

    }
    .logo a img{
        max-width: 100%;
        max-height: 100%;
        width: 100%;
        height: 100%;
        object-fit: contain;
    }



    a.current {
        color: #179607 !important;
        opacity: 1 !important;
    }

    @media screen and (max-width: 767px) {

        .header-upper{
            padding: 0 0 !important;
        }

        .nav-outer {
            width: 100%;
            margin-top: 10px !important;
        }

        .logo{
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .top-bar{
            display: none !important;
        }

        /* Étape clé : vertical stacking */
        .main-menu {
            display: flex;
            flex-direction: column;
            align-items: stretch;
            gap: 10px;
            width: 100%;
        }

        .navbar-header{
            display: flex !important;
            flex-direction: row-reverse;
            align-items: center !important;
            justify-content: space-between !important;
        }

        .navbar-header button{
            margin: 0px !important;
        }

        .desktop{
            display: none !important;
        }

        .mobile{
            display: block !important;
        }

        .navbar-header {
            display: flex;
            justify-content: center;
            width: 100%;
        }

        .navbar-toggle {
            margin: 0 auto;
        }

        .navbar-collapse {
            width: 100%;
            background-color: #f8f8f8;
            padding: 10px 0;
        }

        .navigation {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            width: 100%;
            padding: 0;
            margin: 0;
            gap: 10px;
        }

        .navigation li{
            width: 100%;
        }

        .gtranslate_wrapper {
            width: 100%;
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }
    }




</style>
