<template>
  <!--Main Footer-->
  <footer class="main-footer" style="background-image:url(assets/images/background/footer-bg.jpg);">

        <!--Footer Upper-->
        <div class="footer-upper ffn-footer-upper">
            <div class="auto-container">
                <div class="ffn-footer-grid">

                    <!-- Marque et coordonnées -->
                    <div class="column footer-widget about-widget ffn-footer-brand">
                        <div class="logo"><RouterLink to="/"><img src="/assets/images/logo-2.png" class="img-responsive" alt="Fungi For Nature"></RouterLink></div>
                        <p class="ffn-footer-tagline">Fungi for Life, Science, and the Planet.</p>

                        <ul class="contact-info">
                            <li><span class="icon fa fa-map-marker"></span>{{ contactInfo.address }}</li>
                            <li><span class="icon fa fa-phone"></span><a :href="contactInfo.phoneLink">{{ contactInfo.phoneDisplay }}</a></li>
                            <li><span class="icon fa fa-envelope"></span><a :href="'mailto:' + contactInfo.email">{{ contactInfo.email }}</a></li>
                        </ul>

                        <div class="social-links-two clearfix" v-if="socialLinks.length">
                            <a v-for="link in socialLinks" :key="link.name" :href="link.url" :class="link.css + ' img-circle'" target="_blank" rel="noopener" :aria-label="link.name"><span :class="link.icon"></span></a>
                        </div>
                    </div>

                    <!-- Projets récents (et articles quand il y en a) -->
                    <div class="column footer-widget links-widget">
                        <h2>Recent Projects</h2>
                        <ul class="ffn-footer-list">
                            <li v-for="project in allproject" :key="project.id">
                                <router-link :to="`/singleproject/${project.slug}`" :title="project.title"><span class="ffn-clamp">{{ project.title }}</span></router-link>
                            </li>
                        </ul>
                        <router-link to="/project" class="ffn-footer-more">All projects <span class="fa-solid fa-arrow-right"></span></router-link>

                        <template v-if="allblog.length">
                            <h2 class="ffn-footer-subtitle">Latest News</h2>
                            <ul class="ffn-footer-list">
                                <li v-for="blog in allblog" :key="blog.slug">
                                    <router-link :to="`/blogsingle/${blog.slug}`" :title="blog.title"><span class="ffn-clamp">{{ blog.title }}</span></router-link>
                                </li>
                            </ul>
                        </template>
                    </div>

                    <!-- Programmes -->
                    <div class="column footer-widget links-widget">
                        <h2>Our Programs</h2>
                        <ul class="ffn-footer-list">
                            <li v-for="program in programs" :key="program.to"><router-link :to="program.to">{{ program.label }}</router-link></li>
                        </ul>
                    </div>

                    <!-- Liens rapides -->
                    <div class="column footer-widget links-widget">
                        <h2>Quick Links</h2>
                        <ul class="ffn-footer-list">
                            <li><router-link to="/aboutUs">About us</router-link></li>
                            <li><router-link to="/team">Our team</router-link></li>
                            <li><router-link to="/event">Events</router-link></li>
                            <li><router-link to="/gallery">Gallery</router-link></li>
                            <li><router-link to="/blog">Blog</router-link></li>
                            <li><router-link to="/contact">Contact</router-link></li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>

        <!--Footer Bottom-->
    	<div class="footer-bottom">
            <div class="auto-container clearfix">
                <!--Copyright-->
                <div class="copyright text-center">Copyright {{ currentYear }} &copy; <RouterLink to="/">Fungi For Nature</RouterLink></div>
            </div>
        </div>

    </footer>
</template>

<script setup>

    import { computed, onMounted, ref, nextTick } from 'vue';
    import { getData } from '../../plugin/api';
    import { RouterLink } from 'vue-router';
    import {themeInit} from '../../plugin/themeInit'
    import { contactInfo, socialLinks } from '../../plugin/site';

    const currentYear = new Date().getFullYear();

    // Programmes (pages de « Field of intervention »)
    const programs = [
        { label: 'Mycological Research (MycRI)', to: '/mycrl' },
        { label: 'Agriculture & Food (AgriSA)', to: '/agrisa' },
        { label: 'Education (EduMyco)', to: '/edumyco' },
        { label: 'Environment (MycoEnv)', to: '/mycoenv' },
        { label: 'Biodiversity & Climate (BioClim)', to: '/bioclim' },
        { label: 'Conservation (EcoMyCo)', to: '/ecomyco' },
    ];

    const allproject = ref([]);
    const allblog = ref([]);

    const AllProjectFunction = async () =>{
        await getData('/allprojects')
            .then((response) => {
                allproject.value = response.data.data.data.slice(0,3);
                nextTick(); // wait for DOM updates
                setTimeout(() => {
                    themeInit();
                }, 0);
            })
            .catch((error) => {
                console.error('Error fetching projects:', error);
            });
    }

    const AllBlogFunction = async () =>{
        await getData('/allblogs')
            .then((response) => {
                allblog.value = response.data.data.data.slice(0,2);
            })
            .catch((error) => {
                console.error('Error fetching projects:', error);
            });
    }

    onMounted(()=>{

        // (Traduction : gérée uniquement par l'en-tête, boutons EN | FR)

        AllProjectFunction()
        AllBlogFunction()
    })

</script>

<style scoped>

    /* Pied de page en 4 colonnes : marque, projets récents, programmes, liens rapides */
    .ffn-footer-upper{
        padding: 70px 0 40px !important;
    }
    .ffn-footer-grid{
        display: grid;
        grid-template-columns: 1.3fr 1.2fr 1fr 0.8fr;
        gap: 40px;
    }
    .ffn-footer-grid h2{
        margin-bottom: 22px;
    }
    .ffn-footer-grid .column{
        margin-bottom: 0;
    }
    .ffn-footer-tagline{
        margin: 18px 0 20px;
    }
    .ffn-footer-list{
        margin: 0;
        padding: 0;
        list-style: none;
    }
    .ffn-footer-list li{
        margin-bottom: 12px;
        line-height: 1.5;
    }
    /* Titres longs : 2 lignes maximum, avec « … » (le titre complet reste en infobulle) */
    .ffn-clamp{
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .ffn-footer-more{
        display: inline-block;
        margin-top: 4px;
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .5px;
        color: #179607 !important;
    }
    .ffn-footer-more .fa-solid{
        margin-left: 6px;
        font-size: 11px;
    }
    .ffn-footer-subtitle{
        margin-top: 30px;
    }

    @media (max-width: 991px){
        .ffn-footer-grid{
            grid-template-columns: 1fr 1fr;
        }
    }
    @media (max-width: 575px){
        .ffn-footer-upper{
            padding: 50px 0 20px !important;
        }
        .ffn-footer-grid{
            grid-template-columns: 1fr;
            gap: 28px;
        }
    }

</style>
