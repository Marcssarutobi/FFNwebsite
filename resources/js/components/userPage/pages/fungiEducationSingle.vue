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
                                        <!-- -->
                                    </div>
                                    <div class="text" style="text-align: justify;" v-html="EducationData.content"></div>
                                </div>

                               <ShareLinks :title="EducationData.title" />

                            </article>
                        </div>
                       
                    </section>


                </div>
                <!--Content Side-->

                <!--Sidebar-->
                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                    <aside class="sidebar">



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

    import ShareLinks from '../components/ShareLinks.vue';
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