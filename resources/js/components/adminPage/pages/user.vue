<template>
  <main>
    <div class="container-fluid">

        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h4 class="main-title">Users</h4>
                <button class="btn btn-primary mb-2" @click="showModal" >
                    <i class="iconoir-plus"></i> New User
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-3">
                        <DataTable :data="alluser" :columns="columns"  />
                    </div>
                </div>
            </div>
        </div>

        <!--  Modal content for the Large example -->
        <div class="modal fade" id="adduser" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel">Add User</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-lg-6 mb-3">
                                <div class="form-gorup">
                                    <label for="">Last Name :</label>
                                    <input type="text" :class="{ 'is-invalid': isEmpty.nom }" v-model="data.nom" class="form-control">
                                    <span v-if="isEmpty.nom" class="text-danger">{{ msgInput.nom }}</span>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <div class="form-gorup">
                                    <label for="">First Name :</label>
                                    <input type="text" :class="{ 'is-invalid': isEmpty.prenom }" v-model="data.prenom" class="form-control">
                                    <span v-if="isEmpty.prenom" class="text-danger">{{ msgInput.prenom }}</span>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <div class="form-gorup">
                                    <label for="">Email :</label>
                                    <input type="email" :class="{ 'is-invalid': isEmpty.email }" v-model="data.email" class="form-control">
                                    <span v-if="isEmpty.email" class="text-danger">{{ msgInput.email }}</span>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <div class="form-gorup">
                                    <label for="">Phone :</label>
                                    <input type="phone" :class="{ 'is-invalid': isEmpty.telephone }" v-model="data.telephone" class="form-control">
                                    <span v-if="isEmpty.telephone" class="text-danger">{{ msgInput.telephone }}</span>
                                </div>
                            </div>

                            <div class="col-lg-12 mb-3">
                                <div class="form-gorup">
                                    <label for="">Role :</label>
                                    <select class="form-select" :class="{ 'is-invalid': isEmpty.role_id }" v-model="data.role_id">
                                        <option value="">Select a role</option>
                                        <option v-for="(role,index) in allrole" :key="index" :value="role.id">{{ role.name }}</option>
                                    </select>
                                    <span v-if="isEmpty.role_id" class="text-danger">{{ msgInput.role_id }}</span>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <div class="form-gorup">
                                    <label for="">Password :</label>
                                    <input type="password" :class="{ 'is-invalid': isEmpty.password }" v-model="data.password" class="form-control">
                                    <span v-if="isEmpty.password" class="text-danger">{{ msgInput.password }}</span>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <div class="form-gorup">
                                    <label for="">Confirm password :</label>
                                    <input type="password" :class="{ 'is-invalid': isEmpty.password_confirmation }" v-model="data.password_confirmation" class="form-control">
                                    <span v-if="isEmpty.password_confirmation" class="text-danger">{{ msgInput.password_confirmation }}</span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger me-3" data-bs-dismiss="modal">Fermer</button>
                        <button disabled v-if="isLoader" class="btn btn-primary">
                        <div class="spinner-border text-light" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        </button>
                        <button v-else  type="button" class="btn btn-primary" @click="AddUserFunction">Save</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <!--  Modal content for the Large example -->
        <div class="modal fade" id="updateuser" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel">Update User</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-lg-6 mb-3">
                                <div class="form-gorup">
                                    <label for="">Last Name :</label>
                                    <input type="text" :class="{ 'is-invalid': isEmpty.nom }" v-model="getuser.nom" class="form-control">
                                    <span v-if="isEmpty.nom" class="text-danger">{{ msgInput.nom }}</span>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <div class="form-gorup">
                                    <label for="">First Name :</label>
                                    <input type="text" :class="{ 'is-invalid': isEmpty.prenom }" v-model="getuser.prenom" class="form-control">
                                    <span v-if="isEmpty.prenom" class="text-danger">{{ msgInput.prenom }}</span>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <div class="form-gorup">
                                    <label for="">Email :</label>
                                    <input type="email" :class="{ 'is-invalid': isEmpty.email }" v-model="getuser.email" class="form-control">
                                    <span v-if="isEmpty.email" class="text-danger">{{ msgInput.email }}</span>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <div class="form-gorup">
                                    <label for="">Phone :</label>
                                    <input type="phone" :class="{ 'is-invalid': isEmpty.telephone }" v-model="getuser.telephone" class="form-control">
                                    <span v-if="isEmpty.telephone" class="text-danger">{{ msgInput.telephone }}</span>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <div class="form-gorup">
                                    <label for="">Role :</label>
                                    <select class="form-select" :class="{ 'is-invalid': isEmpty.role_id }" v-model="getuser.role_id">
                                        <option value="">Select a role</option>
                                        <option v-for="(role,index) in allrole" :key="index" :value="role.id">{{ role.name }}</option>
                                    </select>
                                    <span v-if="isEmpty.role_id" class="text-danger">{{ msgInput.role_id }}</span>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <div class="form-gorup">
                                    <label for="">Status :</label>
                                    <select class="form-select" :class="{ 'is-invalid': isEmpty.is_active }" v-model="getuser.is_active">
                                        <option value="">Select a status</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                    <span v-if="isEmpty.is_active" class="text-danger">{{ msgInput.is_active }}</span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger me-3" data-bs-dismiss="modal">Fermer</button>
                        <button disabled v-if="isLoader" class="btn btn-primary">
                            <div class="spinner-border text-light" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </button>
                        <button v-else type="button" class="btn btn-primary" @click="UpdateFunction">Save change</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

    </div>
  </main>


