<template>
    <!--Page Title-->
    <section class="page-title" style="background-image:url(/assets/images/background/imagesMenu.jpeg);">
    	<div class="auto-container">
        	<div class="sec-title">
                <h1>Event</h1>
                <div class="bread-crumb"><RouterLink to="/">Home</RouterLink> / <RouterLink to="/event">Events</RouterLink> / <span class="current">Event</span></div>
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
                                            <h3>{{ eventData.title }}</h3>
                                            <div class="ffn-meta">
                                                <span v-if="eventData.start_date"><span class="fa fa-calendar"></span>{{ dateRange(eventData) }}</span>
                                                <span v-if="eventData.location"><span class="fa fa-map-marker"></span>{{ eventData.location }}</span>
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-4 col-sm-12 pull-right text-right"><a href="#" class="theme-btn btn-style-two">Join With Us</a></div> -->
                                    </div>
                                    <hr>

                                    <div class="text mt-4 ffn-richtext" v-html="formatRichText(eventData.content)"></div>

                                    <br>

                                    <div class="other-info">
                                    	<div class="row clearfix">
                                        	<!--Info Column-->
                                            <div class="info-column column col-md-12 col-xs-12">
                                            	<h3>Event Details</h3>
                                                <ul class="info-box">
                                                    <li><span class="icon fa fa-map-marker"></span><strong>Location</strong> {{ eventData.location }}</li>
                                                    <li><span class="icon fa fa-calendar"></span><strong>Date</strong> {{ formatDateWithMonthName(eventData.start_date) }}<template v-if="eventData.end_date"> - {{ formatDateWithMonthName(eventData.end_date) }}</template></li>
                                                    <!-- <li><span class="icon fa fa-clock-o"></span><strong>Time</strong> 10:00 am - 2:00 pm</li> -->
                                                </ul>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="ffn-share"><ShareLinks :title="eventData.title" /></div>
                                    <RouterLink to="/event" class="ffn-back"><span class="fa fa-arrow-left"></span>All events</RouterLink>

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
                            	<li v-for="(cat,index) in allcategory" :key="index"><span class="clearfix">{{ cat.name }}</span></li>
                                <!-- <li><a class="clearfix" href="#">Forest</a></li>
                                <li><a class="clearfix" href="#">Water</a></li>
                                <li><a class="clearfix" href="#">Nature</a></li>
                                <li><a class="clearfix" href="#">Soler</a></li>
                                <li><a class="clearfix" href="#">Eco Energy</a></li> -->
                            </ul>

                        </div>


                        <!-- Recent Posts -->
                        <div class="widget recent-posts wow fadeInUp" data-wow-delay="0ms" data-wow-duration="1500ms" v-if="categoryData.length">
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

    import { computed, nextTick, onMounted, ref, watch } from 'vue';
    import { RouterLink, useRoute } from 'vue-router';
    import { getData, getSingleData } from '../../plugin/api';
    import { formatRichText } from '../../plugin/richtext'
    import {themeInit} from '../../plugin/themeInit'
    import ShareLinks from '../components/ShareLinks.vue';

    const route = useRoute();
    const eventData = ref({});
    const eventSlug = computed(() => route.params.slug);
    const categoryData = ref({});
    const categoryName = ref('');
    const allcategory = ref([])

    // « 3 – 7 November 2025 » ; dates « Y-m-d H:i:s » lues avec un T (Safari)
    const toDate = (d) => new Date(String(d).replace(' ', 'T'));
    const fmt = (d, opts) => toDate(d).toLocaleDateString('en-GB', opts);
    const dateRange = (e) => {
        const full = { day: 'numeric', month: 'long', year: 'numeric' };
        if (!e.end_date || fmt(e.start_date, full) === fmt(e.end_date, full)) return fmt(e.start_date, full);
        const a = toDate(e.start_date), b = toDate(e.end_date);
        if (a.getMonth() === b.getMonth() && a.getFullYear() === b.getFullYear()) return `${a.getDate()} – ${fmt(e.end_date, full)}`;
        return `${fmt(e.start_date, { day: 'numeric', month: 'long' })} – ${fmt(e.end_date, full)}`;
    };

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
        const date = new Date(String(data).replace(' ', 'T'));
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
