<template>

    <!--Page Title-->
    <section class="page-title" style="background-image:url(/assets/images/background/imagesMenu.jpeg);">
        <div class="auto-container">
            <div class="sec-title">
                <h1>Fungi Education</h1>
                <div class="bread-crumb"><RouterLink to="/">Home</RouterLink> / <RouterLink to="fungiEducation" class="current">Fungi Education</RouterLink></div>
            </div>
        </div>
    </section>

        <section class="default-section">
            <div class="auto-container">
                <div class="row clearfix">
                    
                    <!--News Column-->
                    <div class="column blog-news-column col-lg-4 col-md-6 col-sm-6 col-xs-12" v-for="(educ, index) in allfungiEducation" :key="index">
                        <article class="inner-box">
                            <figure class="image-box">
                                <router-link :to="`/fungiEducationSingle/${educ.slug}`"><img :src="educ.image" alt=""></router-link>
                            </figure>
                            <div class="content-box">
                                <h3 class="title"><router-link :to="`/fungiEducationSingle/${educ.slug}`">{{ educ.title }}</router-link></h3>
                                <div class="post-info clearfix">
                                    <div class="post-author">Posted by {{ educ.user?.nom }} {{ educ.user?.prenom }}</div>
                                    <!-- <div class="post-options clearfix">
                                        <a href="#" class="comments-count"><span class="icon flaticon-communication-2"></span> 6</a>
                                        <a href="#" class="fav-count"><span class="icon flaticon-favorite-1"></span> 14</a>
                                    </div> -->
                                </div>
                                <div class="text">{{ educ.brief_description }}</div>
                                <router-link :to="`/fungiEducationSingle/${educ.slug}`" class="theme-btn btn-style-three">Read More</router-link>
                            </div>
                        </article>
                    </div>

                </div>
                <!-- Styled Pagination -->
                <div class="styled-pagination text-center padd-top-20 margin-bott-40">
                    <Paginate v-model="currentPage" :page-count="totalPage" :clickHandler="AllFungiEducationFunction" :prevText="' <span class=\'fa fa-angle-left\'></span>&ensp;Prev'" :nextText="'Next&ensp;<span class=\'fa fa-angle-right\'></span>'" :container-class="''" :page-class="'page-item'" :active-class="'active'" :tag-name="'ul'"></Paginate>
                    <!-- <ul>
                        <li><a class="prev" href="#"><span class="fa fa-angle-left"></span>&ensp;Prev</a></li>
                        <li><a href="#">1</a></li>
                        <li><a href="#" class="active">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a class="next" href="#">Next&ensp;<span class="fa fa-angle-right"></span></a></li>
                    </ul> -->
                </div>
            </div>
        </section>


       <!--end Section-->


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
import { onMounted, ref } from 'vue';
import { getData } from '../../plugin/api';
import Paginate from 'vuejs-paginate-next'

const allfungiEducation = ref([]);
const currentPage = ref(1);
const totalPage = ref(0);


const AllFungiEducationFunction = async (page)=>{
    await getData('/allFungiEducation?page='+page)
        .then((response) => {
            allfungiEducation.value = response.data.data.data;
            totalPage.value = response.data.data.last_page;
            currentPage.value = response.data.data.current_page;

        })
        .catch((error) => {
            console.error('Error fetching fungi education:', error);
        });
}

onMounted(() => {
    AllFungiEducationFunction(1);
});


</script>

<style scoped>

    .image-box a{
        width: 419.38px;
        height: 296.66px;
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
    .content-box{
        padding-top: 0px;
    }
    .content-box .title{
        width: 100%;
        height: 60.41px;
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
