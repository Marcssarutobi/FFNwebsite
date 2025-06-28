<template >
    <div class="card">

        <div class="card-header">
            <h4 class="main-title">User Profils</h4>
        </div>

        <div class="card-body bg-white p-4">
            <div class="profile-tab profile-container">

                <form class="app-form" @submit.prevent="UpdateFunction">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Laste Name</label>
                                <input v-model="currentUser.nom" class="form-control" placeholder="Eck" type="text" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">First Name</label>
                                <input class="form-control" v-model="currentUser.prenom" placeholder="Maria" type="text" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Email address</label>
                                <input class="form-control" v-model="currentUser.email" placeholder="MariaCEck@teleworm.us" type="email" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input class="form-control" v-model="currentUser.telephone" placeholder="+2290161000000" type="tel" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="text-end">
                                <button v-if="isLoader" class="btn btn-primary" disabled> <i class="fa fa-spinner me-2 rotating" aria-hidden="true"></i>Loading</button>
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
    import { putData } from '../../plugin/api';
    import Swal from 'sweetalert2';

    const currentUser = ref({})
    const isLoader = ref(false)

    const CurrentUserFunction = async ()=>{
        currentUser.value = await isAuthenticated()
    }

    const UpdateFunction = async ()=>{
        isLoader.value = true
        await putData('/updateuser/'+currentUser.value.id,currentUser.value)
                .then(res=>{
                    if (res.status === 200) {
                        isLoader.value = false
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "Modifocation performed",
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                })
    }

    onMounted(()=>{
        CurrentUserFunction()
    })

</script>
<style scoped >

    .rotating {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0%   { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

</style>
