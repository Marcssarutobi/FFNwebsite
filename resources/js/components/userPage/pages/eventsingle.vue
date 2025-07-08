<template>
    <!--Page Title-->
    <section class="page-title" style="background-image:url(/assets/images/background/imagesMenu.jpeg);">
    	<div class="auto-container">
        	<div class="sec-title">
                <h1>SIngle <span class="normal-font">Event</span></h1>
                <div class="bread-crumb"><RouterLink to="/">Home</RouterLink>  / <a href="#">Events</a> / <a href="#" class="current">Single Event</a></div>
            </div>
        </div>
    </section>


    <!--Sidebar Page-->
    <div class="sidebar-page">
    	<div class="auto-container">
        	<div class="row clearfix">

                <!--Content Side-->
                <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">

                    <!--Projects Section-->
                    <section class="events-section event-details no-padd-bottom no-padd-top padd-right-20">

                        <div class="column default-featured-column style-two">
                            <article class="inner-box">
                                <figure class="image-boxs">
                                    <img :src="eventData.image" alt="">
                                </figure>
                                <div class="content-box padd-top-40">
                                    <div class="row detail-header clearfix">
                                        <div class="col-md-12 col-sm-12">
                                            <h3><a href="#">{{ eventData.title }}</a></h3>
                                            <div class="column-info no-margin-bottom">In {{ eventData.location }}</div>
                                        </div>
                                        <!-- <div class="col-md-4 col-sm-12 pull-right text-right"><a href="#" class="theme-btn btn-style-two">Join With Us</a></div> -->
                                    </div>
                                    <hr>

                                    <div class="text mt-4" v-html="eventData.content">

                                    </div>

                                    <br>

                                    <div class="other-info">
                                    	<div class="row clearfix">
                                        	<!--Info Column-->
                                            <div class="info-column column col-md-6 col-xs-12">
                                            	<h3>Event Details</h3>
                                                <ul class="info-box">
                                                    <li><span class="icon fa fa-map-marker"></span><strong>Location</strong> {{ eventData.location }}</li>
                                                    <li><span class="icon fa fa-calendar"></span><strong>Date</strong> {{ formatDateWithMonthName(eventData.start_date) }} - {{ formatDateWithMonthName(eventData.end_date) }}</li>
                                                    <!-- <li><span class="icon fa fa-clock-o"></span><strong>Time</strong> 10:00 am - 2:00 pm</li> -->
                                                </ul>
                                            </div>

                                            <!--Map Column-->
                                            <div class="map-column column col-md-6 col-xs-12">
                                                <!--Map Container-->
                                                <div class="map-container">
                                                    <!--Map Canvas-->
                                                    <div class="map-canvas"
                                                        data-zoom="12"
                                                        data-lat="-37.817085"
                                                        data-lng="144.955631"
                                                        data-type="roadmap"
                                                        data-hue="#ffc400"
                                                        data-title="Envato"
                                                        data-content="Melbourne VIC 3000, Australia<br><a href='mailto:info@youremail.com'>info@youremail.com</a>"
                                                        style="height: 300px;">
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </article>
                        </div>

                    </section>

                </div>
                <!--Content Side-->

                <!--Sidebar-->
                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                    <aside class="sidebar">

                        <!-- Popular Categories -->
                        <div class="widget popular-categories wow fadeInUp" data-wow-delay="0ms" data-wow-duration="1500ms">
                            <div class="sidebar-title"><h3>Categories</h3></div>

                            <ul class="list">
                            	<li v-for="(cat,index) in allcategory" :key="index"><a class="clearfix" href="#">{{ cat.name }}</a></li>
                                <!-- <li><a class="clearfix" href="#">Forest</a></li>
                                <li><a class="clearfix" href="#">Water</a></li>
                                <li><a class="clearfix" href="#">Nature</a></li>
                                <li><a class="clearfix" href="#">Soler</a></li>
                                <li><a class="clearfix" href="#">Eco Energy</a></li> -->
                            </ul>

                        </div>


                        <!-- Recent Posts -->
                        <div class="widget recent-posts wow fadeInUp" data-wow-delay="0ms" data-wow-duration="1500ms">
                            <div class="sidebar-title"><h3>Latest Events</h3></div>

                            <article class="post" v-for="(event, index) in categoryData" :key="index">
                            	<figure class="post-thumb"><img :src="event.image" alt=""></figure>
                                <h4><RouterLink :to="'/eventsingle/'+event.slug">{{ event.title }}</RouterLink></h4>
                                <div class="post-info"><span class="icon flaticon-people-1"></span> By {{ event.user?.nom }} {{ event.user?.prenom }} </div>
                            </article>



                        </div>

                    </aside>


                </div>
                <!--Sidebar-->


            </div>
        </div>
    </div>


    <!--Parallax Section-->


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

<script setup>

    import { computed, nextTick, onMounted, ref, watch } from 'vue';
    import { RouterLink, useRoute } from 'vue-router';
    import { getData, getSingleData } from '../../plugin/api';
    import {themeInit} from '../../plugin/themeInit'

    const route = useRoute();
    const eventData = ref({});
    const eventSlug = computed(() => route.params.slug);
    const categoryData = ref({});
    const categoryName = ref('');
    const allcategory = ref([])

    const GetEvent = async ()=>{
        await getSingleData('/event/' + eventSlug.value)
            .then((response) => {
                if (response.status === 200) {
                    eventData.value = response.data.data;
                } else {
                    console.error('Error fetching project data:', response);
                }
            })
            .catch((error) => {
                console.error('Error fetching project data:', error);
            });

            if (eventData.value) {
            await getSingleData('/showcategory/'+ eventData.value.category_id)
            .then((response) => {
                if (response.status === 200) {
                    categoryName.value = response.data.category.name;
                    categoryData.value = response.data.category.events
                        .filter(project => project.id !== eventData.value.id)
                        .sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
                        .slice(0, 3);

                    nextTick(); // wait for DOM updates
                    setTimeout(() => {
                        themeInit();
                    }, 0);

                } else {
                    console.error('Error fetching category data:', response);
                }
            })
            .catch((error) => {
                console.error('Error fetching category data:', error);
            });
        }


    }

    const AllCategorieFunction = async ()=>{
        await getData('/allcategories')
                .then(response => {
                    if (response.status === 200) {
                        allcategory.value = response.data.categories.slice(0, 5);

                    }
                })
    }

    function formatDateWithMonthName(data) {
        if (!data) return null;
        const date = new Date(data);
        if (isNaN(date)) return null;

        const options = {
            year: 'numeric',
            month: 'long',  // mois en toutes lettres
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
        };

        return date.toLocaleDateString('en-US', options);
    }

    watch(eventSlug,()=>{
        GetEvent();
    })


    onMounted(() => {
        GetEvent();
        AllCategorieFunction();
    });

</script>

<style scoped>
.image-boxs{
    width: 850px;
    height: 516.89px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}
.image-boxs img{
    max-width: 100%;
    max-height: 100%;
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.image-boxe{
    width: 419.38px;
    height: 296.66px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}
.image-boxe img{
    max-width: 100%;
    max-height: 100%;
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.content-boxe .title{
    width: 100%;
    height: 50.41px;
    display: -webkit-box;
    -webkit-line-clamp: 2;        /* Nombre de lignes max */
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}

@media screen and (max-width: 991px){
    .image-boxs{
        width: 100%;
        height: 316.89px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .padd-right-20{
        padding-right: 0 !important;
    }
}
</style>
