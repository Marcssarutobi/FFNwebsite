<template>

    <!--Page Title-->
    <section class="page-title" style="background-image:url(/assets/images/background/imagesMenu.jpeg);">
        <div class="auto-container">
            <div class="sec-title">
                <h1>Advisor</h1>
                <div class="bread-crumb"><RouterLink to="/">Home</RouterLink> / <RouterLink to="domain" class="current">About Us</RouterLink></div>
            </div>
        </div>
    </section>


    <!--Default Section-->



    <!--Team Section-->
    <section class="team-section">
        <div class="auto-container">

            <div class="sec-title text-center">
                <h2>Our <span class="normal-font theme_color">Advisor</span></h2>
                <div class="text">
                    Our advisors are recognized experts and thought leaders who bring in-depth knowledge, scientific rigor, and strategic insight to guide our work. <br> Their support helps us align our actions with global best practices and ensure long-term impact. 
                </div>
            </div>

            <div class="row clearfix">

                <!--Column-->
                <article class="column team-member col-lg-3 col-md-3 col-sm-6 col-xs-12 wow fadeInUp" v-for="member in teamMembers" :key="member.id" data-wow-delay="0ms" data-wow-duration="1500ms">
                    <div class="inner-box">
                        <figure class="image"><RouterLink :to="`/details/${member.slug}`"><img :src="member.image" alt=""></RouterLink></figure>
                        <div class="member-info">
                            <h3> <RouterLink :to="`/details/${member.slug}`">{{ member.name }}</RouterLink></h3>
                            <div class="designation">{{ member.profession }}</div>
                        </div>
                        <div class="content">
                            <div class="text">
                                <p>
                                    {{ member.brief_description }}
                                </p>
                            </div>
                            <div class="social-links">
                                <a v-if="member.facebook_link !== '' || member.facebook_link !== null" :href="member.facebook_link" target="_blank" rel="noopener noreferrer"><span class="fa-brands fa-facebook-f"></span></a>
                                <a v-if="member.twitter_link !== '' || member.twitter_link !== null" :href="member.twitter_link" target="_blank" rel="noopener noreferrer"><span class="fa-brands fa-x-twitter"></span></a>
                                <a v-if="member.instagram_link !== '' || member.instagram_link !== null" :href="member.instagram_link" target="_blank" rel="noopener noreferrer"><span class="fa-brands fa-google-plus"></span></a>
                                <a v-if="member.linkedin_link !== '' || member.linkedin_link !== null" :href="member.linkedin_link" target="_blank" rel="noopener noreferrer"><span class="fa-brands fa-linkedin"></span></a>
                            </div>
                        </div>
                    </div>
                </article>

                <!--Column
                <article class="column team-member col-lg-3 col-md-3 col-sm-6 col-xs-12 wow fadeInUp" data-wow-delay="300ms" data-wow-duration="1500ms">
                    <div class="inner-box">
                        <figure class="image"><a href="mailto:mail@email.com"><img src="/assets/images/resource/avatarimage.jpg" alt=""></a></figure>
                        <div class="member-info">
                            <h3>Lorem Ipsum</h3>
                            <div class="designation">Mycology & Biodiversity</div>
                        </div>
                        <div class="content">
                            <div class="text">
                                <p>
                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                                </p>
                            </div>
                            <div class="social-links">
                                <a href="#" class="facebook img-circle"><span class="fa-brands fa-facebook-f"></span></a>
                                <a href="#" class="twitter img-circle"><span class="fa-brands fa-x-twitter"></span></a>
                                <a href="#" class="google-plus img-circle"><span class="fa-brands fa-instagram"></span></a>
                                <a href="#" class="linkedin img-circle"><span class="fa-brands fa-linkedin"></span></a>
                            </div>
                        </div>
                    </div>
                </article>-->

                <!--Column
                <article class="column team-member col-lg-3 col-md-3 col-sm-6 col-xs-12 wow fadeInUp" data-wow-delay="600ms" data-wow-duration="1500ms">
                    <div class="inner-box">
                        <figure class="image"><a href="mailto:mail@email.com"><img src="/assets/images/resource/avatarimage.jpg" alt=""></a></figure>
                        <div class="member-info">
                            <h3>Lorem Ipsum</h3>
                            <div class="designation"> Mycology & Biodiversity</div>
                        </div>
                        <div class="content">
                            <div class="text">
                                <p>
                                   Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,

                                </p>
                            </div>
                            <div class="social-links">
                                <a href="#" class="facebook img-circle"><span class="fa-brands fa-facebook-f"></span></a>
                                <a href="#" class="twitter img-circle"><span class="fa-brands fa-x-twitter"></span></a>
                                <a href="#" class="google-plus img-circle"><span class="fa-brands fa-instagram"></span></a>
                                <a href="#" class="linkedin img-circle"><span class="fa-brands fa-linkedin"></span></a>
                            </div>
                        </div>
                    </div>
                </article>-->

                <!--Column
                <article class="column team-member col-lg-3 col-md-3 col-sm-6 col-xs-12 wow fadeInUp" data-wow-delay="900ms" data-wow-duration="1500ms">
                    <div class="inner-box">
                        <figure class="image"><a href="mailto:mail@email.com"><img src="/assets/images/resource/avatarimage.jpg" alt=""></a></figure>
                        <div class="member-info">
                            <h3>Lorem Ipsum</h3>
                            <div class="designation">Finance Lead</div>
                        </div>
                        <div class="content">
                            <div class="text">
                                <p>
                                   Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                                </p>
                            </div>
                            <div class="social-links">
                                <a href="#" class="facebook img-circle"><span class="fa-brands fa-facebook-f"></span></a>
                                <a href="#" class="twitter img-circle"><span class="fa-brands fa-x-twitter"></span></a>
                                <a href="#" class="google-plus img-circle"><span class="fa-brands fa-instagram"></span></a>
                                <a href="#" class="linkedin img-circle"><span class="fa-brands fa-linkedin"></span></a>
                            </div>
                        </div>
                    </div>
                </article>-->

            </div>

        </div>
    </section>


    <!--Testimonials-->




    <!--Blog News Section-->


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
import { getData } from '../../plugin/api';
import { onMounted, ref } from 'vue';

// Exemple de variable réactive
const teamMembers = ref([])

// Exemple de fonction pour charger les membres de l'équipe
async function fetchTeamMembers() {
    await getData('/advisors')
        .then(function (res){
            if (res.status === 200) {
                teamMembers.value = res.data.advisors
            }
        })
}

onMounted(()=>{
    fetchTeamMembers()
})

</script>

<style scoped>

.image a{
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    width: 270px !important;
    height: 347px !important;
    overflow: hidden !important;
}
.image a img{
    max-width: 100% !important;
    max-height: 100% !important;
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
}

.content .text p {
    width: 270px !important;
    height: 135px !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
    display: -webkit-box !important;
    -webkit-line-clamp: 5 !important;
    -webkit-box-orient: vertical !important;
}

</style>
