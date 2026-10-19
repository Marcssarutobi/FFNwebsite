<template>

    <!--Main Slider-->
    <section class="main-slider revolution-slider" :class="{ 'ffn-slider-loading': !slidesLoaded }">

        <!-- Affiché une fois les diapositives chargées : le Revolution Slider lit ses images une seule fois -->
        <div class="tp-banner-container" v-if="slidesLoaded">
            <div class="tp-banner">
                <ul>

                    <!-- Diapositives modifiables dans l'admin (Home Slider). La 1re est alignée à gauche avec un sous-titre, les autres sont centrées -->
                    <li v-for="(slide, index) in slides" :key="slide.position" class="imgs" :data-transition="index === 0 ? 'fade' : 'slidedown'" data-slotamount="1" data-masterspeed="1000" :data-thumb="slide.image"  data-saveperformance="off"  data-title="Fungi For Nature">
                    <img :src="slide.image"  alt=""  data-bgposition="center top" data-bgfit="cover" data-bgrepeat="no-repeat">

                    <template v-if="index === 0">

                    <div v-if="slide.title_light || slide.title" class="tp-caption sfr sfb tp-resizeme"
                    data-x="left" data-hoffset="90"
                    data-y="center" data-voffset="-50"
                    data-speed="1500"
                    data-start="1000"
                    data-easing="easeOutExpo"
                    data-splitin="none"
                    data-splitout="none"
                    data-elementdelay="0.01"
                    data-endelementdelay="0.3"
                    data-endspeed="1200"
                    data-endeasing="Power4.easeIn"><h1><strong><span class="normal-font">{{ slide.title_light }}</span> {{ slide.title }}</strong></h1></div>

                    <div v-if="slide.subtitle" class="tp-caption sfl sfb tp-resizeme"
                    data-x="left" data-hoffset="90"
                    data-y="center" data-voffset="40"
                    data-speed="1500"
                    data-start="1500"
                    data-easing="easeOutExpo"
                    data-splitin="none"
                    data-splitout="none"
                    data-elementdelay="0.01"
                    data-endelementdelay="0.3"
                    data-endspeed="1200"
                    data-endeasing="Power4.easeIn"><h3 class="bg-color">{{ slide.subtitle }}</h3></div>

                    <div v-if="slide.text" class="tp-caption sfl sfb tp-resizeme"
                    data-x="left" data-hoffset="90"
                    data-y="center" data-voffset="110"
                    data-speed="1500"
                    data-start="2000"
                    data-easing="easeOutExpo"
                    data-splitin="none"
                    data-splitout="none"
                    data-elementdelay="0.01"
                    data-endelementdelay="0.3"
                    data-endspeed="1200"
                    data-endeasing="Power4.easeIn">
                    <div class="text"><template v-for="(line, i) in lines(slide.text)" :key="i"><br v-if="i > 0">{{ line }}</template></div></div>

                    <div v-if="slide.button_label && slide.button_link" class="tp-caption sfr sfb tp-resizeme"
                    data-x="left" data-hoffset="90"
                    data-y="center" data-voffset="190"
                    data-speed="1500"
                    data-start="2000"
                    data-easing="easeOutExpo"
                    data-splitin="none"
                    data-splitout="none"
                    data-elementdelay="0.01"
                    data-endelementdelay="0.3"
                    data-endspeed="1200"
                    data-endeasing="Power4.easeIn">
                        <RouterLink v-if="isInternal(slide.button_link)" :to="slide.button_link" class="theme-btn btn-style-one">{{ slide.button_label }}</RouterLink>
                        <a v-else :href="slide.button_link" target="_blank" rel="noopener" class="theme-btn btn-style-one">{{ slide.button_label }}</a>
                    </div>

                    </template>

                    <template v-else>

                    <div v-if="slide.title_light" class="tp-caption sfl sfb tp-resizeme"
                    data-x="center" data-hoffset="0"
                    data-y="center" data-voffset="-120"
                    data-speed="1500"
                    data-start="500"
                    data-easing="easeOutExpo"
                    data-splitin="none"
                    data-splitout="none"
                    data-elementdelay="0.01"
                    data-endelementdelay="0.3"
                    data-endspeed="1200"
                    data-endeasing="Power4.easeIn"><h2 class="normal-font">{{ slide.title_light }}</h2></div>

                    <div v-if="slide.title" class="tp-caption sfr sfb tp-resizeme"
                    data-x="center" data-hoffset="0"
                    data-y="center" data-voffset="-30"
                    data-speed="1500"
                    data-start="1000"
                    data-easing="easeOutExpo"
                    data-splitin="none"
                    data-splitout="none"
                    data-elementdelay="0.01"
                    data-endelementdelay="0.3"
                    data-endspeed="1200"
                    data-endeasing="Power4.easeIn"><h2>{{ slide.title }}</h2></div>

                    <div v-if="slide.text" class="tp-caption sfl sfb tp-resizeme"
                    data-x="center" data-hoffset="0"
                    data-y="center" data-voffset="50"
                    data-speed="1500"
                    data-start="1500"
                    data-easing="easeOutExpo"
                    data-splitin="none"
                    data-splitout="none"
                    data-elementdelay="0.01"
                    data-endelementdelay="0.3"
                    data-endspeed="1200"
                    data-endeasing="Power4.easeIn"><h4><template v-for="(line, i) in lines(slide.text)" :key="i"><br v-if="i > 0">{{ line }}</template></h4></div>

                    <div v-if="slide.button_label && slide.button_link" class="tp-caption sfr sfb tp-resizeme"
                    data-x="center" data-hoffset="0"
                    data-y="center" data-voffset="120"
                    data-speed="1500"
                    data-start="2000"
                    data-easing="easeOutExpo"
                    data-splitin="none"
                    data-splitout="none"
                    data-elementdelay="0.01"
                    data-endelementdelay="0.3"
                    data-endspeed="1200"
                    data-endeasing="Power4.easeIn">
                        <RouterLink v-if="isInternal(slide.button_link)" :to="slide.button_link" class="theme-btn btn-style-one">{{ slide.button_label }}</RouterLink>
                        <a v-else :href="slide.button_link" target="_blank" rel="noopener" class="theme-btn btn-style-one">{{ slide.button_label }}</a>
                    </div>

                    </template>

                    </li>

                </ul>

            </div>
        </div>
    </section>


    <!--Main Features-->
    <section class="main-features">
    	<div class="auto-container">
        	<div class="title-box text-center">
            <!--	<h1>30000+</h1> -->
            	<h2>Field of Intervention</h2>
                <div class="text">
                   At Fungi For Nature, we believe that fungi hold the key to solving many of today’s environmental, agricultural, and health challenges. Through science, advocacy, and sustainable action, we explore the untapped potential of fungi to support biodiversity, protect ecosystems, and enhance food systems.

