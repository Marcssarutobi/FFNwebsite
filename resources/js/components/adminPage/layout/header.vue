<template>
    <!-- Header Section starts -->
    <header class="header-main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6 col-sm-4 d-flex align-items-center header-left p-0">
                    <span class="header-toggle me-3">
                        <i class="iconoir-view-grid"></i>
                    </span>
                </div>

                <div class="col-6 col-sm-8 d-flex align-items-center justify-content-end header-right p-0">

                    <ul class="d-flex align-items-center">

                        <li class="header-dark">
                            <div class="sun-logo head-icon">
                                <i class="iconoir-sun-light"></i>
                            </div>
                            <div class="moon-logo head-icon">
                                <i class="iconoir-half-moon"></i>
                            </div>
                        </li>

                        <li class="header-notification">
                            <a aria-controls="notificationcanvasRight" class="d-block head-icon position-relative" data-bs-target="#notificationcanvasRight" data-bs-toggle="offcanvas" href="#" role="button">
                                <i class="iconoir-bell"></i>
                                <span class="position-absolute translate-middle p-1 bg-success border border-light rounded-circle animate__animated animate__fadeIn animate__infinite animate__slower"></span>
                            </a>
                            <div aria-labelledby="notificationcanvasRightLabel" class="offcanvas offcanvas-end header-notification-canvas" id="notificationcanvasRight" tabindex="-1">
                                <div class="offcanvas-header">
                                    <h5 class="offcanvas-title" id="notificationcanvasRightLabel">
                                        Notification</h5>
                                    <button aria-label="Close" class="btn-close" data-bs-dismiss="offcanvas" type="button"></button>
                                </div>
                                <div class="offcanvas-body notification-offcanvas-body app-scroll p-0">
                                    <div class="head-container notification-head-container">
                                        <div class="notification-message head-box">
                                            <div class="message-images">
                                                    <span class="bg-secondary h-35 w-35 d-flex-center b-r-10 position-relative">
                                                    <img alt="avtar" class="img-fluid b-r-10" src="/admin/assets/images/ai_avtar/6.jpg">
                                                    <span class="position-absolute bottom-30 end-0 p-1 bg-secondary border border-light rounded-circle notification-avtar"></span>
                                                    </span>
                                            </div>
                                            <div class="message-content-box flex-grow-1 ps-2">

                                                <a class="f-s-15 text-secondary mb-0" href="read_email.html" target="_blank"><span class="f-w-500 text-secondary">Gene Hart</span> wants to
                                                    edit <span class="f-w-500 text-secondary">Report.doc</span></a>
                                                <div>
                                                    <a class="d-inline-block f-w-500 text-success me-1" href="#">Approve</a>
                                                    <a class="d-inline-block f-w-500 text-danger" href="#">Deny</a>
                                                </div>
                                                <span class="badge text-light-primary mt-2"> sep 23 </span>

                                            </div>
                                            <div class="align-self-start text-end">
                                                <i class="iconoir-xmark close-btn"></i>
                                            </div>
                                        </div>
                                        <div class="notification-message head-box">
                                            <div class="message-images">
                                                <span class="bg-light-dark h-35 w-35 d-flex-center b-r-10 position-relative">
                                                    <i class="ph-duotone  ph-truck f-s-18"></i>
                                                </span>
                                            </div>
                                            <div class="message-content-box flex-grow-1 ps-2">
                                                <a class="f-s-15 text-secondary mb-0" href="read_email.html" target="_blank">Hey
                                                    <span class="f-w-500 text-secondary">Emery McKenzie</span>,
                                                    get ready: Your order from <span class="f-w-500 text-secondary">@Shopper.com</span>
                                                    is out for delivery today!</a>
                                                <span class="badge text-light-info mt-2"> sep 23 </span>

                                            </div>
                                            <div class="align-self-start text-end">
                                                <i class="iconoir-xmark close-btn"></i>
                                            </div>
                                        </div>
                                        <div class="notification-message head-box">
                                            <div class="message-images">
                                                <span class="bg-secondary h-35 w-35 d-flex-center b-r-10 position-relative">
                                                    <img alt="" class="img-fluid b-r-10" src="/admin/assets/images/ai_avtar/2.jpg">
                                                    <span class="position-absolute  end-0 p-1 bg-secondary border border-light rounded-circle notification-avtar"></span>
                                                </span>
                                            </div>
                                            <div class="message-content-box flex-grow-1 ps-2">
                                                <a class="f-s-15 text-secondary mb-0" href="read_email.html" target="_blank"><span class="f-w-500 text-secondary">Simon Young</span> shared
                                                    a file called <span class="f-w-500 text-secondary">Dropdown.pdf</span></a>
                                                <span class="badge text-light-success mt-2"> 30 min</span>

                                            </div>
                                            <div class="align-self-start text-end">
                                                <i class="iconoir-xmark close-btn"></i>
                                            </div>
                                        </div>
                                        <div class="notification-message head-box">
                                            <div class="message-images">
                                                <span class="bg-secondary h-35 w-35 d-flex-center b-r-10 position-relative">
                                                    <img alt="" class="img-fluid b-r-10" src="/admin/assets/images/ai_avtar/5.jpg">
                                                    <span class="position-absolute end-0 p-1 bg-secondary border border-light rounded-circle notification-avtar"></span>
                                                </span>
                                            </div>
                                            <div class="message-content-box flex-grow-1 ps-2">
                                                <a class="f-s-15 text-secondary mb-0" href="read_email.html" target="_blank"><span class="f-w-500 text-secondary">Becky G. Hayes</span> has
                                                    added a comment to <span class="f-w-500 text-secondary">Final_Report.pdf</span></a>
                                                <span class="badge text-light-warning mt-2"> 45 min</span>
                                            </div>
                                            <div class="align-self-start text-end">
                                                <i class="iconoir-xmark close-btn"></i>
                                            </div>
                                        </div>
                                        <div class="notification-message head-box">
                                            <div class="message-images">
                                                <span class="bg-secondary h-35 w-35 d-flex-center b-r-10 position-relative">
                                                    <img alt="" class="img-fluid b-r-10" src="/admin/assets/images/ai_avtar/1.jpg">
                                                    <span class="position-absolute  end-0 p-1 bg-secondary border border-light rounded-circle notification-avtar"></span>
                                                </span>
                                            </div>
                                            <div class="message-content-box flex-grow-1 ps-2">
                                                <a class="f-s-15 text-secondary mb-0" href="read_email.html" target="_blank"><span class="f-w-600 text-secondary">Romaine Nadeau</span>
                                                    invited you to join a meeting
                                                </a>
                                                <div>
                                                    <a class="d-inline-block f-w-500 text-success me-1" href="#">Join</a>
                                                    <a class="d-inline-block f-w-500 text-danger" href="#">Decline</a>
                                                </div>

                                                <span class="badge text-light-secondary mt-2"> 1 hour ago </span>
                                            </div>
                                            <div class="align-self-start text-end">
                                                <i class="iconoir-xmark close-btn"></i>
                                            </div>
                                        </div>

                                        <div class="hidden-massage py-4 px-3">
                                            <img alt="" class="w-50 h-50 mb-3 mt-2" src="/admin/assets/images/icons/bell.png">
                                            <div>
                                                <h6 class="mb-0">Notification Not Found</h6>
                                                <p class="text-secondary">When you have any notifications added
                                                    here,will
                                                    appear here.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </li>

                        <li class="header-profile">
                            <a aria-controls="profilecanvasRight" class="d-block head-icon" data-bs-target="#profilecanvasRight" data-bs-toggle="offcanvas" href="#" role="button">
                                <img alt="avtar" class="b-r-50 h-35 w-35 bg-dark" src="/admin/assets/images/avtar/woman.jpg">
                            </a>

                            <div aria-labelledby="profilecanvasRight" class="offcanvas offcanvas-end header-profile-canvas" id="profilecanvasRight" tabindex="-1">
                                <div class="offcanvas-body app-scroll">
                                    <ul class="">
                                        <li class="d-flex gap-3 mb-3">
                                            <div class="d-flex-center">
                                            <span class="h-45 w-45 d-flex-center b-r-10 position-relative">
                                                <img alt="" class="img-fluid b-r-10" src="/admin/assets/images/avtar/woman.jpg">
                                            </span>
                                            </div>
                                            <div class="text-center mt-2">
                                                <h6 class="mb-0"> {{currentUser.prenom}} {{ currentUser.nom }} <img alt="instagram-check-mark" class="w-20 h-20" src="/admin/assets/images/profile-app/01.png"></h6>
                                                <p class="f-s-12 mb-0 text-secondary">{{ currentUser.email }}</p>
                                            </div>
                                        </li>

                                        <li>
                                            <RouterLink class="f-w-500" to="/admins/settings" >
                                                <i class="ph ph-gear pe-1 f-s-20"></i> Settings
                                            </RouterLink>
                                        </li>
                                        <li class="app-divider-v dotted py-1"></li>
                                        <li>
                                            <a class="f-w-500" href="setting.html" target="_blank">
                                                <i class="iconoir-eye-closed pe-1 f-s-20"></i> Hide Settings
                                            </a>
                                        </li>
                                        <li>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <a class="f-w-500" href="#">
                                                    <i class="iconoir-bell-notification pe-1 f-s-20"></i>
                                                    Notification
                                                </a>
                                                <div class="flex-shrink-0">
                                                    <div class="form-check form-switch">
                                                        <input checked="" class="form-check-input form-check-primary" id="basicSwitch" type="checkbox">
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div>
                                                    <a class="f-w-500" href="#">
                                                        <i class="ph-duotone  ph-detective pe-1 f-s-20"></i>
                                                        Incognito
                                                    </a>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input form-check-primary" id="incognitoSwitch" type="checkbox">
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="app-divider-v dotted py-1"></li>
                                        <li>
                                            <a class="f-w-500" href="faq.html" target="_blank">
                                                <i class="iconoir-help-circle pe-1 f-s-20"></i> Help
                                            </a>
                                        </li>
                                        <li>
                                            <a class="f-w-500" href="pricing.html" target="_blank">
                                                <i class="iconoir-dollar pe-1 f-s-20"></i>
                                                Pricing
                                            </a>
                                        </li>
                                        <li>
                                            <a class="mb-0 text-secondary f-w-500" href="sign_up.html" target="_blank">
                                                <i class="iconoir-plus pe-1 f-s-20"></i> Add account
                                            </a>
                                        </li>
                                        <li>
                                            <button class="mb-0 btn btn-light-danger btn-sm w-100 d-flex align-items-center justify-content-center " @click="LogoutFunction" role="button">
                                                <i class="ph-duotone  ph-sign-out pe-1 f-s-20"></i> Log Out
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <!-- Header Section ends -->
</template>

<script setup>

    import { computed, onMounted, ref } from 'vue';
    import { isAuthenticated } from '../../router';
    import { RouterLink, useRouter } from 'vue-router';
    import axiosInstance from '../../plugin/axios.js';

    const currentUser = ref({})

    const router = useRouter()

    const CurrentUserFunction = async ()=>{
        currentUser.value = await isAuthenticated()
    }

    const LogoutFunction = async ()=>{
        const res = await axiosInstance.post('/logout',null,{
            headers:{
                Authorization: `Bearer ${localStorage.getItem("token")}`,
            }
        })
        if (res.status === 200) {
            localStorage.removeItem('token')
            currentUser.value = {}
            router.push('/admins/login')
        }
    }

    onMounted(()=>{
        CurrentUserFunction()
    })

</script>

<style>

</style>
