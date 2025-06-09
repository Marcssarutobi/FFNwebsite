<template>
  <div class="page-wrapper">
    <headers></headers>
    <RouterView></RouterView>
    <footers></footers>
  </div>

  <!--Scroll to top-->
<div class="scroll-to-top scroll-to-target" data-target=".main-header"><span class="fa fa-long-arrow-up"></span></div>

<!--Donate Popup-->
<div class="modal fade pop-box" id="donate-popup" tabindex="-1" role="dialog" aria-labelledby="donate-popup" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        	<!--Donation Section-->
            <section class="donation-section">
                <div class="donation-form-outer">
                    <form method="post" action="contact.html">

                        <!--Form Portlet-->
                        <div class="form-portlet">
                            <h3>How Much Would you like to Donate?</h3>

                            <div class="row clearfix">
                                <div class="form-group col-lg-7 col-md-12 col-xs-12 clearfix">

                                    <div class="radio-select">
                                        <input type="radio" name="sel-amount" id="amount-1">
                                        <label for="amount-1">$10</label>
                                    </div>

                                    <div class="radio-select">
                                        <input type="radio" name="sel-amount" id="amount-2" checked>
                                        <label for="amount-2">$25</label>
                                    </div>

                                    <div class="radio-select">
                                        <input type="radio" name="sel-amount" id="amount-3">
                                        <label for="amount-3">$50</label>
                                    </div>

                                    <div class="radio-select">
                                        <input type="radio" name="sel-amount" id="amount-4">
                                        <label for="amount-4">$100</label>
                                    </div>

                                    <div class="radio-select">
                                        <input type="radio" name="sel-amount" id="amount-5">
                                        <label for="amount-5">$150</label>
                                    </div>

                                </div>

                                <div class="form-group other-amount col-lg-5 col-md-8 col-xs-12 padd-top-10">

                                    <input type="text" name="other-amount" value="" placeholder="Or Other Amount">

                                </div>

                            </div>
                        </div>

                        <br>

                        <!--Form Portlet-->
                        <div class="form-portlet">
                            <h4>Billing Information</h4>

                            <div class="row clearfix">

                                <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                    <div class="field-label">First Name <span class="required">*</span></div>
                                    <input type="text" name="name" value="" placeholder="First Name" required>
                                </div>

                                <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                    <div class="field-label">Last Name <span class="required">*</span></div>
                                    <input type="text" name="name" value="" placeholder="Last Name" required>
                                </div>

                                <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                    <div class="field-label">Email <span class="required">*</span></div>
                                    <input type="email" name="name" value="" placeholder="Email" required>
                                </div>

                                <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                    <div class="field-label">Phone <span class="required">*</span></div>
                                    <input type="text" name="name" value="" placeholder="Phone" required>
                                </div>

                                <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                    <div class="field-label">Address 1 <span class="required">*</span></div>
                                    <input type="text" name="name" value="" placeholder="Address 1" required>
                                </div>

                                <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                    <div class="field-label">Address 2 <span class="required">*</span></div>
                                    <input type="text" name="name" value="" placeholder="Address 2" required>
                                </div>

                            </div>
                        </div>

                        <br>

                        <!--Form Portlet-->
                        <div class="form-portlet">
                            <h4>Payment Information</h4>

                            <div class="payment-option-logo"><img class="img-responsive" src="/assets/images/resource/payment-logos.png" alt=""></div>
                            <br>

                            <div class="row clearfix">

                                <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                    <div class="field-label">Card Number <span class="required">*</span></div>
                                    <input type="text" name="name" value="" placeholder="Card Number" required>
                                </div>

                                <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                    <div class="field-label">Card Holder Name <span class="required">*</span></div>
                                    <input type="text" name="name" value="" placeholder="Card Holder Name" required>
                                </div>



                                <div class="form-group col-lg-3 col-md-3 col-xs-12">
                                    <div class="field-label">Expire Date <span class="required">*</span></div>
                                    <select>
                                        <option>01</option>
                                        <option>02</option>
                                        <option>03</option>
                                        <option>04</option>
                                        <option>05</option>
                                        <option>06</option>
                                        <option>07</option>
                                        <option>08</option>
                                        <option>09</option>
                                        <option>10</option>
                                        <option>11</option>
                                        <option>12</option>
                                    </select>
                                </div>

                                <div class="form-group col-lg-3 col-md-3 col-xs-12">
                                    <div class="field-label">&nbsp;</div>
                                    <select>
                                        <option>2016</option>
                                        <option>2017</option>
                                        <option>2018</option>
                                        <option>2019</option>
                                        <option>2020</option>
                                    </select>
                                </div>

                                <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                    <div class="field-label">Security Code (CVC) <span class="required">*</span></div>
                                    <input type="text" name="name" value="" placeholder="Security Code" required>
                                </div>

                            </div>
                        </div>

                        <div class="text-left"><button type="submit" class="theme-btn btn-style-two">Donate Now</button></div>

                    </form>
                </div>
            </section>
        </div>
    <!-- /.modal-content -->
    </div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

</template>

<script setup>

    import {themeInit} from '../plugin/themeInit'
    import { useRoute } from "vue-router";
    import { onMounted, watch, ref, nextTick } from 'vue';
    import { RouterView } from 'vue-router';
    import headers from './layout/header.vue';
    import footers from './layout/footer.vue';

    const route = useRoute();

    onMounted(()=>{
        setTimeout(() => {
            themeInit();
        }, 0);
    })

    watch(route, async () => {
        await nextTick(); // attendre que le DOM se mette à jour
        themeInit();
    });

</script>

<style>

</style>
