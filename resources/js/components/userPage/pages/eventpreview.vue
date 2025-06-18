<template>
  
    <!--Page Title-->
    <section class="page-title" style="background-image:url(/assets/images/background/page-title-bg.jpg);">
    	<div class="auto-container">
        	<div class="sec-title">
                <h1>SIngle <span class="normal-font">Event</span></h1>
                <div class="bread-crumb"><RouterLink to="/">Home</RouterLink> / <RouterLink to="/event">Events</RouterLink> / <a href="#" class="current">Single Event</a></div>
            </div>
        </div>
    </section>

    <!--Sidebar Page-->
    <div class="sidebar-page">
    	<div class="auto-container">
        	<div class="row clearfix">

                <!--Content Side-->
                <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">

                    <div class="btns mb-3" style="margin-bottom: 1.5rem !important;" v-if="eventData.status === 'approbation'">
                        <button @click="ApprovedEvent" class="btn btn-success p-3 btn-lg me-3" style="margin-right: 1rem !important; font-size: 18px;">Approved</button>
                        <button class="btn btn-danger p-3 btn-lg " style="font-size: 18px;" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Declined</button>

                        <div class="collapse mt-3" id="collapseExample">
                            <div class="card card-body">
                                <form @submit.prevent="DeclenedEvent">
                                    <div class="form-group">
                                        <label for="declineReason">Reason for Decline</label>
                                        <textarea id="declineReason" :class="{ 'is-invalid': isEmpty.reasonForDecline }" v-model="reasonForDecline" class="form-control" placeholder="Enter reason for decline" rows="5" style="font-size: 18px;"></textarea>
                                        <span v-if="isEmpty.reasonForDecline" class="text-danger">{{ msgInput.reasonForDecline }}</span>
                                    </div>
                                    <button class="btn btn-dark mt-3 p-4" style="font-size: 18px; width: 100px;">Submit</button>
                                </form>

                            </div>
                        </div>


                    </div>

                    <!--Projects Section-->
                    <section class="events-section event-details no-padd-bottom no-padd-top padd-right-20">

                        <div class="column default-featured-column style-two">
                            <article class="inner-box">
                                <figure class="image-box">
                                    <img :src="eventData.image" alt="">
                                </figure>
                                <div class="content-box padd-top-40">
                                    <div class="row detail-header clearfix">
                                        <div class="col-md-12 col-sm-12">
                                            <h3><a href="#">{{ eventData.title }}</a></h3>
                                            <div class="column-info no-margin-bottom">{{ formatDateWithMonthName(eventData.start_date) }} in {{ eventData.location }}</div>
                                        </div>
                                        <!-- <div class="col-md-4 col-sm-12 pull-right text-right"><a href="#" class="theme-btn btn-style-two">Join With Us</a></div> -->
                                    </div>
                                    <hr>

                                    <div class="text" style="text-align: justify !important;" v-html="eventData.content">
                                    	
                                    </div>

                                    <br><br>

                                    <div class="other-info">
                                    	<div class="row clearfix">
                                        	<!--Info Column-->
                                            <div class="info-column column col-md-6 col-xs-12">
                                            	<h3>Event Details</h3> <br>
                                                <ul class="info-box">
                                                    <li><span class="icon fa fa-map-marker"></span><strong>Location</strong> {{ eventData.location }}</li>
                                                    <li><span class="icon fa fa-calendar"></span><strong>Date</strong> {{ formatDateWithMonthName(eventData.start_date) }} - {{ formatDateWithMonthName(eventData.end_date) }}</li>
                                                    <!-- <li><span class="icon fa fa-clock-o"></span><strong>Time</strong> {{ formatTime(eventData.start_time) }} - {{ formatTime(eventData.end_time) }}</li> -->
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

                        <!-- Search Form -->
                        <div class="widget search-box">

                            <form method="post" action="index.html">
                                <div class="form-group">
                                    <input type="search" name="search-field" value="" placeholder="Enter keyword">
                                    <button type="submit"><span class="icon flaticon-tool-5"></span></button>
                                </div>
                            </form>

                        </div>

                        <!-- Popular Categories -->
                        <div class="widget popular-categories wow fadeInUp" data-wow-delay="0ms" data-wow-duration="1500ms">
                            <div class="sidebar-title"><h3>Categories</h3></div>

                            <ul class="list">
                            	<li><a class="clearfix" href="#">Environment</a></li>
                                <li><a class="clearfix" href="#">Forest</a></li>
                                <li><a class="clearfix" href="#">Water</a></li>
                                <li><a class="clearfix" href="#">Nature</a></li>
                                <li><a class="clearfix" href="#">Soler</a></li>
                                <li><a class="clearfix" href="#">Eco Energy</a></li>
                            </ul>

                        </div>


                        <!-- Recent Posts -->
                        <div class="widget recent-posts wow fadeInUp" data-wow-delay="0ms" data-wow-duration="1500ms">
                            <div class="sidebar-title"><h3>Latest Posts</h3></div>

                            <article class="post">
                            	<figure class="post-thumb"><img src="/assets/images/resource/post-thumb-6.jpg" alt=""></figure>
                                <h4><a href="#">Deforestation is threating by  activites...</a></h4>
                                <div class="post-info"><span class="icon flaticon-people-1"></span> By Rashed Kabir </div>
                            </article>

                             <article class="post">
                            	<figure class="post-thumb"><img src="/assets/images/resource/post-thumb-7.jpg" alt=""></figure>
                                <h4><a href="#">Deforestation is threating by  activites...</a></h4>
                                <div class="post-info"><span class="icon flaticon-people-1"></span> By Rashed Kabir </div>
                            </article>

                            <article class="post">
                            	<figure class="post-thumb"><img src="/assets/images/resource/post-thumb-8.jpg" alt=""></figure>
                                <h4><a href="#">Deforestation is threating by  activites...</a></h4>
                                <div class="post-info"><span class="icon flaticon-people-1"></span> By Rashed Kabir </div>
                            </article>

                        </div>

                    </aside>


                </div>
                <!--Sidebar-->


            </div>
        </div>
    </div>

