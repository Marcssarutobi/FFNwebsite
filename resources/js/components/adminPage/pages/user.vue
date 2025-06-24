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
                                    <input type="text" class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <div class="form-gorup">
                                    <label for="">First Name :</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <div class="form-gorup">
                                    <label for="">Email :</label>
                                    <input type="email" class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <div class="form-gorup">
                                    <label for="">Phone :</label>
                                    <input type="phone" class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-12 mb-3">
                                <div class="form-gorup">
                                    <label for="">Role :</label>
                                    <select class="form-select">
                                        <option value="">Select a role</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <div class="form-gorup">
                                    <label for="">Password :</label>
                                    <input type="password" class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <div class="form-gorup">
                                    <label for="">Confirm password :</label>
                                    <input type="password" class="form-control">
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger me-3" data-bs-dismiss="modal">Fermer</button>
                        <!-- <button disabled v-if="isLoader" class="btn btn-primary">
                        <div class="spinner-border text-light" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        </button> -->
                        <button  type="button" class="btn btn-primary" @click="AddCategorie">Save</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <!--  Modal content for the Large example -->
        <div class="modal fade" id="updateuser" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel">Update Category</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                        

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger me-3" data-bs-dismiss="modal">Fermer</button>
                        <!-- <button disabled v-if="isLoader" class="btn btn-primary">
                        <div class="spinner-border text-light" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        </button> -->
                        <button  type="button" class="btn btn-primary" @click="UpdateCategoryFunction">Save change</button>
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
    import { getData } from '../../plugin/api.js';

    let addmodal;
    let updatemodal;

    const alluser = ref([])

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
                <a class="btn btn-secondary" onClick="GetCategorieFunction(${row.id})" ><i class="far fa-edit"></i></a>
                <a class="btn btn-danger" onClick="DeleteCategoryFunction(${row.id})" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="far fa-trash-alt"></i></a>
            `;
          }
        }
    ])

    const showModal = () =>{
        addmodal.show();
    }

    
    onMounted(()=>{
        addmodal = new bootstrap.Modal(document.getElementById('adduser'))
        updatemodal = new bootstrap.Modal(document.getElementById('updateuser'))
        AllUserFunction()
    })

</script>

<style>

</style>