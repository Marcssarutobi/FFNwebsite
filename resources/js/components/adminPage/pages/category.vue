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

        <!-- Toast de succès -->
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 1055">
            <div id="successToast" class="toast align-items-center text-white bg-success border-0" role="alert">
                <div class="d-flex">
                <div class="toast-body">
                    Enregistrement effectué avec succès.
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

    let addmodal;
    let updatemodal;


    const data = ref({
        name: '',
    })
    const isEmpty = ref({})
    const msgInput = ref({})
    const isLoader = ref(false)
    const modelItems = ref([])

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
                    addmodal.hide();

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

    const showModal = () =>{
        addmodal.show();
    }

    onMounted(() => {
        addmodal = new bootstrap.Modal(document.getElementById('addcat'))
    })

</script>

<style>

</style>
