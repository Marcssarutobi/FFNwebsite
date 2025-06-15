<template>
  <main>
    <div class="container-fluid">

        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h4 class="main-title">List of projects</h4>
                <button @click="showModal" class="btn btn-primary mb-2" >
                    <i class="iconoir-plus"></i> Create new project
                </button>
            </div>
        </div>

        <div class="row m-1">

            <div class="card">

                <div class="card-body p-3">
                    <div class="table-responsive">
                        <Datatable />
                    </div>
                </div>

            </div>

        </div>

        <!--  Modal content for the Large example -->
        <div class="modal fade" id="addproject" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-xl ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel">Add Project</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-lg-12 mb-3">

                                <label for="input-file" id="drop-area">
                                    <input type="file" accept="image/*" id="input-file" hidden>
                                    <i class="fas fa-cloud-arrow-up"></i>
                                    <p>Drag and drop or click here to upload image</p>
                                    <span>Upload any images from desktop</span>
                                </label>

                            </div>

                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input v-model="data.title" :class="{ 'is-invalid': isEmpty.title }" type="text" class="form-control" id="title" placeholder="Enter title">
                                    <span v-if="isEmpty.title" class="text-danger">{{ msgInput.title }}</span>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label for="category">Category</label>
                                    <select class="form-select" :class="{ 'is-invalid': isEmpty.title }" v-model="data.category_id" id="category">
                                        <option value="">Select a category</option>
                                        <option v-for="category in allCategories" :key="category.id" :value="category.id">{{ category.name }}</option>
                                    </select>
                                    <span v-if="isEmpty.category_id" class="text-danger">{{ msgInput.category_id }}</span>
                                </div>
                            </div>

                            <div class="col-lg-12 mb-3">
                                <div class="form-group">
                                    <label for="brief_description">Brief Description</label>
                                    <textarea v-model="data.brief_description" :class="{ 'is-invalid': isEmpty.title }" row="5" style="height: 150px;" type="text" class="form-control" id="brief_description" placeholder="Enter brief description"> </textarea>
                                    <span v-if="isEmpty.brief_description" class="text-danger">{{ msgInput.brief_description }}</span>
                                </div>
                            </div>

                            <div class="col-lg-12 mb-3">
                                <div class="form-group">
                                    <label for="content">Content</label>
                                    <textarea v-model="data.content" :class="{ 'is-invalid': isEmpty.title }" row="5" id="my-editor" type="text" class="form-control" placeholder="Enter content"></textarea>
                                    <span v-if="isEmpty.content" class="text-danger">{{ msgInput.content }}</span>
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
                        <button v-else type="button" class="btn btn-primary" @click="AddProjectFunction">Save</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <!-- Toast de succès -->
        <div class="position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 1055">
            <div id="successToast" class="toast align-items-center text-white  border-0" :class="classToast" role="alert">
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