Below are the key fields in which we focus our efforts to create lasting impact.
                </div>
            </div>

            <div class="row clearfix">

                <!--Default Icon Column-->
                <div class="default-icon-column col-lg-3 col-md-6 col-xs-12">
                	<article class="inner-box">
                    	<div class="icon-box">
                        	<div class="icon"><span class="flaticon-illumination"></span></div>
                        </div>
                        <h3>Fungal Biodiversity</h3>
                        <div class="text">
                            Advancing the discovery and protection of fungi to preserve their vital role in ecosystems and human well-being.
                        </div>
                    </article>
                </div>

                <!--Default Icon Column-->
                <div class="default-icon-column col-lg-3 col-md-6 col-xs-12">
                	<article class="inner-box">
                    	<div class="icon-box">
                        	<div class="icon"><span class="flaticon-arrows-3"></span></div>
                        </div>
                        <h3>Environmental and climate protection</h3>
                        <div class="text">
                           Using fungi-based solutions to restore polluted ecosystems and mitigate the effects of climate change sustainably
                        </div>
                    </article>
                </div>

                <!--Default Icon Column-->
                <div class="default-icon-column col-lg-3 col-md-6 col-xs-12">
                	<article class="inner-box">
                    	<div class="icon-box">
                        	<div class="icon"><span class="flaticon-nature-1"></span></div>
                        </div>
                        <h3>Sustainable Agriculture</h3>
                        <div class="text">
                            Promoting organic farming through fungal bio-inoculants to enhance soil health and reduce dependence on synthetic inputs
                        </div>
                    </article>
                </div>

                <!--Default Icon Column-->
                <div class="default-icon-column col-lg-3 col-md-6 col-xs-12">
                	<article class="inner-box">
                    	<div class="icon-box">
                        	<div class="icon"><span class="flaticon-summer-3"></span></div>
                        </div>
                        <h3>Food Security</h3>
                        <div class="text">
                            Reducing post-harvest losses from pathogenic fungi to improve food availability and support global health
                        </div>
                    </article>
                </div>



            </div>
        </div>
    </section>


    <!--Featured Fluid Section-->
    <section class="featured-fluid-section">


    	<div class="outer clearfix">

            <!--Image Column-->
            <div class="image-column" style="background-image:url(/assets/images/resource/IMG-20220731-WA0013.jpg);"></div>

            <!--Text Column-->
            <article class="column text-column dark-column wow fadeInRight" data-wow-delay="0ms" data-wow-duration="1500ms" style="background-image:url(/assets/images/resource/fluid-image-2.jpg);">

                <div class="content-box pull-left">
                    <h2>Join <span class="theme_color">our event</span> </h2>
                	<div class="title-text">
                        Get Involved with <a href="#"><strong>Fungi For Nature</strong></a> 
                    </div>
                    <div class="text">
                        From scientific talks to conservation campaigns, our events offer opportunities for everyone to learn, connect, and make a difference. <br>
                        This section allows you to stay updated and get involved with FFN’s ongoing activities. If we have any current or upcoming events, you’ll find all the details here, whether it’s a workshop, a community outreach program, a webinar, or a conservation campaign.
                    <br>    Visitors can explore the event information and directly register or join us. It’s a simple way to connect, participate, and contribute to our mission!
                    </div> 
                    <RouterLink to="/contact" class="theme-btn btn-style-one">Join Now</RouterLink>
                    <RouterLink to="/domain" class="theme-btn btn-style-two">View details</RouterLink> 
                   
                </div>

                <div class="clearfix"></div>
            </article>

        </div>

    </section>


    <!--Recent Projects Section-->
    <section class="recent-projects">
    	<div class="auto-container">

            <div class="sec-title clearfix">
            	<div class="pull-left">
                    <h2>RECENT <span class="normal-font theme_color">Project</span></h2>
                    <div class="text">Explore our recent projects devoted to promoting fungi as key allies in ecological balance and sustainability. </div>
                </div>
                <div class="pull-right padd-top-30">
                	<RouterLink to="/project" class="theme-btn btn-style-three">See All Projects</RouterLink>
                </div>
            </div>
        	<div class="row clearfix" v-if="allproject.length > 0">

                <!--Default Featured Column-->
                <div class="column default-featured-column col-md-3 col-sm-3 col-xs-12" v-for="project in allproject" :key="project.id">
                    <article class="inner-box">
                        <figure class="image-box project">
                            <router-link :to="`/singleproject/${project.slug}`"><img :src="project.image" alt=""></router-link>
                        </figure>
                        <div class="content-box project-content">
                            <h3 class="title"><router-link :to="`/singleproject/${project.slug}`">{{ project.title }}</router-link></h3>
                            <div class="column-info">{{ project.category?.name }}</div>
                            <div class="text">{{ project.brief_description }}</div>
                            <router-link :to="`/singleproject/${project.slug}`" class="theme-btn btn-style-three">Learn More</router-link>
                        </div>
                    </article>
                </div>

            </div>
        </div>
    </section>


    <!--Two Column Fluid -->
    <section class="two-column-fluid">


    	<div class="outer clearfix">


            <article class="column left-column" style="background-image:url(/assets/images/resource/c4.jpg);">

                <div class="content-box pull-right">
                    <h2>Some <span class="normal-font theme_color">Facts</span></h2>
                    <div class="title-text">{{ siteSettings.facts_title }}</div>
                    <div class="text">{{ siteSettings.facts_text }}</div>
                    <br>

                    
                </div>

                <div class="clearfix"></div>
            </article>

            <article class="column right-column" style="background-image:url(/assets/images/resource/fluid-image-4.jpg);">

                <div class="content-box pull-left">
                	<div class="outer-box">
                    	<div class="quote-icon"><span class="fa fa-quote-left"></span></div>
                        <h2>word from <span class="normal-font">CEO</span></h2>

                        <!--Text Content-->
                        <div class="text-content">
                            <div class="text">
                                <p class="ffn-preline">{{ siteSettings.ceo_message }}</p>
                            </div>
                            <div class="information clearfix">
                                <div class="info">
                                    <figure class="image-thumb" v-if="siteSettings.ceo_photo"><img :src="siteSettings.ceo_photo" :alt="siteSettings.ceo_name"></figure>
                                    <h3>{{ siteSettings.ceo_name }}</h3>
                                    <p>{{ siteSettings.ceo_role }}</p>
                                </div>
                                
                            </div>
                        </div>

                    </div>
                </div>

                <div class="clearfix"></div>
            </article>

        </div>

    </section>

    <!--Events Section-->
    <section class="events-section latest-events">
    	<div class="auto-container">

            <div class="sec-title text-center">
                <h2>Latest <span class="normal-font theme_color">Event</span></h2>
                <div class="text">From forest walks to expert talks, our recent events celebrate fungi and their vital role in ecosystems. Come see what we've been up to! </div>
            </div>
        	<div class="row clearfix">

                <!--Featured Column-->
                <div class="column default-featured-column style-two col-lg-4 col-md-6 col-sm-6 col-xs-12" v-for="(event, index) in allevent" :key="index">
                	<article class="inner-box">
                		<figure class="image-box blogs">
                        	<router-link :to="'/eventsingle/'+event.slug"><img :src="event.image" alt=""></router-link>
                            <div class="post-tag" v-if="event.eventstatus === 'Upcoming'">{{ event.eventstatus }}</div>
                        </figure>
                        <div class="content-box blog-content">
                        	<h3 class="title"><router-link :to="'/eventsingle/'+event.slug">{{ event.title }}</router-link></h3>
                            <div class="column-info">In {{ event.location }}</div>
                            <div class="text">{{ event.brefdescription }} </div>
                            <router-link :to="'/eventsingle/'+event.slug" class="theme-btn btn-style-three">Read More</router-link>
                        </div>
                    </article>
                </div>

            </div>
        </div>
    </section>


    <!--Testimonials-->

    <!--Blog News Section-->
    <section class="blog-news-section latest-news" v-if="allblog.length">
    	<div class="auto-container">

            <div class="sec-title text-center">
                <h2>Latest <span class="normal-font theme_color">News</span></h2>
                <div class="text">Stay up to date with our recent blog posts exploring the wonders of fungi, sustainability, and nature's hidden connections. </div>
            </div>
        	<div class="row clearfix">

                <!--News Column-->
                <div class="column blog-news-column col-lg-4 col-md-6 col-sm-6 col-xs-12" v-for="(blog, index) in allblog" :key="index">
                	<article class="inner-box">
                		<figure class="image-box blogs">
                        	<router-link :to="`/blogsingle/${blog.slug}`"><img :src="blog.image" alt=""></router-link>
                            <div class="news-date">{{ formattedDates[index].day }}<span class="month">{{ formattedDates[index].month }}</span></div>
                        </figure>
                        <div class="content-box blog-content">
                        	<h3 class="title"><router-link :to="`/blogsingle/${blog.slug}`">{{ blog.title }}</router-link></h3>
                        	<div class="post-info clearfix">
                            	<div class="post-author">Posted by {{ blog.user?.nom }} {{ blog.user?.prenom }}</div>
                            </div>
                            <div class="text">{{ blog.brief_description }}</div>
                            <router-link :to="`/blogsingle/${blog.slug}`" class="theme-btn btn-style-three">Read More</router-link>
                        </div>
                    </article>
                </div>



            </div>
        </div>
    </section>


    <PartnersSection />


    <!--Parallax Section-->



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

