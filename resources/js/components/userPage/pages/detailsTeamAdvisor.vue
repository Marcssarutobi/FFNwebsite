<template>
    
    <!--Page Title-->
    <section class="page-title" style="background-image:url(/assets/images/background/imagesMenu.jpeg);">
        <div class="auto-container">
            <div class="sec-title">
                <h1>{{ member?.name || 'Team member' }}</h1>
                <div class="bread-crumb"><RouterLink to="/">Home</RouterLink> / <RouterLink :to="member?.type === 'advisors' ? '/advisor' : '/team'">{{ member?.type === 'advisors' ? 'Advisors' : 'Team' }}</RouterLink> / <span class="current">{{ member?.name }}</span></div>
            </div>
        </div>
    </section>

    <section class="team-section">
        <div class="auto-container">
            <div class="row clearfix">

                <!--Column-->
                <article class="column team-member col-lg-3 col-md-3 col-sm-6 col-xs-12 wow fadeInUp" data-wow-delay="0ms" data-wow-duration="1500ms">
                    <div class="inner-box">
                        <figure class="image"><img :src="member?.image" :alt="member?.name"></figure>
                        <div class="member-info" style="margin-bottom: 15px !important;">
                            <h3>{{ member?.name }}</h3>
                            <div class="designation">{{ member?.profession }}</div>
                        </div>
                        <div class="content">
                            <!-- <div class="text">
                                <p>
                                    {{ member?.brief_description }}
                                </p>
                            </div> -->
                            <div class="social-links">
                                <a v-if="hasLink(member?.facebook_link)" :href="member?.facebook_link" target="_blank" rel="noopener noreferrer"><span class="fa-brands fa-facebook-f"></span></a>
                                <a v-if="hasLink(member?.twitter_link)" :href="member?.twitter_link" target="_blank" rel="noopener noreferrer"><span class="fa-brands fa-x-twitter"></span></a>
                                <a v-if="hasLink(member?.instagram_link)" :href="member?.instagram_link" target="_blank" rel="noopener noreferrer"><span class="fab fa-researchgate"></span></a>
                                <a v-if="hasLink(member?.linkedin_link)" :href="member?.linkedin_link" target="_blank" rel="noopener noreferrer"><span class="fa-brands fa-linkedin"></span></a>
                            </div>
                        </div>
                    </div>
                </article>

                <div class="col-lg-9 col-md-9">

                    <div class="title mb-3" style="margin-bottom: 15px !important;">
                        <h1 class="mb-3">Biography</h1>
                    </div>

                    <div class="contentesD ffn-richtext" v-html="member?.content">

                    </div>

                </div>

            </div>
        </div>
    </section>



</template>

<script setup>

import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import { getSingleData } from '../../plugin/api';

const route = useRoute();
const member = ref(null);

// Lien social affiché seulement s'il est renseigné (la condition précédente était toujours vraie)
const hasLink = (u) => typeof u === 'string' && u.trim() !== '' && u.trim() !== '#' && u.trim() !== 'null';

async function GetDetailsUser() {
    await getSingleData('/showteam/'+route.params.slug)
        .then(response => {
            member.value = response.data.team;
        })
        .catch(error => {
            console.error('Error fetching member details:', error);
        });
}

onMounted(() => {
    GetDetailsUser();
});

</script>

<style >

.image a{
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    width: 270px !important;
    height: 347px !important;
    overflow: hidden !important;
}
.image a img{
    max-width: 100% !important;
    max-height: 100% !important;
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
}

.content .text p {
    width: 270px !important;
    height: 135px !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
    display: -webkit-box !important;
    -webkit-line-clamp: 5 !important;
    -webkit-box-orient: vertical !important;
}

.contentesD p {
    font-size: 15px !important;
    font-family: 'Roboto', sans-serif !important;
}
</style>