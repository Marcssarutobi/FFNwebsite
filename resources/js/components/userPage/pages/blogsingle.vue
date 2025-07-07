<template>
    <!--Page Title-->
    <section class="page-title" style="background-image:url(/assets/images/background/imagesMenu.jpeg);">
    	<div class="auto-container">
        	<div class="sec-title">
                <h1>Blog <span class="normal-font">Details</span></h1>
                <div class="bread-crumb"><RouterLink to="/">Home</RouterLink> / <a href="#" class="current">Blog Details</a></div>
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
                                    <img :src="blogData.image" alt="">
                                    <div class="news-date">{{ formattedDate.day }}<span class="month">{{ formattedDate.month }}</span></div>
                                </figure>
                                <div class="content-box padd-top-30">
                                    <h3>{{ blogData.title }}</h3>
                                    <div class="post-info clearfix">
                                        <div class="post-author">Posted by {{ blogData.user?.nom }} {{ blogData.user?.prenom }}</div>
                                        <div class="post-options clearfix">
                                            <a href="#" class="comments-count"><span class="icon flaticon-communication-2"></span> 6</a>
                                            <a href="#" class="fav-count"><span class="icon flaticon-favorite-1"></span> 14</a>
                                        </div>
                                    </div>
                                    <div class="text" style="text-align: justify;" v-html="blogData.content"></div>
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

                        <!--Comments Area-->
                        <!-- <div class="comments-area">
                            <div class="group-title text-uppercase"><h2>3 Comments</h2></div>

                            <div class="comment-box">
                                <div class="comment wow fadeInUp" data-wow-delay="0ms" data-wow-duration="1500ms">
                                    <div class="author-thumb"><img src="/assets/images/resource/author-thumb-1.jpg" alt=""></div>
                                    <div class="comment-info"><strong>Janntul Ferdous</strong><div class="comment-time">November 20, 2014 at 8:31 pm</div></div>
                                    <div class="text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, At accusam aliquyam diam diam dolore dolores duo eirmod eos erat, et nonumy sed tempor et et invidunt justo labore. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis.</div>
                                    <a class="reply-btn" href="#"><span class="txt">Reply</span></a>
                                </div>

                                <div class="comment reply-comment wow fadeInUp" data-wow-delay="0ms" data-wow-duration="1500ms">
                                    <div class="author-thumb"><img src="/assets/images/resource/author-thumb-2.jpg" alt=""></div>
                                    <div class="comment-info"><strong>Juliana Rose</strong><div class="comment-time">November 20, 2014 at 8:31 pm</div></div>
                                    <div class="text">At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</div>
                                </div>

                                <div class="comment wow fadeInUp" data-wow-delay="0ms" data-wow-duration="1500ms">
                                    <div class="author-thumb"><img src="/assets/images/resource/author-thumb-3.jpg" alt=""></div>
                                    <div class="comment-info"><strong>Rashed kabir</strong><div class="comment-time">November 20, 2014 at 8:31 pm</div></div>
                                    <div class="text">Whether you need to create a brand from scratch, including marketing materials and a beautiful and functional website or whether you are looking for a design.</div>
                                    <a class="reply-btn" href="#"><span class="txt">Reply</span></a>
                                </div>

                            </div>
                        </div> -->



                       

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
                            <div class="sidebar-title"><h3>Latest Posts</h3></div>

                            <article class="post" v-for="(blog, index) in categoryData" :key="index">
                            	<figure class="post-thumb"><img :src="blog.image" alt=""></figure>
                                <h4><RouterLink :to="'/blogsingle/'+blog.slug">{{ blog.title }}</RouterLink></h4>
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

    import { computed, nextTick, onMounted, ref, watch } from 'vue';
    import { RouterLink, useRoute } from 'vue-router';
    import { getData, getSingleData } from '../../plugin/api';
    import {themeInit} from '../../plugin/themeInit'

    const route = useRoute();
    const blogData = ref({});
    const blogSlug = computed(() => route.params.slug);
    const categoryData = ref({});
    const categoryName = ref('');
    const allcategory = ref([]);

     const GetBlog = async ()=>{
        await getSingleData('/blog/' + blogSlug.value)
            .then((response) => {
                if (response.status === 200) {
                    blogData.value = response.data.data;
                } else {
                    console.error('Error fetching blog data:', response);
                }
            })
            .catch((error) => {
                console.error('Error fetching blog data:', error);
            });

            if (blogData.value) {
            await getSingleData('/showcategory/'+ blogData.value.category_id)
            .then((response) => {
                if (response.status === 200) {
                    categoryName.value = response.data.category.name;
                    categoryData.value = response.data.category.blogs
                        .filter(blog => blog.id !== blogData.value.id)
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

    // Formatage de la date
    const formattedDate = computed(() => {
        const date = new Date(blogData.value.created_at)
        const day = date.getDate().toString().padStart(2, '0')

        const monthNames = ["JAN", "FEB", "MAR", "APR", "MAY", "JUN",
                            "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"]
        const month = monthNames[date.getMonth()]

        return { day, month }
    })

    watch(blogSlug,()=>{
        GetBlog();
    })


    onMounted(() => {
        GetBlog();
        AllCategorieFunction();
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
    .image-box{
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