<script setup>

    import PartnersSection from '../components/PartnersSection.vue';
    import { siteSettings } from '../../plugin/site';
    import { computed, onMounted, ref, nextTick } from 'vue';
    import { getData } from '../../plugin/api';
    import { RouterLink } from 'vue-router';
    import {themeInit} from '../../plugin/themeInit'

    const allproject = ref([]);
    const allblog = ref([]);
    const allevent = ref([]);


    // Diapositives du slider (modifiables dans l'admin) ; contenu d'origine tant que l'API n'a pas répondu
    const defaultSlide = (position, image) => ({
        position,
        image: '/assets/images/main-slider/' + image,
        title_light: 'Help us',
        title: 'promote the mushrooms',
        subtitle: null,
        text: 'Working together to preserve and promote mushrooms for the next generation.',
        button_label: 'Learn More',
        button_link: '/domain',
    });

    const slides = ref([
        {
            ...defaultSlide(1, 'direct.JPG'),
            title_light: 'Fungi',
            title: 'for Nature',
            subtitle: 'Save the world of mushrooms',
            text: "Our NGO works to protect mushrooms, an essential yet often overlooked\npart of our ecosystems. Through scientific research, and community projects,\nwe highlight the ecological, nutritional, and medicinal importance of mushrooms.",
        },
        defaultSlide(2, 'replace.jpeg'),
        defaultSlide(3, 'DSC00662.JPG'),
        defaultSlide(4, 'DSC00680.JPG'),
        defaultSlide(5, 'DSC00712.JPG'),
    ]);

    const slidesLoaded = ref(false);

    const SlidesFunction = async () =>{
        await getData('/homeslides')
            .then((response) => {
                if (response.data.slides.length > 0) {
                    slides.value = response.data.slides;
                }
            })
            .catch((error) => {
                console.error('Error fetching slides:', error);
            })
            .finally(() => {
                slidesLoaded.value = true;
            });
    }

    const lines = (text) => (text ?? '').split(/\r?\n/);
    const isInternal = (link) => typeof link === 'string' && link.startsWith('/') && !link.startsWith('//');

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
                allblog.value = response.data.data.data.slice(0,3);
            })
            .catch((error) => {
                console.error('Error fetching projects:', error);
            });
    }

    const AllEventsFunction = async () =>{
        await getData('/allevents')
            .then((response) => {
                allevent.value = response.data.data.data.slice(0,3);

                allevent.value.forEach((event) => {
                    const now = new Date();
                    const endDate = event.end_date ? new Date(event.end_date) : null;
                    const startDate = new Date(event.start_date);

                    if (endDate && endDate < now){
                        event.eventstatus = 'Pass';
                    } else if (!endDate && startDate < now) {
                        event.eventstatus = 'In progress';
                    } else {
                        event.eventstatus = 'Upcoming';
                    }

                });

            })
            .catch((error) => {
                console.error('Error fetching projects:', error);
            });
    }

    const formattedDates = computed(() => {
        return allblog.value.map(blog => {
            const date = new Date(blog.created_at);
            const day = date.getDate().toString().padStart(2, '0');

            const monthNames = ["JAN", "FEB", "MAR", "APR", "MAY", "JUN",
                                "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"];
            const month = monthNames[date.getMonth()];

            return { day, month };
        });
    });

    onMounted(async ()=>{
        // Le slider lit ses images à l'initialisation (themeInit, lancé après les projets) : on les charge avant
        await SlidesFunction()
        AllProjectFunction()
        AllBlogFunction()
        AllEventsFunction()
    })


