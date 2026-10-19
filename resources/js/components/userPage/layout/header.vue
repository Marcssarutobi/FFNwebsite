<template>

    <!-- Main Header -->
    <header class="main-header">
    	<div class="top-bar">
        	<div class="top-container">
            	<!--Info Outer-->
                 <div class="info-outer">
                 	<!--Info Box-->
                    <ul class="info-box clearfix">
                    	<li><span class="icon flaticon-interface"></span><a :href="'mailto:' + contactInfo.email">{{ contactInfo.email }}</a></li>
                    	<li><span class="icon flaticon-technology-5"></span><a :href="contactInfo.phoneLink">{{ contactInfo.phoneDisplay }}</a></li>
                        <li class="social-links-one" v-if="socialLinks.length">
                            <a v-for="link in socialLinks" :key="link.name" :href="link.url" :class="link.css + ' img-circle'" target="_blank" rel="noopener" :aria-label="link.name"><span :class="link.icon"></span></a>
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
                    <button type="button" @click="isMenuOpen = !isMenuOpen" class="navbar-toggle" :aria-expanded="isMenuOpen" aria-controls="ffn-main-nav" :aria-label="isMenuOpen ? 'Close menu' : 'Open menu'" style="font-size: 18px; background-color: #179607; color: #fff;">
                        <i :class="isMenuOpen ? 'fas fa-xmark' : 'fas fa-bars'"></i>
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
                            <ul class="navigation" id="ffn-main-nav">
                                <li v-for="item in menu" :key="item.label"
                                    :class="{ dropdown: item.children, current: item.children && isSectionActive(item), 'ffn-open': openKey === item.label }"
                                    @mouseenter="item.children && !isMobileView && (openKey = item.label)"
                                    @mouseleave="item.children && !isMobileView && (openKey = null)">

                                    <router-link v-if="!item.children" exact-active-class="current" :to="item.to" @click="closeMenu">{{ item.label }}</router-link>

                                    <template v-else>
                                        <a href="#" role="button" aria-haspopup="true" :aria-expanded="openKey === item.label"
                                           @click.prevent="toggleDropdown(item.label)" @keydown.esc="openKey = null">{{ item.label }}</a>
                                        <ul v-show="openKey === item.label" :class="{ 'dropdown-mobile': isMobileView }" style="display: block;">
                                            <li v-for="child in item.children" :key="child.to">
                                                <router-link :to="child.to" @click="closeMenu" @keydown.esc="openKey = null">{{ child.label }}</router-link>
                                            </li>
                                        </ul>
                                    </template>
                                </li>
                            </ul>
                        </div>

                        <div class="ffn-lang notranslate" role="group" aria-label="Language">
                            <button type="button" :class="{ active: currentLang === 'en' }" :aria-pressed="currentLang === 'en'" @click="setLang('en')">EN</button>
                            <button type="button" :class="{ active: currentLang === 'fr' }" :aria-pressed="currentLang === 'fr'" @click="setLang('fr')">FR</button>
                        </div>
                        <div class="gtranslate_wrapper desktop ffn-gt-hidden" aria-hidden="true"></div>
                    </nav>



                </div>

            </div>
        </div><!-- Header Top End -->

    </header><!--End Main Header -->

</template>

