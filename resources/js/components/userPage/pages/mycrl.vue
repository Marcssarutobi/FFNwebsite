<template>
    <!--Page Title-->
    <section class="page-title" style="background-image:url(/assets/images/background/imagesMenu.jpeg);">
    	<div class="auto-container">
        	<div class="sec-title">
                <h1>Field <span class="normal-font">Intervention</span></h1>
                <div class="bread-crumb"><RouterLink to="/">Home</RouterLink>  / <a href="#">FIELD </a> / <a href="#" class="current">MycRI</a></div>
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
                                    <img src="/assets/images/resource/mysol.jpg" alt="">
                                </figure>
                                <div class="content-box padd-top-40">
                                    <div class="row detail-header clearfix">
                                        <div class="col-md-12 ">
                                            <h2>Mycological Research and Innovation (MycRI)</h2>
                                        </div>
                                        <!-- <div class="col-md-4 col-sm-12 pull-right text-right"><a href="#" class="theme-btn btn-style-two">DOnate NOW</a></div> -->
                                    </div>
                                    <div class="text" style="text-align: justify !important;" >
                                            This unit is dedicated to generating scientific knowledge on fungi, with a focus on taxonomy, ecology, genetics, and the symbiotic or pathogenic interactions of fungal species.
                                            It develops and applies innovative technologies such as DNA sequencing, artificial intelligence for species recognition, and in vitro cultivation methods.
                                            MycRI also promotes applied research in fields such as medicine, biotechnology, and industry, where fungi offer promising and sustainable solutions.

                                    </div>

                                </div>
                            </article>
                        </div>

                    </section>



                </div>
                <!--Content Side-->

  


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
