<template>
    <!--Page Title-->
    <section class="page-title" style="background-image:url(/assets/images/background/imagesMenu.jpeg);">
    	<div class="auto-container">
        	<div class="sec-title">
                <h1>Our <span class="normal-font">Blog</span></h1>
                <div class="bread-crumb"><RouterLink to="/">Home</RouterLink> / <RouterLink to="/blog" class="current">Blog</RouterLink></div>
            </div>
        </div>
    </section>


    <!--Blog News Section-->
    <section class="blog-news-section latest-news">
    	<div class="auto-container">

        	<div class="row clearfix">

                <!--News Column-->
                <div class="column blog-news-column col-lg-4 col-md-6 col-sm-6 col-xs-12" v-for="(blog, index) in allblog" :key="index">
                	<article class="inner-box">
                		<figure class="image-box">
                        	<router-link :to="`/blogsingle/${blog.slug}`"><img :src="blog.image" alt=""></router-link>
                            <div class="news-date">{{ formattedDates[index].day }}<span class="month">{{ formattedDates[index].month }}</span></div>
                        </figure>
                        <div class="content-box">
                        	<h3 class="title"><router-link :to="`/blogsingle/${blog.slug}`">{{ blog.title }}</router-link></h3>
                        	<div class="post-info clearfix">
                            	<div class="post-author">Posted by {{ blog.user?.nom }} {{ blog.user?.prenom }}</div>
                                <div class="post-options clearfix">
                                	<a href="#" class="comments-count"><span class="icon flaticon-communication-2"></span> 6</a>
                                    <a href="#" class="fav-count"><span class="icon flaticon-favorite-1"></span> 14</a>
                                </div>
                            </div>
                            <div class="text">{{ blog.brief_description }}</div>
                            <router-link :to="`/blogsingle/${blog.slug}`" class="theme-btn btn-style-three">Read More</router-link>
                        </div>
                    </article>
                </div>

            </div>

            <!-- Styled Pagination -->
            <div class="styled-pagination text-center padd-top-20 margin-bott-40">
                <Paginate v-model="currentPage" :page-count="totalPage" :clickHandler="AllBlogFunction" :prevText="' <span class=\'fa fa-angle-left\'></span>&ensp;Prev'" :nextText="'Next&ensp;<span class=\'fa fa-angle-right\'></span>'" :container-class="''" :page-class="'page-item'" :active-class="'active'" :tag-name="'ul'"></Paginate>
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
                		<a href="#" class="theme-btn btn-style-one">Subscribe Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>

    import { computed, onMounted, ref } from 'vue';
    import { getData } from '../../plugin/api';
    import Paginate from 'vuejs-paginate-next';
    import { RouterLink } from 'vue-router';

    const allblog = ref([]);
    const currentPage = ref(1);
    const totalPage = ref(0);

    const AllBlogFunction = async (page) =>{
        await getData('/allblogs?page='+page)
            .then((response) => {
                allblog.value = response.data.data.data;
                totalPage.value = response.data.data.last_page;
                currentPage.value = response.data.data.current_page;
            })
            .catch((error) => {
                console.error('Error fetching projects:', error);
            });
    }

    const formattedDates = computed(() => {
        return allblog.value.map(blog => {
            const date = new Date(blog.created_at);
            const day = date.getDate().toString().padStart(2, '0');

            const monthNames = ["JAN", "FEB", "MAR", "APR", "MAY", "JUN",
                                "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"];
            const month = monthNames[date.getMonth()];

            return { day, month };
        });
    });

    onMounted(() => {
        AllBlogFunction();
    });

</script>

<style scoped >
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
