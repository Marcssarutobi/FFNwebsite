<template >
    <div class="card">
        <div class="card-header">
            <h4 class="main-title">Change Password</h4>
        </div>

        <div class="card-body bg-white p-4">
            <div class="profile-tab profile-container">

                <form class="app-form" @submit.prevent="UpdatePassword">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Old password</label>
                                <input class="form-control" :class="isEmpty.current_password ? 'is-invalid' : ''" v-model="data.current_password" placeholder="********" type="password" required>
                                <div v-if="isEmpty.current_password" class="invalid-feedback">
                                    {{ msgInput.current_password }}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">New password</label>
                                <input class="form-control" :class="isEmpty.new_password ? 'is-invalid' : ''" v-model="data.new_password" placeholder="********" type="password" required>
                                <div v-if="isEmpty.new_password" class="invalid-feedback">
                                    {{ msgInput.new_password }}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Confirm new password</label>
                                <input class="form-control" :class="isEmpty.new_password_confirmation ? 'is-invalid' : ''" v-model="data.new_password_confirmation" placeholder="********" type="password" required>
                                <div v-if="isEmpty.new_password_confirmation" class="invalid-feedback">
                                    {{ msgInput.new_password_confirmation }}
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-3">
                            <div class="text-end">
                                <button disabled v-if="isLoader" class="btn btn-primary">
                                    <div class="spinner-border text-light" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </button>
                                <button v-else class="btn btn-primary" type="submit">Save change</button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>

    </div>
</template>
<script setup>
    import { onMounted, ref } from 'vue';
    import { isAuthenticated } from '../../router';
import Swal from 'sweetalert2';
import axiosInstance from '../../plugin/axios';


    const data = ref({
        current_password:"",
        new_password:"",
        new_password_confirmation:""
    })

    const currentUser = ref([])
    const isLoader = ref(false)
    const isEmpty = ref({})
    const msgInput = ref({})

    const CurrentUserFunction = async ()=>{
        currentUser.value = await isAuthenticated()
    }

    const inputEmty = ()=>{
        if (data.value.current_password.trim() === '') {
            isEmpty.value.current_password = true
            msgInput.value.current_password = 'Ce champs est vide'
        }else{
            isEmpty.value.current_password = false
            msgInput.value.current_password = ''
        }

        if (data.value.new_password.trim() === '') {
            isEmpty.value.new_password = true
            msgInput.value.new_password = 'Ce champs est vide'
        }else{
            isEmpty.value.new_password = false
            msgInput.value.new_password = ''
        }

        if (data.value.new_password_confirmation.trim() === '') {
            isEmpty.value.new_password_confirmation = true
            msgInput.value.new_password_confirmation = 'Ce champs est vide'
        }else{
            isEmpty.value.new_password_confirmation = false
            msgInput.value.new_password_confirmation = ''
        }
    }

    const UpdatePassword = async ()=>{

        inputEmty()
        const allEmpty = Object.values(isEmpty.value).every(value => value === false)
        if (allEmpty){

            try{

                isLoader.value = true
                const res = await axiosInstance.put('/updatepwd/'+currentUser.value.id,data.value,{
                    headers:{
                        Authorization: `Bearer ${localStorage.getItem("token")}`
                    }
                })

                if(res.status === 200){
                    isLoader.value = false
                    Swal.fire({
                        toast: true,
                        position: "top-end",
                        icon: "success",
                        text:"Modification Enrégistré",
                        timerProgressBar: true,
                        showConfirmButton: false,
                        timer: 3000
                    })
                    data.value = {
                        current_password:"",
                        new_password:"",
                        new_password_confirmation:""
                    }
                }

            }catch(error){
                console.log(error)
                if(error.response.status === 403){
                    isLoader.value = false
                    isEmpty.value.current_password = true
                    msgInput.value.current_password = error.response.data.error
                }
            }

        }

    }

    onMounted(()=>{
        CurrentUserFunction()
    })

</script>
<style scoped>

</style>
