<template>
    <!--Page Title-->
    <section class="page-title" style="background-image:url(/assets/images/background/imagesMenu.jpeg);">
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
                            <iframe class="ffn-map" title="Fungi For Nature – Parakou, Benin" src="https://www.google.com/maps/embed?origin=mfe&pb=!1m3!2m1!1sParakou,+B%C3%A9nin!6i13" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>

                        </div>
                    </article>
                </div>

                <!--Form Column-->
                <div class="column form-column col-lg-7 col-md-6 col-sm-12 col-xs-12">
                	<h2>Send Message</h2>
                	<!--COntact Form-->
                	<div class="inner-box contact-form">
                    	<!-- Confirmation qui reste affichée après l'envoi -->
                        <div class="ffn-form-success" v-if="sent" role="status">
                            <span class="fa-solid fa-circle-check"></span>
                            <div>
                                <strong>Thank you, your message has been sent.</strong>
                                <p>We have also sent a confirmation to your email address. Our team will get back to you as soon as possible.</p>
                                <button type="button" class="ffn-link-btn" @click="sent = false">Send another message</button>
                            </div>
                        </div>

                    	<form v-else @submit.prevent="AddContact" novalidate>
                        	<div class="row clearfix">
                            	<!--Form Group-->
                                <div class="form-group col-md-6 col-xs-12">
                                    <label class="ffn-label" for="contact-name">Your name</label>
                                	<input id="contact-name" type="text" autocomplete="name" maxlength="100" :class="{ 'is-invalid': errors.name }" :aria-invalid="!!errors.name" aria-describedby="contact-name-error" v-model="data.name" placeholder="e.g. Jane Doe">
                                    <span v-if="errors.name" id="contact-name-error" class="ffn-field-error">{{ errors.name }}</span>
                                </div>
                                <!--Form Group-->
                                <div class="form-group col-md-6 col-xs-12">
                                    <label class="ffn-label" for="contact-email">Your email</label>
                                	<input id="contact-email" type="email" autocomplete="email" maxlength="255" :class="{ 'is-invalid': errors.email }" :aria-invalid="!!errors.email" aria-describedby="contact-email-error" v-model="data.email" placeholder="you@example.com">
                                    <span v-if="errors.email" id="contact-email-error" class="ffn-field-error">{{ errors.email }}</span>
                                </div>
                                <!--Form Group-->
                                <div class="form-group col-md-12 col-xs-12">
                                    <label class="ffn-label" for="contact-message">Message</label>
                                	<textarea id="contact-message" maxlength="5000" :class="{ 'is-invalid': errors.message }" :aria-invalid="!!errors.message" aria-describedby="contact-message-error" v-model="data.message" placeholder="How can we help you?"></textarea>
                                    <span v-if="errors.message" id="contact-message-error" class="ffn-field-error">{{ errors.message }}</span>
                                </div>

                                <!-- Champ piège pour les robots (invisible pour les visiteurs) -->
                                <div class="ffn-hp" aria-hidden="true">
                                    <label for="contact-website">Website</label>
                                    <input id="contact-website" type="text" tabindex="-1" autocomplete="off" v-model="data.website">
                                </div>

                                <!--Form Group-->
                                <div class="form-group col-md-12 col-xs-12">
                                    <p class="ffn-form-error" v-if="serverError" role="alert">{{ serverError }}</p>
                                	<div class="text-right">
                                        <button type="submit" class="theme-btn btn-style-two" :disabled="isloader">
                                            {{ isloader ? 'Sending…' : 'Send message' }}
                                        </button>
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
</template>

<script setup>

    import { ref } from 'vue';
    import {postData} from '../../plugin/api'

    const emptyForm = () => ({ name: '', email: '', message: '', website: '' })

    const data = ref(emptyForm());
    const errors = ref({})
    const serverError = ref('')
    const isloader = ref(false)
    const sent = ref(false)

    const validate = () => {
        const e = {}
        if (!data.value.name.trim()) e.name = 'Please enter your name.'
        if (!data.value.email.trim()) e.email = 'Please enter your email address.'
        else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(data.value.email.trim())) e.email = 'Please enter a valid email address.'
        if (!data.value.message.trim()) e.message = 'Please write your message.'
        else if (data.value.message.trim().length < 10) e.message = 'Your message is a bit short (10 characters minimum).'
        errors.value = e
        return Object.keys(e).length === 0
    }

    const AddContact = async ()=>{
        serverError.value = ''
        if (!validate()) return

        isloader.value = true;
        try {
            const response = await postData('/addcontact', data.value)
            if (response.status === 200) {
                data.value = emptyForm()
                errors.value = {}
                sent.value = true
            }
        } catch (error) {
            const status = error.response?.status
            if (status === 422) {
                // Erreurs renvoyées par le serveur, affichées sous chaque champ
                const fieldErrors = error.response.data.errors || {}
                errors.value = Object.fromEntries(Object.entries(fieldErrors).map(([field, messages]) => [field, messages[0]]))
            } else if (status === 429) {
                serverError.value = 'Too many messages in a short time. Please wait a minute and try again.'
            } else {
                serverError.value = 'Your message could not be sent. Please try again, or write to us at contact@fungifornature.com.'
            }
        } finally {
            isloader.value = false
        }
    }

</script>

<style scoped>
    .ffn-label{
        display: block;
        margin-bottom: 6px;
        font-size: 13px;
        font-weight: 700;
        color: #333;
    }
    .ffn-field-error{
        display: block;
        margin-top: 6px;
        font-size: 13px;
        color: #c0392b;
    }
    .is-invalid{
        border-color: #c0392b !important;
    }
    .ffn-form-error{
        padding: 12px 16px;
        border-radius: 6px;
        background: #fdecea;
        color: #8a1f17;
        font-size: 14px;
    }
    .ffn-hp{
        position: absolute;
        left: -10000px;
        width: 1px;
        height: 1px;
        overflow: hidden;
    }
    .ffn-form-success{
        display: flex;
        gap: 16px;
        padding: 24px;
        border-radius: 8px;
        background: #eef7ec;
        border: 1px solid #cfe7ca;
    }
    .ffn-form-success > .fa-solid{
        font-size: 28px;
        color: #179607;
        margin-top: 2px;
    }
    .ffn-form-success p{
        margin: 6px 0 12px;
    }
    .ffn-link-btn{
        border: 0;
        background: none;
        padding: 0;
        color: #179607;
        font-weight: 700;
        text-decoration: underline;
        cursor: pointer;
    }
    button[disabled]{
        opacity: .7;
        cursor: wait;
    }
</style>