</template>

<script setup>

    import { ref,onMounted } from 'vue';
    import axiosInstance from '../../plugin/axios.js';
    import DataTable from'../components/Datatable.vue'
    import Swal from 'sweetalert2';
    import { getData, getSingleData, postData, putData } from '../../plugin/api.js';

    let addmodal;
    let updatemodal;

    const alluser = ref([])
    const allrole = ref([])
    const getuser = ref({})
    const data = ref({
        nom: '',
        prenom: '',
        email: '',
        telephone: '',
        role_id: '',
        password: '',
        password_confirmation: ''
    })
    const isEmpty = ref({})
    const msgInput = ref({})
    const isLoader = ref(false)

    const AllCategorie = async () => {
        await getData('/roles')
            .then(response => {
                if (response.status === 200) {
                    allrole.value = response.data.roles
                }
            })
    }

    const AllUserFunction = async ()=>{
        await getData('/alluser')
                .then(response =>{
                    if (response.status === 200) {
                        alluser.value = response.data.users
                    }
                })
    }

    //table DataTable
    const columns = ref([
        {
            title: `
                <input class="form-check-input" type="checkbox" id="select-all" style="width:18px; height:18px;">
            `,
            data:null,
            orderable: false,
            searchable: false,
            render: function (data, type, row) {
                return `<input class="form-check-input row-checkbox" data-id="${row.id}" type="checkbox"  style="width:18px; height:18px;">`;
            },
            width: "40px"
        },
        {
            title: 'Full Name',
            data: null,
            render: (data, type, row) => {
                // Vérifier si l'utilisateur a une image
                let userImage = row.image
                    ? `<img class="avatar-img rounded-circle" src="${row.image}" alt="User Image">`
                    : `<div class="avatar-placeholder" style="background-color: #8C76F0; border-radius:50%; width:40px; height:40px; color:#fff; display:flex; justify-content:center; align-items:center;">
                            ${row.nom.charAt(0).toUpperCase()}${row.prenom.charAt(0).toUpperCase()}
                    </div>`;

                return `
                    <h6 class="d-flex align-items-center justify-content-start">
                        <a href="#" class="avatar avatar-md me-2">${userImage}</a>
                        <a href="#" class="d-flex flex-column">${row.nom} ${row.prenom} <span>${row.email}</span></a>
                    </h6>
                `;
            }
        },
        { title: 'Phone', data: 'telephone' },        // phone est le champ dans la réponse API
        { title: 'Role', data: 'role.name' },              // role est le champ dans la réponse API
        {
            title: 'Status',
            data: 'is_active',
            render: (data, type, row) =>{
                return row.is_active     === 1 ? `<span class="badge bg-success"> Active </span>` : `<span class="badge bg-danger"> Inactive </span>`
            }
        },
        {
          title: 'Created', data: 'created_at', render: (data, type, row) => {
            // Formater la date
            const date = new Date(row.created_at); // Assure-toi que `created_at` est au format ISO ou timestamp
            return new Intl.DateTimeFormat('fr-FR', {
              year: 'numeric',
              month: 'short',
              day: 'numeric',
              hour: '2-digit',
              minute: '2-digit',
            }).format(date); // Formater la date à la française
          }
        },  // created_at est le champ dans la réponse API
        { title: 'Actions', data: null, render: (data, type, row) => {
            // Personnalise ici l'affichage des actions si nécessaire
            return `
                <a class="btn btn-secondary" onClick="ShowUserFunction(${row.id})" ><i class="far fa-edit"></i></a>
                <a class="btn btn-danger" onClick="DeleteUserFunction(${row.id})" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="far fa-trash-alt"></i></a>
            `;
          }
        }
    ])

    const inputEmpty = () =>{
        if (data.value.nom.trim() === '') {
            isEmpty.value.nom = true
            msgInput.value.nom = 'Ce champs est vide'
        }else{
            isEmpty.value.nom = false
            msgInput.value.nom = ''
        }
        if (data.value.prenom.trim() === '') {
            isEmpty.value.prenom = true
            msgInput.value.prenom = 'Ce champs est vide'
        }else{
            isEmpty.value.prenom = false
            msgInput.value.prenom = ''
        }
        if (data.value.email.trim() === '') {
            isEmpty.value.email = true
            msgInput.value.email = 'Ce champs est vide'
        }else{
            isEmpty.value.email = false
            msgInput.value.email = ''
        }
        if (data.value.telephone.trim() === '') {
            isEmpty.value.telephone = true
            msgInput.value.telephone = 'Ce champs est vide'
        }else{
            isEmpty.value.telephone = false
            msgInput.value.telephone = ''
        }
        if (data.value.role_id === '') {
            isEmpty.value.role_id = true
            msgInput.value.role_id = 'Ce champs est vide'
        }else{
            isEmpty.value.role_id = false
            msgInput.value.role_id = ''
        }
        if (data.value.password === '') {
            isEmpty.value.password = true
            msgInput.value.password = 'Ce champs est vide'
        }else{
            isEmpty.value.password = false
            msgInput.value.password = ''
        }
        if (data.value.password_confirmation === '') {
            isEmpty.value.password_confirmation = true
            msgInput.value.password_confirmation = 'Ce champs est vide'
        }else{
            isEmpty.value.password_confirmation = false
            msgInput.value.password_confirmation = ''
        }
    }

    const AddUserFunction = async ()=>{
        inputEmpty()
        const allEmpty = Object.values(isEmpty.value).every(value => value === false)
        if (allEmpty) {
            isLoader.value = true
            await postData('/adduser',data.value)
                .then(response => {
                    if (response.status === 200) {
                        isLoader.value = false
                        data.value = {
                            nom: '',
                            prenom: '',
                            email: '',
                            telephone: '',
                            role_id: '',
                            password: '',
                            password_confirmation: ''
                        }
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "User added successfully",
                            showConfirmButton: false,
                            timer: 1500
                        })
                        addmodal.hide()
                        AllUserFunction()
                    }
                })
                .catch(error => {
                    if (error.response.status === 422){
                        isLoader.value = false
                        isEmpty.value.password_confirmation = true
                        // msgInput.value.password_confirmation = error.response.data.message
                        msgInput.value.password_confirmation = "Vous n'avez pas entré le même mot de passe"
                    }else if (error.response.status === 500) {
                        isLoader.value = false
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            icon:"error",
                            text:"L'adresse email ou le numéro de téléphone existe déjà"
                        })
                    }
                })
        }
    }

    const ShowUserFunction = async (id)=>{
        await getSingleData('/showuser/'+id)
            .then(async (response)=>{
                if (response.status === 200) {
                    updatemodal.show()
                    getuser.value = response.data.user
                }
            })
    }

    const UpdateFunction = async () =>{
        isLoader.value = true
        await putData('/updateuser/'+getuser.value.id,getuser.value)
            .then(response =>{
                if (response.status === 200) {
                    isLoader.value = false
                    getuser.value = {}
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "User updated successfully",
                        showConfirmButton: false,
                        timer: 1500
                    })
                    updatemodal.hide()
                    AllUserFunction()
                }
            })
            .catch(error =>{
                isLoader.value = false
                console.log(error)
                if (error.response.status === 422){
                    isEmpty.value.password_confirmation = true
                    msgInput.value.password_confirmation = error.response.data.message
                }else if (error.response.status === 500) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        icon:"error",
                        text:"L'adresse email ou le numéro de téléphone existe déjà"
                    })
                }
            })
    }

    const DeleteUserFunction  = async (id)=>{
        Swal.fire({
            title: "Do you want to delete this User ?",
            text: "You can't go back!",
            icon: "warning",
            showCancelButton: true,
            cancelButtonColor: "#d33",
            confirmButtonColor: "#3085d6",
            confirmButtonText: "Delete",
            cancelButtonText: "Close"
        }).then(async (result) => {
            if (result.isConfirmed) {
                const del = await axiosInstance.delete('/deleteuser/' + id, {
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('token')}`
                    }
                })
                if (del.status === 200) {
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "User deleted successfully",
                        showConfirmButton: false,
                        timer: 1500
                    })
                    AllUserFunction()
                }
            }
        })
    }

    const showModal = () =>{
        addmodal.show();
    }


    onMounted(()=>{
        addmodal = new bootstrap.Modal(document.getElementById('adduser'))
        updatemodal = new bootstrap.Modal(document.getElementById('updateuser'))
        window.ShowUserFunction = ShowUserFunction
        window.DeleteUserFunction = DeleteUserFunction
        AllUserFunction()
        AllCategorie()
    })

</script>

<style>

</style>
