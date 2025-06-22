<template>
    <!--Page Title-->
    <section class="page-title" style="background-image:url(/assets/images/background/page-title-bg.jpg);">
    	<div class="auto-container">
        	<div class="sec-title">
                <h1>Single <span class="normal-font">Project</span></h1>
                <div class="bread-crumb"><a href="index.html">Home</a> / <a href="index.html">Projects</a> / <a href="#" class="current">Single Project</a></div>
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
                    <section class="projects-section project-details no-padd-bottom no-padd-top padd-right-20">

                        <div class="column default-featured-column">
                            <article class="inner-box">
                                <figure class="image-boxs">
                                    <img :src="projectData.image" alt="">
                                </figure>
                                <div class="content-box padd-top-40">
                                    <div class="row detail-header clearfix">
                                        <div class="col-md-12 ">
                                            <h2>{{ projectData.title }}</h2>
                                        </div>
                                        <!-- <div class="col-md-4 col-sm-12 pull-right text-right"><a href="#" class="theme-btn btn-style-two">DOnate NOW</a></div> -->
                                    </div>
                                    <div class="text" style="text-align: justify !important;" v-html="projectData.content">

                                    </div>

                                </div>
                            </article>
                        </div>

                    </section>

                    <hr>

                    <!--Related Posts Section-->
                    <section class="related-posts-section padd-right-20" v-if="categoryData.length > 0">

                    	<h2>Related <span class="normal-font">Projects</span></h2>

                        <!--Related Posts Carousel-->
                        <div class="related-posts-carousel">
                        	<!--Post-->
                            <div class="column default-featured-column" v-for="(project, index) in categoryData" :key="index">
                                <article class="inner-box">
                                    <figure class="image-boxe">
                                        <img :src="project.image" alt="">
                                    </figure>
                                    <div class="content-boxe">
                                        <h3 class="title"><RouterLink :to="`/singleproject/${project.slug}`">{{ project.title }}</RouterLink></h3>
                                        <div class="column-info">{{ categoryName }}</div>
                                        <RouterLink :to="`/singleproject/${project.slug}`" class="theme-btn btn-style-three">Learn More</RouterLink>
                                    </div>
                                </article>
                            </div>
                        </div>

                    </section>

                </div>
                <!--Content Side-->

                <!--Sidebar-->
                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                    <aside class="sidebar">

                        <!-- Search Form -->
                        <!-- <div class="widget search-box">

                            <form method="post" action="index.html">
                                <div class="form-group">
                                    <input type="search" name="search-field" value="" placeholder="Enter keyword">
                                    <button type="submit"><span class="icon flaticon-tool-5"></span></button>
                                </div>
                            </form>

                        </div> -->

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
                        <div class="widget recent-posts wow fadeInUp" data-wow-delay="0ms" data-wow-duration="1500ms" v-if="categoryData.length > 0">
                            <div class="sidebar-title"><h3>Latest Posts</h3></div>

                            <article class="post" v-for="(project, index) in categoryData" :key="index">
                            	<figure class="post-thumb"><img :src="project.image" alt=""></figure>
                                <h4><RouterLink :to="`/singleproject/${project.slug}`">{{ project.title }}</RouterLink></h4>
                                <div class="post-info"><span class="icon flaticon-people-1"></span> By {{ project.user?.nom }} {{ project.user?.prenom }} </div>
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
            	<a href="#" class="theme-btn btn-style-two">Donate Now!</a>
                <a href="#" class="theme-btn btn-style-one">Join Event</a>
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
                    There are many variations of passages of Lorem Ipsum available but the majority have
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
    import { computed, nextTick, onMounted, ref, watch } from 'vue';
    import { RouterLink, useRoute } from 'vue-router';
    import { getData, getSingleData } from '../../plugin/api';
    import {themeInit} from '../../plugin/themeInit'

    const route = useRoute();
    const projectData = ref({});
    const projectSlug = computed(() => route.params.slug);
    const categoryData = ref({});
    const categoryName = ref('');
    const allcategory = ref([])

    const GetProject = async ()=>{
        await getSingleData('/project/' + projectSlug.value)
            .then((response) => {
                if (response.status === 200) {
                    projectData.value = response.data.data;
                } else {
                    console.error('Error fetching project data:', response);
                }
            })
            .catch((error) => {
                console.error('Error fetching project data:', error);
            });

        if (projectData.value) {
            await getSingleData('/showcategory/'+ projectData.value.category_id)
            .then((response) => {
                if (response.status === 200) {
                    categoryName.value = response.data.category.name;
                    categoryData.value = response.data.category.projects
                        .filter(project => project.id !== projectData.value.id)
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

    watch(projectSlug,()=>{
        GetProject();
    })


    onMounted(() => {
        GetProject();
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
    .image-boxe{
        width: 100%;
        height: 296.66px;
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
