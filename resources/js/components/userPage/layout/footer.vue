<template>
  <!--Main Footer-->
  <footer class="main-footer" style="background-image:url(assets/images/background/footer-bg.jpg);">

        <!--Footer Upper-->
        <div class="footer-upper">
            <div class="auto-container">
                <div class="row clearfix">

                    <!--Two 4th column-->
                    <div class="col-md-6 col-sm-12 col-xs-12">
                    	<div class="row clearfix">
                            <div class="col-lg-8 col-sm-6 col-xs-12 column">
                                <div class="footer-widget about-widget">
                                    <div class="logo"><RouterLink to="/"><img src="/assets/images/logo-2.png" class="img-responsive" alt=""></RouterLink></div>
                                    <div class="text">
                                        <p>Fungi for Life, Science, and the Planet.</p>
                                    </div>

                                    <ul class="contact-info">
                                    	<li><span class="icon fa fa-map-marker"></span> Bénin, Parakou</li>
                                        <li><span class="icon fa fa-phone"></span>(+229) 0196975772</li>
                                        <li><span class="icon fa fa-envelope-o"></span>contact@fungifornature.com</li>
                                    </ul>

                                    <div class="social-links-two clearfix">
                                    	<a href="#" class="facebook img-circle"><span class="fa fa-facebook-f"></span></a>
                                        <a href="#" class="twitter img-circle"><span class="fa fa-twitter"></span></a>
                                        <a href="#" class="google-plus img-circle"><span class="fa fa-google-plus"></span></a>
                                        <a href="#" class="linkedin img-circle"><span class="fa fa-pinterest-p"></span></a>
                                        <a href="#" class="linkedin img-circle"><span class="fa fa-linkedin"></span></a>
                                    </div>

                                </div>
                            </div>

                            <!--Footer Column-->
                            <div class="col-lg-4 col-sm-6 col-xs-12 column">
                                <h2>Our Project</h2>
                                <div class="footer-widget links-widget">
                                    <ul>
                                        <li v-for="project in allproject" :key="project.id"><router-link :to="`/singleproject/${project.slug}`">{{ project.title }}</router-link></li>
                                    </ul>

                                </div>
                            </div>
                    	</div>
                    </div><!--Two 4th column End-->

                    <!--Two 4th column-->
                    <div class="col-md-6 col-sm-12 col-xs-12">
                    	<div class="row clearfix">
                    		<!--Footer Column-->
                        	<div class="col-lg-7 col-sm-6 col-xs-12 column">
                            	<div class="footer-widget news-widget">
                                	<h2>Latest News</h2>

                                    <!--News Post-->
                                    <div class="news-post" v-for="(blog, index) in allblog" :key="index">
                                    	<div class="icon"></div>
                                        <div class="news-content"><figure class="image-thumb"><img style="width: 65px; height: 65px; object-fit: cover;" :src="blog.image" alt=""></figure><router-link :to="`/blogsingle/${blog.slug}`">{{ blog.title }}</router-link></div>
                                        <div style="font-style: italic; font-size: 12px;" class="post-author">Posted by {{ blog.user?.nom }} {{ blog.user?.prenom }}</div>
                                    </div>

                                </div>
                            </div>

                            <!--Footer Column-->
                            <div class="col-lg-5 col-sm-6 col-xs-12 column">
                                <div class="footer-widget links-widget">
                                	<h2>Quick Links</h2>
                                    <ul>
                                        <li><router-link to="about">About-us</router-link></li>
                                        <li><router-link to="project">Projects</router-link></li>
                                        <li><router-link to="event">Events</router-link></li>
                                        <li><router-link to="blog">Blog</router-link></li>
                                        <li><router-link to="contact">Contact</router-link></li>
                                        <li><a target="_blank" href="/admins">Admin</a></li>
                                    </ul>

                                </div>
                                <div class="gtranslate_wrapper mobile"></div>
                            </div>
                    	</div>
                    </div><!--Two 4th column End-->

                </div>

            </div>
        </div>

        <!--Footer Bottom-->
    	<div class="footer-bottom">
            <div class="auto-container clearfix">
                <!--Copyright-->
                <div class="copyright text-center">Copyright 2025 &copy;  <a href="#">Fungi For Nature</a></div>
            </div>
        </div>

    </footer>
</template>

<script setup>

    import { computed, onMounted, ref, nextTick } from 'vue';
    import { getData } from '../../plugin/api';
    import { RouterLink } from 'vue-router';
    import {themeInit} from '../../plugin/themeInit'

    const allproject = ref([]);
    const allblog = ref([]);

    const AllProjectFunction = async () =>{
        await getData('/allprojects')
            .then((response) => {
                allproject.value = response.data.data.data.slice(0,4);
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

        // Injecter les paramètres de configuration
        window.gtranslateSettings = {
            default_language: "en",
            languages: ["en", "fr"],
            wrapper_selector: ".gtranslate_wrapper",
            switcher_horizontal_position: "inline",
            alt_flags: {
            en: "usa"
            }
        };

        // Éviter d’ajouter plusieurs fois le script si déjà présent
        if (!document.querySelector('script[src="https://cdn.gtranslate.net/widgets/latest/dwf.js"]')) {
            const script = document.createElement("script");
            script.src = "https://cdn.gtranslate.net/widgets/latest/dwf.js";
            script.defer = true;
            document.head.appendChild(script);
        }

        AllProjectFunction()
        AllBlogFunction()
    })

</script>

<style scoped>

    .mobile{
        display: none !important;
    }

    @media screen and (max-width: 767px){
        .mobile{
            display: block !important;
        }
    }

</style>
