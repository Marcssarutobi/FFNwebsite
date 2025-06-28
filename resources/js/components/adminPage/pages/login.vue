<template>
  <div class="sign-in-bg py-4">

    <div class="app-wrapper d-block">
    <div class="main-container">
        <!-- Body main section starts -->
        <div class="container">
            <div class="row sign-in-content-bg">
                <div class="col-lg-6 image-contentbox d-none d-lg-block">
                    <div class="form-container ">
                        <div class="signup-content mt-4">
                <span>
                  <img alt="" class="img-fluid " src="/assets/images/logo.png">
                </span>
                        </div>

                        <div class="signup-bg-img">
                            <img alt="" class="img-fluid" src="/admin/assets/images/login/01.png">
                        </div>
                    </div>

                </div>
                <div class="col-lg-6 form-contentbox">
                    <div class="form-container">
                        <form class="app-form rounded-control">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-5 text-center text-lg-start">
                                        <h2 class="text-primary-dark f-w-600">Welcome Back </h2>
                                        <p>Log in to access the admin page</p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="username">Email</label>
                                        <input class="form-control" :class="isEmpty.email ? 'is-invalid border border-danger' : ''" v-model="dataLogin.email" placeholder="Enter Your addresse email" type="email">
                                        <div v-if="isEmpty.email" class="invalid-feedback">
                                            {{ msgInput.email }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="password">Password</label>
                                        <a class="link-primary-dark float-end" href="password_reset.html">Forgot Password
                                            ?</a>
                                        <input class="form-control" :class="isEmpty.password ? 'is-invalid border border-danger' : ''" v-model="dataLogin.password" id="password" placeholder="Enter Your Password" type="password">
                                        <div v-if="isEmpty.password" class="invalid-feedback">
                                            {{ msgInput.password }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <button disabled v-if="isLoader" class="btn btn-light-primary w-100">
                                            <div class="spinner-border text-light" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </button>
                                        <button v-else class="btn btn-light-primary w-100" @click="LoginForm" type="submit">Login</button>

                                    </div>
                                </div>


                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Body main section ends -->
    </div>
</div>

  </div>
</template>

<script setup>

    import { ref } from 'vue';
    import { RouterLink, useRouter } from 'vue-router';
    import axiosInstance from '../../plugin/axios.js';

    const dataLogin = ref({
        email:'',
        password:''
    })

    const isEmpty = ref({})
    const msgInput = ref({})
    const isLoader = ref(false)

    const router = useRouter()

    const inputIsEmpty = ()=>{
        if (dataLogin.value.email.trim() === "") {
            isEmpty.value.email = true
            msgInput.value.email = "Veuillez saisie l'adresse email"
        }else{
            isEmpty.value.email = false
            msgInput.value.email = ""
        }
        if (dataLogin.value.password.trim() === "") {
            isEmpty.value.password = true
            msgInput.value.password = "Veuillez saisie votre mot de passe"
        }else{
            isEmpty.value.password = false
            msgInput.value.password = ""
        }
    }

    const LoginForm = async ()=>{
        inputIsEmpty()
        const allEmpty = Object.values(isEmpty.value).every(value => value === false)
        if (allEmpty) {
            try {

                isLoader.value = true
                const res = await axiosInstance.post('/login', dataLogin.value)
                if (res.status === 200) {

                    // if (res.data.user.status === 0) {
                    //     errorMsg.value = true
                    // }else{
                    //     errorMsg.value = false
                    // }

                    localStorage.setItem('token', res.data.token)

                    isLoader.value = false

                    // Rediriger vers la route sauvegardée ou par défaut
                    const redirectUrl = localStorage.getItem('redirectAfterLogin');
                    if (redirectUrl) {
                        // Forcer une redirection complète du navigateur
                        window.location.href = redirectUrl;
                        localStorage.removeItem('redirectAfterLogin');
                    } else {
                        //router.push('/');
                        window.location.href = "/admins"
                    }

                    //router.push('/admins')
                }

            } catch (error) {
                if (error.response) {
                    if (error.response.status === 401) {
                        isLoader.value = false
                        isEmpty.value.email = true
                        isEmpty.value.password = true
                        msgInput.value.email = error.response.data.message
                        msgInput.value.password = error.response.data.message
                    } else {
                        console.error("Erreur du serveur :", error.response.data.message || "Veuillez réessayer plus tard.");
                    }
                }
            }
        }
    }



</script>

<style>

</style>
