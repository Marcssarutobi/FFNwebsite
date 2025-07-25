<template>
  
    <!--Page Title-->
    <section class="page-title" style="background-image:url(/assets/images/background/imagesMenu.jpeg);">
    	<div class="auto-container">
        	<div class="sec-title">
                <h1>Fungi Education <span class="normal-font">Details</span></h1>
                <div class="bread-crumb"><RouterLink to="/">Home</RouterLink> / <a href="#" class="current">Fungi Education Details</a></div>
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
                    <section class="blog-news-section blog-detail no-padd-bottom no-padd-top padd-right-20">

                        <!--News Column-->
                        <div class="column blog-news-column">
                            <article class="inner-box">
                                <figure class="image-box">
                                    <img :src="EducationData.image" alt="">
                                </figure>
                                <div class="content-box padd-top-30">
                                    <h3>{{ EducationData.title }}</h3>
                                    <div class="post-info clearfix">
                                        <div class="post-author">Posted by {{ EducationData.user?.nom }} {{ EducationData.user?.prenom }}</div>
                                        <!-- <div class="post-options clearfix">
                                            <a href="#" class="comments-count"><span class="icon flaticon-communication-2"></span> 6</a>
                                            <a href="#" class="fav-count"><span class="icon flaticon-favorite-1"></span> 14</a>
                                        </div> -->
                                    </div>
                                    <div class="text" style="text-align: justify;" v-html="EducationData.content"></div>
                                </div>

                               <div class="post-share-options clearfix">
                                	<div class="pull-left tags"><strong>Share this post</strong> : </div>
                                    <div class="pull-right social-links-two clearfix">
                                    	<a href="#" class="facebook img-circle"><span class="fa fa-facebook-f"></span></a>
                                        <a href="#" class="twitter img-circle"><span class="fa fa-x-twitter"></span></a>
                                        <a href="#" class="linkedin img-circle"><span class="fa fa-linkedin"></span></a>
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



                        <!-- Recent Posts -->
                        <div class="widget recent-posts wow fadeInUp" data-wow-delay="0ms" data-wow-duration="1500ms">
                            <div class="sidebar-title"><h3>Latest Posts</h3></div>

                            <article class="post" v-for="(blog, index) in recentPost" :key="index">
                            	<figure class="post-thumb"><img :src="blog.image" alt=""></figure>
                                <h4><RouterLink :to="'/fungiEducationSingle/'+blog.slug">{{ blog.title }}</RouterLink></h4>
                                <div class="post-info"><span class="icon flaticon-people-1"></span> By {{ blog.user?.nom }} {{ blog.user?.prenom }} </div>
                            </article>


                        </div>

                    </aside>


                </div>
                <!--Sidebar-->


            </div>
        </div>
    </div>



     <!--Parallax Section-->
    <section class="parallax-section" style="background-image:url(/assets/images/parallax/image-1.jpg);">
    	<div class="auto-container">
        	<div class="text-center">
            	<h2>The Best time to <span class="theme_color">plant tree</span> is now</h2>
                <div class="text">Some lorem ipsum subtitle will be here ipsum dolor</div>
            	<RouterLink to="/contact" class="theme-btn btn-style-one">Join Now</RouterLink>
                <RouterLink to="/domain" class="theme-btn btn-style-two">View details</RouterLink>
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

<script setup>

import { computed, nextTick, onMounted, ref, watch } from 'vue';
import { RouterLink, useRoute } from 'vue-router';
import { getData, getSingleData } from '../../plugin/api';

const route = useRoute();
const EducationData = ref({});
const EducationSlug = computed(() => route.params.slug);
const recentPost = ref([]);

const GetFungiEducation = async () => {
    await getSingleData('/showfungieducation/' + EducationSlug.value)
        .then((response) => {
            EducationData.value = response.data.data;
            
        })
        .catch((error) => {
            console.error('Error fetching fungi education details:', error);
        });
};

const AllFungiEducation = async ()=>{
    await getData('/allFungiEducation')
        .then((response) => {
            const allData = response.data.data.data;
            recentPost.value = allData.filter((post) => post.slug !== EducationSlug.value).slice(0, 3);
        })
        .catch((error) => {
            console.error('Error fetching recent posts:', error);
        });
}

watch(EducationSlug,()=>{
    GetFungiEducation();
})

onMounted(() => {
    GetFungiEducation();
    AllFungiEducation();
});

</script>

<style>

</style>