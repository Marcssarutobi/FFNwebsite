<template>
    <!--Page Title-->
    <section class="page-title" style="background-image:url(/assets/images/background/page-title-bg.jpg);">
    	<div class="auto-container">
        	<div class="sec-title">
                <h1>Contact <span class="normal-font">Us</span></h1>
                <div class="bread-crumb"><RouterLink to="/">Home</RouterLink>  / <a href="#" class="current">Contact Us</a></div>
            </div>
        </div>
    </section>


    <!--Default Section / Other Info-->
    <section class="default-section other-info">
    	<div class="auto-container">

        	<div class="row clearfix">

                <!--Info Column-->
                <div class="column info-column col-lg-5 col-md-6 col-sm-12 col-xs-12">
                	<article class="inner-box">
                		<h3 class="margin-bott-20">Our Address</h3>
                        <div class="text margin-bott-40">We're here for you! If you need help, advice, or just want to chat, don't hesitate to contact us.. </div>
                        <ul class="info-box">
                            <li><span class="icon flaticon-location"></span><strong>Address</strong>Parakou, Bénin</li>
                            <li><span class="icon flaticon-technology-5"></span><strong>Phone</strong> (+229) 0196975772</li>
                            <li><span class="icon flaticon-interface-1"></span><strong>Email</strong> contact@fungifornature.com</li>
                        </ul>
                    </article>
                </div>

                <!--Image Column-->
                <div class="column image-column col-lg-7 col-md-6 col-sm-12 col-xs-12">
                	<article class="inner-box">
                		<figure class="image-box"><img src="/assets/images/resource/C5.jpg" alt=""></figure>
                    </article>
                </div>

            </div>
        </div>
    </section>


    <!--Contact Section-->
    <section class="contact-section no-padd-top">
    	<div class="auto-container">

        	<div class="row clearfix">

                <!--Map Column-->
                <div class="column map-column col-lg-5 col-md-6 col-sm-12 col-xs-12">
                	<h2>Our Location on Map</h2>

                	<article class="inner-box">
                		<!--Map Container-->
                        <div class="map-container">
                            <!--Map Canvas-->
                            <div class="map-canvas"
                                data-zoom="12"
                                data-lat="-37.817085"
                                data-lng="144.955631"
                                data-type="roadmap"
                                data-hue="#ffc400"
                                data-title="Envato"
                                data-content="Melbourne VIC 3000, Australia<br><a href='mailto:info@youremail.com'>info@youremail.com</a>"
                                style="height: 380px;">
                            </div>

                        </div>
                    </article>
                </div>

                <!--Form Column-->
                <div class="column form-column col-lg-7 col-md-6 col-sm-12 col-xs-12">
                	<h2>Send Message</h2>
                	<!--COntact Form-->
                	<div class="inner-box contact-form">
                    	<form @submit.prevent="AddContact" >
                        	<div class="row clearfix">
                            	<!--Form Group-->
                                <div class="form-group col-md-6 col-xs-12">
                                	<input type="text" :class="{ 'is-invalid': isEmpty.name }" v-model="data.name" name="username" value="" placeholder="Your Name">
                                    <span v-if="isEmpty.name" class="invalid-feedback">{{ msgInput.name }}</span>
                                </div>
                                <!--Form Group-->
                                <div class="form-group col-md-6 col-xs-12">
                                	<input type="text" :class="{ 'is-invalid': isEmpty.email }" v-model="data.email" name="email" value="" placeholder="Your Email">
                                    <span v-if="isEmpty.email" class="invalid-feedback">{{ msgInput.email }}</span>
                                </div>
                                <!--Form Group-->
                                <div class="form-group col-md-12 col-xs-12">
                                	<textarea :class="{ 'is-invalid': isEmpty.message }" v-model="data.message" name="message" placeholder="Message"></textarea>
                                    <span v-if="isEmpty.message" class="invalid-feedback">{{ msgInput.message }}</span>
                                </div>

                                <!--Form Group-->
                                <div class="form-group col-md-12 col-xs-12">
                                	<div class="text-right">
                                        <button type="button" class="theme-btn btn-style-two"  v-if="isloader" >
                                            <span>Sending...</span>
                                        </button>
                                        <button v-else type="submit" class="theme-btn btn-style-two">Send</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div><!--COntact Form-->

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

<script setup>

    import { ref } from 'vue';
    import {postData} from '../../plugin/api'
    import Swal from 'sweetalert2';

    const data = ref({
        name: '',
        email: '',
        message: '',
        is_read: false,
    });
    const isEmpty = ref({})
    const msgInput = ref({})
    const isloader = ref(false)

    const inputEmpty = ()=>{
        if (data.value.name.trim() === '') {
            isEmpty.value.name = true
            msgInput.value.name = 'This field is required'
        }else{
            isEmpty.value.name = false
            msgInput.value.name = ''
        }
        if (data.value.email.trim() === '') {
            isEmpty.value.email = true
            msgInput.value.email = 'This field is required'
        }else{
            isEmpty.value.email = false
            msgInput.value.email = ''
        }
        if (data.value.message.trim() === '') {
            isEmpty.value.message = true
            msgInput.value.message = 'This field is required'
        }else{
            isEmpty.value.message = false
            msgInput.value.message = ''
        }
    }

    const AddContact = async ()=>{
        inputEmpty();
        const allEmpty = Object.values(isEmpty.value).every(value => value === false)
        if (allEmpty) {
            isloader.value = true;
            await postData('/addcontact', data.value)
                .then((response) => {
                    if (response.status === 200) {
                        isloader.value = false;
                        data.value.name = '';
                        data.value.email = '';
                        data.value.message = '';
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "Your message has been sent successfully",
                            showConfirmButton: false,
                            timer: 1500
                        })
                    } else {
                        isloader.value = false;
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "An error occurred while sending your message",
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                })
                .catch((error) => {
                    isloader.value = false;
                    console.error(error);
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "An error occurred while sending your message",
                        showConfirmButton: false,
                        timer: 1500
                    })
                });
        }
    }

</script>

<style>

</style>