</template>

<script setup>
    import { onMounted, ref } from 'vue';
    import { RouterLink, useRoute } from 'vue-router';
    import { getSingleData, postData, putData } from '../../plugin/api';
    import Swal from 'sweetalert2';

    const route = useRoute();
    const getID = ref(route.params.id)
    const eventData = ref({});
    const reasonForDecline = ref('');
    const isEmpty = ref({})
    const msgInput = ref({})

    const GetEvent = async ()=>{
        await getSingleData('/showevent/' + getID.value)
            .then((response) => {
                if (response.status === 200) {
                    eventData.value = response.data.data;
                } else {
                    console.error('Error fetching event data:', response);
                }
            })
            .catch((error) => {
                console.error('Error fetching event data:', error);
            });
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

    const ApprovedEvent= async ()=>{
        eventData.value.status = "published";
        await putData('/updateevent/'+eventData.value.id,{
            status: eventData.value.status
        }).then((response) => {
            if (response.status === 200) {
                GetEvent();
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Event approved successfully",
                    showConfirmButton: false,
                    timer: 1500
                })
            }
        }).catch((error) => {
            console.error('Error approving event:', error);
        });
    }

    const inputEmpty = ()=>{
        if (reasonForDecline.value === '') {
            isEmpty.value.reasonForDecline = true;
            msgInput.value.reasonForDecline = "Please enter a reason for decline";
        } else {
            isEmpty.value.reasonForDecline = false;
            msgInput.value.reasonForDecline = "";
        }
    }

    const DeclenedEvent = async ()=>{

        inputEmpty();

        const allEmpty = Object.values(isEmpty.value).every(value => value === false)

        if (allEmpty) {

            // ✅ Afficher un loader
            Swal.fire({
                title: "Please wait...",
                text: "Sending in progress...",
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            await postData('/sendDeclenedevent/'+eventData.value.id,{
                reason: reasonForDecline.value
            }).then(async (response)=>{
                if (response.status === 200) {
                    eventData.value.status = "draft";
                    await putData('/updateevent/'+eventData.value.id,{
                        status: eventData.value.status
                    }).then((response) => {
                        if (response.status === 200) {
                            GetEvent();
                            Swal.fire({
                                position: "center",
                                icon: "success",
                                title: "Event declined successfully",
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    }).catch((error) => {
                        console.error('Error updating event status:', error);
                    });
                }
            }).catch((error)=>{
                console.error('Error sending declined event:', error);
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "Error sending declined event",
                    showConfirmButton: true,
                })
            })

        }


    }

    onMounted(() => {
        GetEvent();
    });

</script>

<style scoped>
.image-box{
    width: 850px;
    height: 516.89px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}
.image-box img{
    min-width: 100%;
    min-height: 100%;
    width: 100%;
    height: 100%;
    object-fit: cover;
}
</style>