<template>
    <!--Page Title-->
    <section class="page-title" style="background-image:url(/assets/images/background/imagesMenu.jpeg);">
    	<div class="auto-container">
        	<div class="sec-title">
                <h1>Our <span class="normal-font">Gallery</span></h1>
                <div class="bread-crumb"><RouterLink to="/">Home</RouterLink>  / <a href="#" class="current">Gallery</a></div>
            </div>
        </div>
    </section>


    <!--Gallery Section-->
    <section class="gallery-section">
        <div class="auto-container">

            <!--Filter-->
            <div class="filters text-center">
                <ul class="filter-tabs filter-btns clearfix anim-3-all">
                    <li class="active filter" data-role="button" data-filter="all">All</li>
                <!--    <li class="filter" data-role="button" data-filter=".environment">Environment</li>
                    <li class="filter" data-role="button" data-filter=".eco">Eco</li>
                    <li class="filter" data-role="button" data-filter=".energy">Energy</li>
                    <li class="filter" data-role="button" data-filter=".animals">Animals</li>
                    <li class="filter" data-role="button" data-filter=".plants">Plants</li> -->
                </ul>
            </div>

            <!--Filter List-->
            <div class="row filter-list clearfix" v-if="allimage.length > 0">

                <!--Column-->
                <div class="column mix mix_all eco plants col-md-4 col-sm-6 col-xs-12" v-for="(img,index) in allimage" :key="index">
                    <!--Default Portfolio Item-->
                    <div class="default-portfolio-item">
                        <div class="inner-box text-center">
                            <!--Image Box-->
                            <figure class="image-box"><img :src="img.image" alt=""></figure>
                            <div class="overlay-box">
                                <div class="inner-content">
                                    <div class="content">
                                        <a class="arrow lightbox-image" :href="img.image" title="Image Caption Here"><span class="icon flaticon-cross-4"></span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




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

<script  setup>
    import { nextTick, onMounted, ref } from 'vue';
    import { getData } from '../../plugin/api';
    import {themeInit} from '../../plugin/themeInit'

    const allimage = ref([])

    const AllImageFunction = async ()=>{
        await getData('/allimages')
                .then(async (response)=>{
                    if (response.status === 200) {
                        allimage.value = response.data.gly
                        await nextTick(); // wait for DOM updates
                        setTimeout(() => {
                            themeInit();
                        }, 0);
                    }
                })
    }

    onMounted(()=>{
        AllImageFunction()
    })

</script>

<style>

</style>