</script>

<style scoped>

.ffn-preline{
    white-space: pre-line;
}


/* Réserve la place du diaporama pendant le chargement des diapositives */
.ffn-slider-loading{
    min-height: 70vh;
    background: #1f2a1d;
}




.imgs::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(to right, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3));
    
    pointer-events: none; /* pour ne pas gêner les clics sur les boutons */
}

.blogs a{
    width: 380px;
    height: 271.42px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}
.blogs a img{
    max-width: 100%;
    max-height: 100%;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.blog-content .title{
    width: 100%;
    height: 60.41px;
    display: -webkit-box;
    -webkit-line-clamp: 2;        /* Nombre de lignes max */
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}

.blog-content   .text{
    width: 100%;
    height: 75.61px;
    display: -webkit-box;
    -webkit-line-clamp: 2;        /* Nombre de lignes max */
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}

.project a{
    width: 281.25px;
    height: 187.42px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.project a img{
    max-width: 100%;
    max-height: 100%;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.project-content .title{
    width: 100%;
    height: 50.41px;
    display: -webkit-box;
    -webkit-line-clamp: 2;        /* Nombre de lignes max */
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}

.project-content .text{
    width: 100%;
    height: 75.61px;
    display: -webkit-box;
    -webkit-line-clamp: 2;        /* Nombre de lignes max */
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}




@media screen and (max-width: 991px) {

    .project a{
        width: 100% !important;
        height: 307.42px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .outer-box{
        padding: 0 !important;
    }

    .featured-fluid-section .column,
    .featured-fluid-section .image-column,
    .featured-fluid-section .text-column {
        width: 100%;
        float: none;
        position: relative;
        display: block;
    }

    .featured-fluid-section .image-column {
        height: 300px;
        position: relative; /* plus absolute */
    }

    .featured-fluid-section .text-column .content-box {
        padding: 40px 20px;
    }

    .featured-fluid-section .dark-column:before {
        background: rgba(25, 25, 25, 0.85);
    }

    .two-column-fluid .column,
    .two-column-fluid .left-column,
    .two-column-fluid .right-column {
        width: 100%;
        float: none;
        position: relative;
        display: block;
        min-height: auto;
    }

    .two-column-fluid .left-column .content-box,
    .two-column-fluid .right-column .content-box {
        padding: 40px 20px;
        float: none;
        max-width: 100%;
    }

    .two-column-fluid .right-column .quote-icon {
        position: relative;
        top: 0;
        left: 0;
        margin-bottom: 20px;
    }

    .two-column-fluid .right-column .info {
        padding-left: 80px;
    }

    .two-column-fluid .right-column .info .image-thumb {
        left: 0;
        top: 0;
    }

    .two-column-fluid .right-column .info .image-thumb img {
        width: 60px;
    }

    .two-column-fluid .right-column .text-content {
        text-align: left;
    }

    .two-column-fluid .icon-box {
        float: none;
        width: 100%;
        margin-bottom: 30px;
        text-align: center;
    }

    .two-column-fluid .icon-box .lower-box {
        border: none;
        padding: 0;
    }
}


</style>
