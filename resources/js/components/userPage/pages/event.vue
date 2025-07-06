<template>
    <!--Page Title-->
    <section class="page-title" style="background-image:url(/assets/images/background/imagesMenu.jpeg);">
    	<div class="auto-container">
        	<div class="sec-title">
                <h1>Events</h1>
                <div class="bread-crumb"><RouterLink to="/">Home</RouterLink> / <a href="#" class="current">Events</a></div>
            </div>
        </div>
    </section>


    <!--Events Section-->
    <section class="events-section latest-events">
    	<div class="auto-container">

        	<div class="row clearfix">

                <!--Featured Column-->
                <div class="column default-featured-column style-two col-lg-4 col-md-6 col-sm-6 col-xs-12" v-for="(event, index) in allevent" :key="index">
                	<article class="inner-box">
                		<figure class="image-box">
                        	<router-link :to="'/eventsingle/'+event.slug"><img :src="event.image" alt=""></router-link>
                            <div class="post-tag" v-if="event.eventstatus === 'Upcoming'">{{ event.eventstatus }}</div>
                        </figure>
                        <div class="content-box">
                        	<h3 class="title"><router-link :to="'/eventsingle/'+event.slug">{{ event.title }}</router-link></h3>
                            <div class="column-info">In {{ event.location }}</div>
                            <div class="text">{{ event.brefdescription }} </div>
                            <router-link :to="'/eventsingle/'+event.slug" class="theme-btn btn-style-three">Read More</router-link>
                        </div>
                    </article>
                </div>

            </div>

            <!-- Styled Pagination -->
            <div class="styled-pagination text-center padd-top-20 margin-bott-40">
                <Paginate v-model="currentPage" :page-count="totalPage" :clickHandler="AllEventsFunction" :prevText="' <span class=\'fa fa-angle-left\'></span>&ensp;Prev'" :nextText="'Next&ensp;<span class=\'fa fa-angle-right\'></span>'" :container-class="''" :page-class="'page-item'" :active-class="'active'" :tag-name="'ul'"></Paginate>
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
                		<a href="#" class="theme-btn btn-style-one">Subscribe Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>

    import { onMounted, ref } from 'vue';
    import { getData } from '../../plugin/api';
    import Paginate from 'vuejs-paginate-next'

    const allevent = ref([]);
    const currentPage = ref(1);
    const totalPage = ref(0);

    const AllEventsFunction = async (page) =>{
        await getData('/allevents?page='+page)
            .then((response) => {
                allevent.value = response.data.data.data;
                totalPage.value = response.data.data.last_page;
                currentPage.value = response.data.data.current_page;

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

    onMounted(() => {
        AllEventsFunction();
    });

</script>

<style scoped >
    .image-box a{
        width: 380px;
        height: 226.66px;
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .image-box a img{
        max-width: 100%;
        max-height: 100%;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .content-box .title{
        width: 100%;
        height: 70.41px;
        display: -webkit-box;
        -webkit-line-clamp: 2;        /* Nombre de lignes max */
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .content-box .text{
        width: 100%;
        height: 75.61px;
        display: -webkit-box;
        -webkit-line-clamp: 2;        /* Nombre de lignes max */
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    ::v-deep(.page-item){
        border-radius: 5px !important;
    }
    ::v-deep(.page-item.active .page-link){
        background: #3A3A3A !important;
        color: white !important;
        width: 40px !important;
        height: 40px !important;
        padding: 6px 5px !important;
        border-radius: 3px !important;
    }
    ::v-deep(.page-item .page-link){
        padding: 6px 25px !important;
    }
</style>