<script setup>

    import { onBeforeUnmount, onMounted, ref, watch } from 'vue';
    import { useRoute } from 'vue-router';
    import { contactInfo, socialLinks, loadSettings } from '../../plugin/site';

    // Langue affichée : GTranslate mémorise la traduction dans le cookie googtrans (/en/fr)
    const currentLang = ref((document.cookie.match(/googtrans=\/en\/([a-z]{2})/) || [])[1] || 'en')

    const setLang = (lang) => {
        const select = document.querySelector('.gtranslate_wrapper select.gt_selector')
        if (!select) return
        select.value = lang === 'en' ? 'en|en' : 'en|' + lang
        select.dispatchEvent(new Event('change'))
        currentLang.value = lang
    }

    // Menu principal : un lien simple (to) ou une rubrique avec sous-menu (children)
    const menu = [
        { label: 'Home', to: '/' },
        { label: 'About', children: [
            { label: 'About us', to: '/aboutUs' },
            { label: 'Field of intervention', to: '/domain' },
            { label: 'Advisors', to: '/advisor' },
            { label: 'Team', to: '/team' },
        ] },
        { label: 'Programs', children: [
            { label: 'Fungi Education', to: '/fungiEducation' },
            { label: 'Expeditions', to: '/expeditions' },
            { label: 'Projects', to: '/project' },
        ] },
        { label: 'Publications', children: [
            { label: 'Scientific Papers', to: '/scientificPapers' },
            { label: 'Reports', to: '/reports' },
            { label: 'Annual Reports', to: '/annualReports' },
        ] },
        { label: 'Media & News', children: [
            { label: 'Events', to: '/event' },
            { label: 'Gallery', to: '/gallery' },
            { label: 'Videos', to: '/videos' },
        ] },
        { label: 'Blog', to: '/blog' },
        { label: 'Contact Us', to: '/contact' },
    ]

    // Pages de détail rattachées à une rubrique (pour la mettre en évidence dans le menu)
    const sectionPrefixes = {
        About: ['/details/'],
        Programs: ['/fungiEducationSingle/', '/expeditionSingle/', '/singleproject/', '/catDetails/'],
        'Media & News': ['/eventsingle/'],
    }

    const route = useRoute()
    const openKey = ref(null)
    const isMenuOpen = ref(false)
    const isMobileView = ref(window.innerWidth <= 767)

    const isSectionActive = (item) =>
        item.children.some(child => route.path === child.to) ||
        (sectionPrefixes[item.label] || []).some(prefix => route.path.startsWith(prefix))

    // Survol sur ordinateur, toucher / clic / clavier partout
    const toggleDropdown = (key) => {
        openKey.value = openKey.value === key ? null : key
    }

    const closeMenu = () => {
        isMenuOpen.value = false
        openKey.value = null
    }

    const onResize = () => {
        isMobileView.value = window.innerWidth <= 767
    }

    // Fermer le menu à chaque changement de page
    watch(() => route.fullPath, closeMenu)

    onBeforeUnmount(() => window.removeEventListener('resize', onResize))

    onMounted(() => {
        window.addEventListener('resize', onResize)
        loadSettings()

        // 1. Ajouter la configuration
        const configScript = document.createElement('script')
        configScript.type = 'text/javascript'
        configScript.innerHTML = `window.gtranslateSettings = {
            default_language: "en",
            languages: ["en", "fr"],
            wrapper_selector: ".gtranslate_wrapper"
        };`
        document.head.appendChild(configScript)

        // 2. Charger le script externe
        const externalScript = document.createElement('script')
        externalScript.src = "https://cdn.gtranslate.net/widgets/latest/dropdown.js"
        externalScript.defer = true
        document.head.appendChild(externalScript)
    })

    //onMounted(() => {
        // Configuration du widget AVEC DRAPEAUX SEULEMENT (pas de select)
        //window.gtranslateSettings = {
        //    default_language: 'en',
        //    languages: ['en', 'fr'],
        //    wrapper_selector: '.gtranslate_wrapper',
        //    switcher_horizontal_position: "inline",
        //    flag_size: 24,
        //    alt_flags: {
        //     en: "usa"
        //    }
        //}

        // Charger SEULEMENT le script fc.js (flags)
        //const script = document.createElement('script')
        //script.src = 'https://cdn.gtranslate.net/widgets/latest/fc.js'
        //script.defer = true
        //document.head.appendChild(script)
    //})
</script>

<style>

    .dropdown-mobile {
        position: static !important;
        background: transparent !important;
        box-shadow: none !important;
        padding-left: 20px;
        width: 100% !important;
    }

    .gt_switcher{
        display: none !important;
    }

    .glink img{
        width: 30px !important;
        height: 30px !important;
    }

    .glink span{
        font-size: 14px !important;
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

    /* La liste GTranslate reste dans la page (elle fait la traduction) mais on affiche nos boutons EN | FR */
    .gtranslate_wrapper.ffn-gt-hidden{
        display: none !important;
    }

    .ffn-lang{
        display: flex;
        align-items: center;
        margin-left: 18px;
        border: 1px solid #d6dcd4;
        border-radius: 20px;
        overflow: hidden;
    }

    .ffn-lang button{
        border: 0;
        background: transparent;
        padding: 6px 12px;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: .5px;
        color: #555;
        cursor: pointer;
        transition: background .2s ease, color .2s ease;
    }

    .ffn-lang button + button{
        border-left: 1px solid #d6dcd4;
    }

    .ffn-lang button.active{
        background: #179607;
        color: #fff;
    }

    .ffn-lang button:hover:not(.active),
    .ffn-lang button:focus-visible{
        background: rgba(23, 150, 7, .1);
        outline: none;
    }

    .gtranslate_wrapper {
        min-width: 80px;
        max-width: 135px;
        font-size: 13px;
        display: flex;
        align-items: center;
        justify-content: flex-end;
    }

    .gtranslate_wrapper .gt_selector{
        height: 50px;
        border: 1px solid #000;
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

        .ffn-lang{
            margin: 12px auto 4px;
        }
    }




</style>
