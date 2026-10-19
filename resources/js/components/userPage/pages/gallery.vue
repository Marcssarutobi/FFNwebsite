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

            <!-- Grille à vignettes uniformes : chaque photo est recadrée au même format -->
            <div class="ffn-gallery" v-if="allimage.length > 0">
                <a v-for="(img,index) in allimage" :key="index" class="ffn-gallery-item lightbox-image" rel="gallery" :href="img.image" title="Fungi For Nature">
                    <img :src="img.image" alt="Fungi For Nature" loading="lazy">
                    <span class="ffn-gallery-overlay"><span class="flaticon-cross-4"></span></span>
                </a>
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
                        <RouterLink to="/contact" class="theme-btn btn-style-one">Subscribe Now</RouterLink>
                		
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

<style scoped>
    .ffn-gallery{
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
    }
    .ffn-gallery-item{
        position: relative;
        display: block;
        aspect-ratio: 4 / 3;
        overflow: hidden;
        border-radius: 6px;
        background: #f2f2f2;
        box-shadow: 0 4px 14px rgba(0, 0, 0, .08);
    }
    .ffn-gallery-item img{
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        display: block;
        transition: transform .5s ease;
    }
    .ffn-gallery-overlay{
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(23, 150, 7, .55);
        color: #fff;
        font-size: 28px;
        opacity: 0;
        transition: opacity .3s ease;
    }
    .ffn-gallery-item:hover img{
        transform: scale(1.06);
    }
    .ffn-gallery-item:hover .ffn-gallery-overlay{
        opacity: 1;
    }
    @media (max-width: 991px){
        .ffn-gallery{
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }
    }
    @media (max-width: 575px){
        .ffn-gallery{
            grid-template-columns: 1fr;
        }
    }
</style>
