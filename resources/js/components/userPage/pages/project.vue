<template>

    <!--Page Title-->
    <section class="page-title" style="background-image:url(/assets/images/background/page-title-bg.jpg);">
    	<div class="auto-container">
        	<div class="sec-title">
                <h1>Our <span class="normal-font">Projects</span></h1>
                <div class="bread-crumb"><a href="index.html">Home</a> / <a href="#" class="current">Projects</a></div>
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
                    <section class="projects-section no-padd-bottom no-padd-top padd-right-20">

                        <div class="row clearfix">

                            <!--Default Featured Column-->
                            <div class="column default-featured-column col-md-6 col-sm-6 col-xs-12" v-for="project in allproject" :key="project.id">
                                <article class="inner-box">
                                    <figure class="image-box">
                                        <router-link :to="`/singleproject/${project.slug}`"><img :src="project.image" alt=""></router-link>
                                    </figure>
                                    <div class="content-box">
                                        <h3 class="title"><router-link :to="`/singleproject/${project.slug}`">{{ project.title }}</router-link></h3>
                                        <div class="column-info">{{ project.category?.name }}</div>
                                        <div class="text">{{ project.brief_description }}</div>
                                        <router-link :to="`/singleproject/${project.slug}`" class="theme-btn btn-style-three">Learn More</router-link>
                                    </div>
                                </article>
                            </div>

                            

                        </div>

                        <!-- Styled Pagination -->
                        <div class="styled-pagination padd-top-20 margin-bott-40">
                            <Paginate v-model="currentPage" :page-count="totalPage" :clickHandler="AllProjectFunction" :prevText="' <span class=\'fa fa-angle-left\'></span>&ensp;Prev'" :nextText="'Next&ensp;<span class=\'fa fa-angle-right\'></span>'" :container-class="''" :page-class="'page-item'" :active-class="'active'" :tag-name="'ul'"></Paginate>
                            <!-- <ul>
                                <li><a class="prev" href="#"><span class="fa fa-angle-left"></span>&ensp;Prev</a></li>
                                <li><a href="#">1</a></li>
                                <li><a href="#" class="active">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a class="next" href="#">Next&ensp;<span class="fa fa-angle-right"></span></a></li>
                            </ul> -->
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

                        <!-- Archives -->
                        <div class="widget archives-list wow fadeInUp" data-wow-delay="0ms" data-wow-duration="1500ms">
                            <div class="sidebar-title"><h3>Archives</h3></div>

                            <ul class="list">
                            	<li><a href="#">April 2016</a></li>
                                <li><a href="#">March  2016</a></li>
                                <li><a href="#">February 2016</a></li>
                                <li><a href="#">January 2016</a></li>
                                <li><a href="#">December 2015</a></li>
                                <li><a href="#">November 2015</a></li>
                            </ul>

                        </div>

                        <!-- Popular Tags -->
                        <div class="widget popular-tags">
                            <div class="sidebar-title"><h3>KeyWords</h3></div>

                            <a href="#">Child</a>
                            <a href="#">Water</a>
                            <a href="#">Donate</a>
                            <a href="#">Money</a>
                            <a href="#">Volunteer</a>

                        </div>

                    </aside>


                </div>
                <!--Sidebar-->


            </div>
        </div>
    </div>

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

    const allproject = ref([]);
    const currentPage = ref(1);
    const totalPage = ref(0);

    const AllProjectFunction = async (page) =>{
        await getData('/allprojects?page='+page)
            .then((response) => {
                allproject.value = response.data.data.data;
                totalPage.value = response.data.data.last_page;
                currentPage.value = response.data.data.current_page;
            })
            .catch((error) => {
                console.error('Error fetching projects:', error);
            });
    }

    onMounted(() => {
        AllProjectFunction();
    });

</script>

<style scoped >
    .image-box{
        width: 419.38px;
        height: 296.66px;
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .image-box img{
        max-width: 100%;
        max-height: 100%;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .content-box .title{
        width: 100%;
        height: 50.41px;
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
    li.active{
        background: #3A3A3A !important;
    }
    li.active a{
        color: #fff !important;
    }
</style>
