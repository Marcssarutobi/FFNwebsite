<template>
  
    <!--Page Title-->
    <section class="page-title" style="background-image:url(/assets/images/background/imagesMenu.jpeg);">
    	<div class="auto-container">
        	<div class="sec-title">
                <h1>Category <span class="normal-font">Details</span></h1>
                <div class="bread-crumb"><RouterLink to="/">Home</RouterLink>  / <a href="#" class="current">Category Details</a></div>
            </div>
        </div>
    </section>

    <div class="events-section latest-events">

        <div class="auto-container">
            <div class="row clearfix">
                <div class="col-lg-12">


                     <!--Projects Section-->
                    <section class="projects-section no-padd-bottom no-padd-top padd-right-20">

                        <div class="row clearfix">

                            <!--Default Featured Column-->
                            <div class="column default-featured-column col-md-6 col-sm-6 col-xs-12" v-for="project in getCat?.projects" :key="project.id">
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
            </div>
        </div>

    </div>

</template>

<script setup>
    import { onMounted, ref } from 'vue';
    import { useRoute } from 'vue-router';
    import { getSingleData } from '../../plugin/api';

    const route = useRoute();
    const getData = ref(route.params.id);
    const getCat = ref({});

    const AllProjectFunction = async ()=>{
        await getSingleData('/showcategory/'+getData.value)
            .then(response=>{
                getCat.value = response.data.category;
            })
    }

    onMounted(() => {
        AllProjectFunction();
    });

</script>

<style scoped>

.image-box{
        width: 560px;
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

    @media screen and (max-width: 991px){
        .image-box{
            width: 100%;
            height: 296.66px;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .padd-right-20{
            padding-right: 0 !important;
        }
    }

</style>