<template>
    <!--Page Title-->
    <section class="page-title" style="background-image:url(/assets/images/background/imagesMenu.jpeg);">
    	<div class="auto-container">
        	<div class="sec-title">
                <h1>Our <span class="normal-font">Videos</span></h1>
                <div class="bread-crumb"><RouterLink to="/">Home</RouterLink>  / <a href="#" class="current">Videos</a></div>
            </div>
        </div>
    </section>


    <!--Videos Section-->
    <section class="gallery-section">
        <div class="auto-container">

            <div class="row clearfix" v-if="allvideo.length > 0">

                <!--Column-->
                <div class="column col-md-6 col-sm-12 col-xs-12 video-column" v-for="(video,index) in allvideo" :key="index">
                    <div class="video-box">
                        <div class="video-frame">
                            <iframe v-if="getEmbedUrl(video.video_url)" :src="getEmbedUrl(video.video_url)" :title="video.title" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen loading="lazy"></iframe>
                            <video v-else-if="video.video_file" :src="video.video_file" controls preload="metadata"></video>
                        </div>
                        <div class="video-content">
                            <h3>{{ video.title }}</h3>
                            <p v-if="video.description">{{ video.description }}</p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="text-center" style="padding: 80px 0;" v-else-if="loaded">
                <h3>No videos yet</h3>
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
    import { onMounted, ref } from 'vue';
    import { getData } from '../../plugin/api';
    import { getEmbedUrl } from '../../plugin/video';

    const allvideo = ref([])
    const loaded = ref(false)

    const AllVideoFunction = async ()=>{
        await getData('/allvideos')
                .then((response)=>{
                    if (response.status === 200) {
                        allvideo.value = response.data.videos
                    }
                })
                .finally(()=>{
                    loaded.value = true
                })
    }

    onMounted(()=>{
        AllVideoFunction()
    })

</script>

<style scoped>
    .video-column{
        margin-bottom: 40px;
    }
    .video-box{
        background: #fff;
        box-shadow: 0 0 15px rgba(0,0,0,.08);
        height: 100%;
    }
    .video-frame{
        position: relative;
        width: 100%;
        padding-top: 56.25%;
        background: #000;
    }
    .video-frame iframe,
    .video-frame video{
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: 0;
    }
    .video-content{
        padding: 20px 25px;
    }
    .video-content h3{
        font-size: 20px;
        margin-bottom: 10px;
    }
    .video-content p{
        margin: 0;
        white-space: pre-line;
    }
</style>
