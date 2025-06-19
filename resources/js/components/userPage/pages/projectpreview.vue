<template>

    <!--Page Title-->
    <section class="page-title" style="background-image:url(/assets/images/background/page-title-bg.jpg);">
    	<div class="auto-container">
        	<div class="sec-title">
                <h1>SIngle <span class="normal-font">Project</span></h1>
                <div class="bread-crumb"><RouterLink to="/">Home</RouterLink> / <RouterLink to="/project">Projects</RouterLink> / <a href="#" class="current">Single Project</a></div>
            </div>
        </div>
    </section>

    <!--Sidebar Page-->
    <div class="sidebar-page">
    	<div class="auto-container">
        	<div class="row clearfix">

                <!--Content Side-->
                <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">

                    <div class="btns mb-3" style="margin-bottom: 1.5rem !important;" v-if="projectData.status === 'approbation'">
                        <button @click="ApprovedProject" class="btn btn-success p-3 btn-lg me-3" style="margin-right: 1rem !important; font-size: 18px;">Approved</button>
                        <button class="btn btn-danger p-3 btn-lg " style="font-size: 18px;" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Declined</button>

                        <div class="collapse mt-3" id="collapseExample">
                            <div class="card card-body">
                                <form @submit.prevent="DeclenedProject">
                                    <div class="form-group">
                                        <label for="declineReason">Reason for Decline</label>
                                        <textarea id="declineReason" :class="{ 'is-invalid': isEmpty.reasonForDecline }" v-model="reasonForDecline" class="form-control" placeholder="Enter reason for decline" rows="5" style="font-size: 18px;"></textarea>
                                        <span v-if="isEmpty.reasonForDecline" class="text-danger">{{ msgInput.reasonForDecline }}</span>
                                    </div>
                                    <button class="btn btn-dark mt-3 p-4" style="font-size: 18px; width: 100px;">Submit</button>
                                </form>

                            </div>
                        </div>


                    </div>

                    <!--Projects Section-->
                    <section class="projects-section project-details no-padd-bottom no-padd-top padd-right-20">

                        <div class="column default-featured-column">
                            <article class="inner-box">
                                <figure class="image-box" >
                                    <img :src="projectData.image" alt="">
                                </figure>
                                <div class="content-box padd-top-40">
                                    <div class="row detail-header clearfix">
                                        <div class="col-md-12 col-sm-12">
                                            <h2>{{ projectData.title }}</h2>
                                        </div>

                                    </div>
                                    <div class="text" style="text-align: justify !important;" v-html="projectData.content"></div>
                                </div>
                            </article>
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

                    </aside>


                </div>
                <!--Sidebar-->


            </div>
        </div>
    </div>

</template>

<script setup>
    import { onMounted, ref } from 'vue';
    import { RouterLink, useRoute } from 'vue-router';
    import { getSingleData, postData, putData } from '../../plugin/api';
    import Swal from 'sweetalert2';
    import {themeInit} from '../../plugin/themeInit'

    const route = useRoute();
    const getID = ref(route.params.id)
    const projectData = ref({});
    const reasonForDecline = ref('');
    const isEmpty = ref({})
    const msgInput = ref({})

    const GetProject = async ()=>{
        await getSingleData('/showproject/' + getID.value)
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
    }

    const ApprovedProject = async ()=>{
        projectData.value.status = "published";
        await putData('/updateproject/'+projectData.value.id,{
            status: projectData.value.status
        }).then((response) => {
            if (response.status === 200) {
                GetProject();
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Project approved successfully",
                    showConfirmButton: false,
                    timer: 1500
                })
            }
        }).catch((error) => {
            console.error('Error approving project:', error);
        });
    }

    const inputEmpty = ()=>{
        if (reasonForDecline.value === '') {
            isEmpty.value.reasonForDecline = true;
            msgInput.value.reasonForDecline = "Please enter a reason for decline";
        } else {
            isEmpty.value.reasonForDecline = false;
            msgInput.value.reasonForDecline = "";
        }
    }

    const DeclenedProject = async ()=>{

        inputEmpty();

        const allEmpty = Object.values(isEmpty.value).every(value => value === false)

        if (allEmpty) {

            // ✅ Afficher un loader
            Swal.fire({
                title: "Please wait...",
                text: "Sending in progress...",
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            await postData('/sendDeclenedproject/'+projectData.value.id,{
                reason: reasonForDecline.value
            }).then(async (response)=>{
                if (response.status === 200) {
                    projectData.value.status = "draft";
                    await putData('/updateproject/'+projectData.value.id,{
                        status: projectData.value.status
                    }).then((response) => {
                        if (response.status === 200) {
                            GetProject();
                            Swal.fire({
                                position: "center",
                                icon: "success",
                                title: "Project declined successfully",
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    }).catch((error) => {
                        console.error('Error updating project status:', error);
                    });
                }
            }).catch((error)=>{
                console.error('Error sending declined project:', error);
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "Error sending declined project",
                    showConfirmButton: true,
                })
            })

        }


    }

    onMounted(()=>{
        GetProject();
    })

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
    max-width: 100%;
    max-height: 100%;
    width: 100%;
    height: 100%;
    object-fit: cover;
}
</style>