<script  setup>

    import { onMounted, ref } from 'vue';
    import Datatable from '../components/Datatable.vue';
    import {postData, getData} from '../../plugin/api'
    import {initTinyMCE,destroyTinyMCE} from '../../plugin/tinymce';
    import {isAuthenticated} from '../../router/index';

    let addmodal;
    let updatemodal;

    const data = ref({
        title:"",
        brief_description:"",
        content:"",
        image:"",
        category_id:"",
        status:"",
        user_id:"",
    })
    const isEmpty = ref({})
    const msgInput = ref({})
    const isLoader = ref(false)
    const msgToast = ref("")
    const classToast = ref("")
    const allCategories = ref([])
    const currentUser = ref({})

    const AllCategory = async ()=>{
        try {
            const response = await getData('/categories');
            if (response.status === 200) {
                allCategories.value = response.data.categories;
                console.log("Categories fetched successfully:", allCategories.value);
            }
        } catch (error) {
            console.error("Error fetching categories:", error);
        }
    }

    const inputEmpty = ()=>{
        if (data.value.title.trim() === '') {
            isEmpty.value.title = true
            msgInput.value.title = 'Ce champs est vide'
        }else{
            isEmpty.value.title = false
            msgInput.value.title = ''
        }
        if (data.value.brief_description.trim() === '') {
            isEmpty.value.brief_description = true
            msgInput.value.brief_description = 'Ce champs est vide'
        }else{
            isEmpty.value.brief_description = false
            msgInput.value.brief_description = ''
        }
        if (data.value.content.trim() === '') {
            isEmpty.value.content = true
            msgInput.value.content = 'Ce champs est vide'
        }else{
            isEmpty.value.content = false
            msgInput.value.content = ''
        }
        if (data.value.image.trim() === '') {
            isEmpty.value.image = true
            msgInput.value.image = 'Ce champs est vide'
        }else{
            isEmpty.value.image = false
            msgInput.value.image = ''
        }
        if (data.value.category_id === '') {
            isEmpty.value.category_id = true
            msgInput.value.category_id = 'Ce champs est vide'
        }else{
            isEmpty.value.category_id = false
            msgInput.value.category_id = ''
        }
        if (data.value.status === '') {
            isEmpty.value.status = true
            msgInput.value.status = 'Ce champs est vide'
        }else{
            isEmpty.value.status = false
            msgInput.value.status = ''
        }
    }

    const AddProjectFunction = async ()=>{
        inputEmpty()
        data.value.status = "draft"
        currentUser.value = await isAuthenticated()
        data.value.user_id = currentUser.value.id
        const allEmpty = Object.values(isEmpty.value).every(value => value === false)
        if (allEmpty) {
            isLoader.value = true
            postData('/addproject', data.value)
                .then(response =>{
                    if (response.status === 200) {
                        isLoader.value = false
                        data.value = {
                            title:"",
                            brief_description:"",
                            content:"",
                            image:"",
                            category_id:"",
                            status:"",
                            user_id:"",
                        }
                        msgToast.value = "Project added successfully"
                        classToast.value = "bg-success"

                        addmodal.hide()

                        // Afficher le toast
                        const toastEl = document.getElementById('successToast');
                        const toast = new bootstrap.Toast(toastEl, { delay: 1500 });
                        toast.show();
                    }
                })
                .catch(error => {
                    isLoader.value = false
                    console.error("Error adding project:", error);
                    msgToast.value = "An error occurred while adding the project."
                    classToast.value = "bg-danger"
                    const toastEl = document.getElementById('successToast');
                    const toast = new bootstrap.Toast(toastEl, { delay: 1500 });
                    toast.show();
                });
        }
    }

    const showModal = () => {
        addmodal.show()
    }

    onMounted(()=>{
        addmodal = new bootstrap.Modal(document.getElementById('addproject'))

        // Lorsque le modal est affiché, init TinyMCE
        document.getElementById('addproject').addEventListener('shown.bs.modal', () => {
            const editor = document.getElementById('my-editor');
            if (editor) {
                initTinyMCE('my-editor',{
                    height: 500,
                    setup: (editor) => {
                        editor.on('init', () => {
                            editor.setContent(data.value.content);
                        });
                        editor.on('change', () => {
                            data.value.content = editor.getContent();
                        });
                    }
                })
            }
        });

        document.getElementById('addproject').addEventListener('hidden.bs.modal', () => {
            destroyTinyMCE('my-editor');
        });

        AllCategory()
    })

</script>

<style>
    .tox-promotion{
        display: none !important;
    }
    #drop-area{
        width: 100%;
        height: 200px;
        padding: 30px;
        background-color: #fff;
        text-align: center;
        border-radius: 20px;
        border: 2px dashed #e1e1e1;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        cursor: pointer;
        gap: 10px;
    }

    #drop-area i {
        font-size: 60px;
    }
    #drop-area p {
        font-size: 25px;
    }
    #drop-area span {
        color: #a3a3a3;
        font-size: 15px;
    }

</style>
