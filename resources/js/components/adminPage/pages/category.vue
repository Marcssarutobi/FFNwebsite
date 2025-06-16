<template>
  <main>
    <div class="container-fluid">

        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h4 class="main-title">Category</h4>
                <button class="btn btn-primary mb-2" @click="showModal" >
                    <i class="iconoir-plus"></i> New Category
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-3">
                        <DataTable :data="allcat" :columns="columns" :DeleteAllFunction="DeleteMultipleCategory" />
                    </div>
                </div>
            </div>
        </div>


        <!--  Modal content for the Large example -->
        <div class="modal fade" id="addcat" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel">Add Category</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                        <div class="mb-3">
                            <div class="form-group">
                                <label class="block mb-1 font-semibold">Name category</label>
                                <input v-model="data.name" :class="isEmpty.name ? 'is-invalid' : ''"  type="text" class="w-full border p-2 rounded-0 form-control" required />
                                <div v-if="isEmpty.name" class="invalid-feedback">
                                    {{ msgInput.name }}
                                </div>
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
                        <button v-else type="button" class="btn btn-primary" @click="AddCategorie">Save</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <!--  Modal content for the Large example -->
        <div class="modal fade" id="updatecat" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel">Update Category</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                        <div class="mb-3">
                            <div class="form-group">
                                <label class="block mb-1 font-semibold">Name category</label>
                                <input v-model="getcat.name" :class="isEmpty.name ? 'is-invalid' : ''"  type="text" class="w-full border p-2 rounded-0 form-control" required />
                                <div v-if="isEmpty.name" class="invalid-feedback">
                                    {{ msgInput.name }}
                                </div>
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
                        <button v-else type="button" class="btn btn-primary" @click="UpdateCategoryFunction">Save change</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <!-- Toast de succès -->
        <div class="position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 1055">
            <div id="successToast" class="toast align-items-center text-white bg-success border-0" role="alert">
                <div class="d-flex">
                <div class="toast-body">
                    {{ msgToast }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        </div>

    </div>
  </main>
</template>

<script setup>

    import { ref,onMounted } from 'vue';
    import axiosInstance from '../../plugin/axios.js';
    import DataTable from'../components/Datatable.vue'
    import Swal from 'sweetalert2';

    let addmodal;
    let updatemodal;


    const data = ref({
        name: '',
    })
    const isEmpty = ref({})
    const msgInput = ref({})
    const isLoader = ref(false)
    const allcat = ref([])
    const getcat = ref({})
    const msgToast = ref("")

    const AllCategoryFunction = async ()=>{
        const res = await axiosInstance.get('/categories',{
            headers:{
                Authorization: `Bearer ${localStorage.getItem("token")}`,
            }
        })
        if (res.status === 200) {
            allcat.value = res.data.categories
        }
    }

    const columns = [
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
        { title: 'Name', data: 'name' },
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
        },
        { title: 'Actions', data: null, render: (data, type, row) => {
            // Personnalise ici l'affichage des actions si nécessaire
            return `
                <a class="btn btn-secondary" onClick="GetCategorieFunction(${row.id})" ><i class="far fa-edit"></i></a>
                <a class="btn btn-danger" onClick="DeleteCategoryFunction(${row.id})" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="far fa-trash-alt"></i></a>
            `;
          }
        }
    ]

    const inputEmpty = ()=>{
        if (data.value.name.trim() === '') {
            isEmpty.value.name = true
            msgInput.value.name = 'Ce champs est vide'
        }else{
            isEmpty.value.name = false
            msgInput.value.name = ''
        }
    }

    const AddCategorie = async ()=>{
        inputEmpty();
        const allEmpty = Object.values(isEmpty.value).every(value => value === false)
        if (allEmpty) {
            isLoader.value = true
            try {
                const res = await axiosInstance.post('/addcategory',data.value,{
                    headers:{
                        Authorization: `Bearer ${localStorage.getItem("token")}`,
                    }
                })
                if (res.status === 200) {
                    isLoader.value = false
                    data.value.name = ''
                    AllCategoryFunction()
                    addmodal.hide();
                    
                    msgToast.value = "Registration completed successfully."

                    // Afficher le toast
                    const toastEl = document.getElementById('successToast');
                    const toast = new bootstrap.Toast(toastEl, { delay: 1500 });
                    toast.show();

                }
            } catch (error) {
                console.log(error)
                isLoader.value = false
            }
        }
    }

    const GetCategorieFunction = async (id) => {
        const res = await axiosInstance.get('/category/'+id,{
            headers:{
                Authorization: `Bearer ${localStorage.getItem("token")}`,
            }
        })
        if (res.status === 200) {
            updatemodal.show()
            getcat.value = res.data.category
        }
    }

    const UpdateCategoryFunction = async ()=>{
        isLoader.value = true
        const res = await axiosInstance.put('/updatecategory/'+getcat.value.id,getcat.value,{
            headers:{
                Authorization: `Bearer ${localStorage.getItem("token")}`,
            }
        })
        if (res.status === 200) {
            isLoader.value = false
            getcat.value = {}
            updatemodal.hide()
            AllCategoryFunction()

            msgToast.value = "Change made successfully."

            // Afficher le toast
            const toastEl = document.getElementById('successToast');
            const toast = new bootstrap.Toast(toastEl, { delay: 1500 });
            toast.show();

        }
    }

    const DeleteCategoryFunction = async (id) => {
        Swal.fire({
            title: "Do you want to delete this Category?",
            text: "You can't go back!",
            icon: "warning",
            showCancelButton: true,
            cancelButtonColor: "#d33",
            confirmButtonColor: "#3085d6",
            confirmButtonText: "Delete",
            cancelButtonText: "Close"
        }).then(async (result) => {
            if (result.isConfirmed) {
                const del = await axiosInstance.delete('/deletecategory/' + id, {
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('token')}`
                    }
                })
                if (del.status === 200) {
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Deletion performed",
                        showConfirmButton: false,
                        timer: 1500
                    })
                    AllCategoryFunction()
                }
            }
        })
    }

    const showModal = () =>{
        addmodal.show();
    }

    const DeleteMultipleCategory = async (ids = []) => {
        if (ids.length === 0) return;

        Swal.fire({
            title: `Supprimer ${ids.length} catégories ?`,
            text: "Cette action est irréversible !",
            icon: "warning",
            showCancelButton: true,
            cancelButtonColor: "#d33",
            confirmButtonColor: "#3085d6",
            confirmButtonText: "Oui, supprimer !",
            cancelButtonText: "Annuler"
        }).then(async (result) => {
            if (result.isConfirmed) {
                // Affiche un loader pendant la suppression
                Swal.fire({
                    title: "Suppression en cours...",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                try {
                    for (let i = 0; i < ids.length; i++) {
                        const del = await axiosInstance.delete(`/deletecategory/${ids[i]}`, {
                            headers: {
                                'Authorization': `Bearer ${localStorage.getItem('token')}`
                            }
                        });

                        if (del.status !== 200) {
                            throw new Error(`Échec de la suppression de l'ID ${ids[i]}`);
                        }
                    }

                    Swal.fire({
                        icon: "success",
                        title: "Suppression réussie",
                        text: `${ids.length} catégories supprimées.`,
                        showConfirmButton: false,
                        timer: 2000
                    });

                    AllCategoryFunction(); // 🔄 recharge les données

                } catch (error) {
                    Swal.fire("Erreur", "Une erreur est survenue pendant la suppression.", "error");
                    console.error(error);
                }
            }
        });
    };

    onMounted(() => {
        addmodal = new bootstrap.Modal(document.getElementById('addcat'))
        updatemodal = new bootstrap.Modal(document.getElementById('updatecat'))
        window.GetCategorieFunction = GetCategorieFunction
        window.DeleteCategoryFunction = DeleteCategoryFunction
        AllCategoryFunction()
    })

</script>

<style>


</style>
