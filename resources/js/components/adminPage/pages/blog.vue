<template>
  <main>
    <div class="container-fluid">

        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h4 class="main-title">List of blogs</h4>
                <button @click="showModal" class="btn btn-primary mb-2" >
                    <i class="iconoir-plus"></i> Create new blog
                </button>
            </div>
        </div>

        <div class="row m-1">
            <div class="card">
                <div class="card-body p-3">
                    <div class="table">
                        <Datatable :data="allblog" :columns="columns" :DeleteAllFunction="DeleteMultipleFunction" />
                    </div>
                </div>
            </div>
        </div>

        <!--  Modal content for the Large example -->
        <div class="modal fade" id="addblog" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog  modal-xl ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel">Add Blog</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form @submit.prevent="AddBlogFunction">
                        <div class="modal-body">
                            <div class="row">

                                <div class="col-lg-12 mb-3" @dragover.prevent="handleDragOver" @dragleave="handleDragLeave" @drop.prevent="handleDrop">

                                    <label for="input-file" id="drop-area" :class="{ 'border border-primary': isDragging }" v-if=" data.image === ''">
                                        <input type="file" accept="image/*" @change="handleFileImg" id="input-file" hidden>
                                        <i class="fas fa-cloud-arrow-up"></i>
                                        <p>Drag and drop or click here to upload image</p>
                                        <span>Upload any images from desktop</span>
                                    </label>
                                    <div class="img-view" v-else>
                                        <div class="btns">
                                            <a @click="delImage" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                        </div>
                                        <img :src="data.image" alt="">
                                    </div>
                                    <div v-if="isEmpty.image" class=" text-danger">
                                        {{ msgInput.image }}
                                    </div>
                                    <div class="progress mt-3" v-if="ShowProgress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" :style="{ width: percent + '%' }" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">{{ percent }}%</div>
                                    </div>
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
                                        <select class="form-select" :class="{ 'is-invalid': isEmpty.category_id }" v-model="data.category_id" id="category">
                                            <option value="">Select a category</option>
                                            <option v-for="category in allCategories" :key="category.id" :value="category.id">{{ category.name }}</option>
                                        </select>
                                        <span v-if="isEmpty.category_id" class="text-danger">{{ msgInput.category_id }}</span>
                                    </div>
                                </div>

                                <div class="col-lg-12 mb-3">
                                    <div class="form-group">
                                        <label for="brief_description">Brief Description</label>
                                        <textarea v-model="data.brief_description" :class="{ 'is-invalid': isEmpty.brief_description }" row="5" style="height: 150px;" type="text" class="form-control" id="brief_description" placeholder="Enter brief description"> </textarea>
                                        <span v-if="isEmpty.brief_description" class="text-danger">{{ msgInput.brief_description }}</span>
                                    </div>
                                </div>

                                <div class="col-lg-12 mb-3">
                                    <div class="form-group">
                                        <label for="content">Content</label>
                                        <textarea v-model="data.content" :class="{ 'is-invalid': isEmpty.content }" row="5" id="my-editor" type="text" class="form-control" placeholder="Enter content"></textarea>
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
                            <button v-else type="submit" class="btn btn-primary" >Save</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <!--  Modal content for the Large example -->
        <div class="modal fade" id="updateblog" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog  modal-xl ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel">Update Blog</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form @submit.prevent="UpdateBlogFunction">
                        <div class="modal-body">
                            <div class="row">

                                <div class="col-lg-12 mb-3" @dragover.prevent="handleDragOverUpdate" @dragleave="handleDragLeaveUpdate" @drop.prevent="handleDropUpdate">

                                    <label for="input-fileUplode" id="drop-area" :class="{ 'border border-primary': isDragging }" v-if=" getblog.image === '' || getblog.image === null">
                                        <input type="file" accept="image/*" @change="handleFileImgUpdate" id="input-fileUplode" hidden>
                                        <i class="fas fa-cloud-arrow-up"></i>
                                        <p>Drag and drop or click here to upload image</p>
                                        <span>Upload any images from desktop</span>
                                    </label>
                                    <div class="img-view" v-else>
                                        <div class="btns">
                                            <a @click="delImageUpdate" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                        </div>
                                        <img :src="getblog.image" alt="">
                                    </div>
                                    <div v-if="isEmpty.image" class=" text-danger">
                                        {{ msgInput.image }}
                                    </div>
                                    <div class="progress mt-3" v-if="ShowProgress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" :style="{ width: percent + '%' }" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">{{ percent }}%</div>
                                    </div>
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input v-model="getblog.title" :class="{ 'is-invalid': isEmpty.title }" type="text" class="form-control" id="title" placeholder="Enter title">
                                        <span v-if="isEmpty.title" class="text-danger">{{ msgInput.title }}</span>
                                    </div>
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <div class="form-group">
                                        <label for="category">Category</label>
                                        <select class="form-select" :class="{ 'is-invalid': isEmpty.title }" v-model="getblog.category_id" id="category">
                                            <option value="">Select a category</option>
                                            <option v-for="category in allCategories" :key="category.id" :value="category.id">{{ category.name }}</option>
                                        </select>
                                        <span v-if="isEmpty.category_id" class="text-danger">{{ msgInput.category_id }}</span>
                                    </div>
                                </div>

                                <div class="col-lg-12 mb-3">
                                    <div class="form-group">
                                        <label for="brief_description">Brief Description</label>
                                        <textarea v-model="getblog.brief_description" :class="{ 'is-invalid': isEmpty.title }" row="5" style="height: 150px;" type="text" class="form-control" id="brief_description" placeholder="Enter brief description"> </textarea>
                                        <span v-if="isEmpty.brief_description" class="text-danger">{{ msgInput.brief_description }}</span>
                                    </div>
                                </div>

                                <div class="col-lg-12 mb-3">
                                    <div class="form-group">
                                        <label for="content">Content</label>
                                        <textarea v-model="getblog.content" :class="{ 'is-invalid': isEmpty.title }" row="5" id="my-Updateditor" type="text" class="form-control" placeholder="Enter content"></textarea>
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
                            <button v-else type="submit" class="btn btn-primary" >Save Change</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

    </div>
  </main>
</template>

<script  setup>

    import { nextTick, onMounted, ref } from 'vue';
    import Datatable from '../components/Datatable.vue';
    import {postData, getData, getSingleData, putData} from '../../plugin/api'
    import {initTinyMCE,destroyTinyMCE} from '../../plugin/tinymce';
    import {isAuthenticated} from '../../router/index';
    import axiosInstance from '../../plugin/axios';
    import Swal from 'sweetalert2';

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
    const allCategories = ref([])
    const currentUser = ref({})
    const allblog = ref([])
    const getblog = ref({})

    const ShowProgress = ref(false)
    const ShowUploded = ref(false)
    const percent = ref('')
    const names = ref('')
    const size = ref('')
    const isDragging = ref(false);

    const AllCategory = async ()=>{
        try {
            const response = await getData('/categories');
            if (response.status === 200) {
                allCategories.value = response.data.categories;
            }
        } catch (error) {
            console.error("Error fetching categories:", error);
        }
    }

    const AllBlogFunction = async ()=>{
        const response = await getData('/blogs');
        if (response.status === 200) {
            allblog.value = response.data.data;
        } else {
            console.error("Error fetching Blog:", response);
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
        {
            title: 'Title',
            data: 'title',
            render: (data, type, row) => {
                return `<div style="display:flex; align-items:center; justify-content: flex-start;">
                        <img src="${row.image}" alt="Project Image" style="width: 50px; height: 50px; border-radius: 50%; margin-right: 10px;">
                        <span class="fw-bold">${row.title}</span>
                    </div>`;
            }
        },
        {
            title: 'Category', data: 'category.name', render: (data, type, row) => {
                return row.category ? row.category.name : 'N/A'; // Assure-toi que `row.category` existe
            }
        },
        {
            title:'Status', data: 'status', render: (data, type, row) => {
                return `<span class="badge bg-${row.status === 'published' ? 'success' : row.status === 'draft' ? 'danger' : row.status === 'approbation' ? 'warning' : 'secondary'}">${row.status}</span>`;
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
        },
        {
            title: 'Actions',
            data: null,
            orderable: false,
            searchable: false,
            render: function (data, type, row) {
                return `
                    <div class="d-flex justify-content-center">
                        <div class="dropdown dropdown-action">
                            <a href="#" class="btn-action-icon" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" target="_blank" href="/blogpreview/${row.id}"><i class="fas fa-eye"></i> Preview</a>
                                ${row.status === 'draft' ? `
                                    <a class="dropdown-item" onClick="sendApproverMail(${row.id})"><i class="fas fa-paper-plane"></i> Send for Approval</a>
                                    <a class="dropdown-item" onClick="GetBlogFunction(${row.id})"><i class="fas fa-edit"></i> Edit</a>
                                    <button class="dropdown-item delete-project" onClick="DeleteBlogFunction(${row.id})"><i class="fas fa-trash"></i> Delete</button>
                                ` : ''}

                            </div>
                        </div>
                    </div>
                `;
            }
        }
    ];

    const handleDragOver = () => {
        isDragging.value = true;
    };

    const handleDragLeave = () => {
        isDragging.value = false;
    };

    const handleDrop = (event) => {
        isDragging.value = false;
        const droppedFiles = event.dataTransfer.files;
        if (droppedFiles.length > 0) {
            // Recrée un event simulé pour ton handleFileImg
            const simulatedEvent = { target: { files: droppedFiles } };
            handleFileImg(simulatedEvent);
        }
    };

    const handleFileImg = async (event)=>{
        const selectImg = event.target.files[0]
        if (selectImg && selectImg.type.startsWith('image/')){
            const formData = new FormData()
            formData.append('image',selectImg)

            try {

                const res = await axiosInstance.post('/uploadblogimg',formData,{
                    onUploadProgress: (ProgressEvent)=>{
                        const percentCompleted = Math.round((ProgressEvent.loaded * 100) / ProgressEvent.total)
                        percent.value = percentCompleted
                        names.value = selectImg.name

                        if (percent.value < 100) {
                            ShowProgress.value = true
                        }else if(percent.value && selectImg.name){
                            ShowProgress.value= false
                            ShowUploded.value = true
                        }

                        if (selectImg.size < 1000) {
                            size.value = selectImg.size + " o";
                        } else if (selectImg.size >= 1000 && selectImg.size < 1000000) {
                            size.value = (selectImg.size / 1000).toFixed(2) + " ko";
                        } else if (selectImg.size >= 1000000) {
                            size.value = (selectImg.size / 1000000).toFixed(2) + " Mo";
                        }

                    }
                })

                if (res.status === 200) {
                    data.value.image = res.data.image_url
                }

            } catch (error) {
                console.log(error)
                if (error.response.status === 422) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Image size must not exceed 5MB',
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!',
                        showConfirmButton: false,
                        timer: 1500
                    });

                }
            }
        }
    }

    const delImage = async () =>{
        const res = await axiosInstance.post('/deleteblogimg',{image: data.value.image})
        if (res.status === 200) {
            data.value.image = ""
        }
    }

    const CurrentUserFunction = async () => {
        currentUser.value = await isAuthenticated();
        if (currentUser.value) {
            data.value.user_id = currentUser.value.id;
        } else {
            console.error("User not authenticated");
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

    const AddBlogFunction = async ()=>{

        data.value.status = "published"
        data.value.user_id = currentUser.value.id

        inputEmpty()
        const allEmpty = Object.values(isEmpty.value).every(value => value === false)
        if (allEmpty) {
            isLoader.value = true
            postData('/addblog', data.value)
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

                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "Add performed",
                            showConfirmButton: false,
                            timer: 1500
                        })

                        addmodal.hide()

                        AllBlogFunction()
                    }
                })
                .catch(error => {
                    isLoader.value = false
                    console.error("Error adding blog:", error);

                });
        }
    }

    const GetBlogFunction = async (id) => {
        const res = await axiosInstance.get('/showblog/'+id,{
            headers:{
                Authorization: `Bearer ${localStorage.getItem("token")}`,
            }
        })
        if (res.status === 200) {
            getblog.value = res.data.data
            updatemodal.show()
        }
    }

    const handleDragOverUpdate = () => {
        isDragging.value = true;
    };

    const handleDragLeaveUpdate = () => {
        isDragging.value = false;
    };

    const handleDropUpdate = (event) => {
        isDragging.value = false;
        const droppedFiles = event.dataTransfer.files;
        if (droppedFiles.length > 0) {
            // Recrée un event simulé pour ton handleFileImg
            const simulatedEvent = { target: { files: droppedFiles } };
            handleFileImgUpdate(simulatedEvent);
        }
    };

    const handleFileImgUpdate = async (event)=>{
        const selectImg = event.target.files[0]
        if (selectImg && selectImg.type.startsWith('image/')){
            const formData = new FormData()
            formData.append('image',selectImg)

            try {

                const res = await axiosInstance.post('/uploadblogimg',formData,{
                    onUploadProgress: (ProgressEvent)=>{
                        const percentCompleted = Math.round((ProgressEvent.loaded * 100) / ProgressEvent.total)
                        percent.value = percentCompleted
                        names.value = selectImg.name

                        if (percent.value < 100) {
                            ShowProgress.value = true
                        }else if(percent.value && selectImg.name){
                            ShowProgress.value= false
                            ShowUploded.value = true
                        }

                        if (selectImg.size < 1000) {
                            size.value = selectImg.size + " o";
                        } else if (selectImg.size >= 1000 && selectImg.size < 1000000) {
                            size.value = (selectImg.size / 1000).toFixed(2) + " ko";
                        } else if (selectImg.size >= 1000000) {
                            size.value = (selectImg.size / 1000000).toFixed(2) + " Mo";
                        }

                    }
                })

                if (res.status === 200) {
                    getblog.value.image = res.data.image_url
                }

            } catch (error) {
                console.log(error)
                if (error.response.status === 422) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Image size must not exceed 5MB',
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!',
                        showConfirmButton: false,
                        timer: 1500
                    });

                }
            }
        }
    }

    const delImageUpdate = async () =>{
        const res = await axiosInstance.post('/deleteblogimg',{image: getblog.value.image})
        if (res.status === 200) {
            getblog.value.image = ""
        }
    }

    const UpdateBlogFunction = async () =>{
        isLoader.value = true
        await putData('/updateblog/'+getblog.value.id, getblog.value)
            .then(response =>{
                if (response.status === 200) {
                    isLoader.value = false
                    getblog.value = {}
                    msgToast.value = "Blog updated successfully"
                    classToast.value = "bg-success"

                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Update performed",
                        showConfirmButton: false,
                        timer: 1500
                    })

                    updatemodal.hide()
                    AllBlogFunction()
                }
            })
            .catch(error => {
                console.error("Error updating project:", error);
            });
    }

    const DeleteBlogFunction = async (id)=>{
        Swal.fire({
            title: "Do you want to delete this Blog?",
            text: "You can't go back!",
            icon: "warning",
            showCancelButton: true,
            cancelButtonColor: "#d33",
            confirmButtonColor: "#3085d6",
            confirmButtonText: "Delete",
            cancelButtonText: "Close"
        }).then(async (result) => {
            if (result.isConfirmed) {

                // Affiche un loader pendant la suppression
                Swal.fire({
                    title: "Deletion in progress...",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                await getSingleData('/showblog/'+id)
                    .then(async(response)=>{
                        if (response.status === 200) {
                            const blog = response.data.data;
                            if (blog.image) {
                                await axiosInstance.post('/deleteblogimg', { image: blog.image });
                            }
                            const deleteResponse = await axiosInstance.delete('/deleteblog/'+blog.id);
                            if (deleteResponse.status === 200) {

                                Swal.fire({
                                    position: "center",
                                    icon: "success",
                                    title: "Deletion performed",
                                    showConfirmButton: false,
                                    timer: 1500
                                })

                                AllBlogFunction()
                            }
                        }
                    })
            }
        })
    }

    const DeleteMultipleFunction = async (ids= []) =>{
        if (ids.length === 0) return;

        Swal.fire({
            title: `Delete ${ids.length} Blog ?`,
            text: "This action is irreversible!",
            icon: "warning",
            showCancelButton: true,
            cancelButtonColor: "#d33",
            confirmButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete !",
            cancelButtonText: "Cancel"
        }).then(async (result) => {
            if (result.isConfirmed) {
                // Affiche un loader pendant la suppression
                Swal.fire({
                    title: "Deletion in progress...",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                try {
                    for (let i = 0; i < ids.length; i++) {
                        const id = ids[i];
                        const response = await getSingleData('/showblog/' + id);
                        if (response.status === 200) {
                            const project = response.data.data;
                            if (project.image) {
                                await axiosInstance.post('/deleteblogimg', { image: project.image });
                            }
                            await axiosInstance.delete('/deleteblog/' + project.id);
                        }
                    }

                    Swal.fire({
                        icon: "success",
                        title: "Deletion successful",
                        text: `${ids.length} blog deleted.`,
                        showConfirmButton: false,
                        timer: 2000
                    });

                    AllBlogFunction(); // 🔄 recharge les données

                } catch (error) {
                    Swal.fire("Error", "An error occurred during deletion.", "error");
                    console.error(error);
                }
            }
        });

    }

    const sendApproverMail = async (id)=>{
        // ✅ Afficher un loader
        Swal.fire({
            title: "Please wait...",
            text: "Sending in progress...",
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        await getSingleData('/sendApprovalblog/'+id)
            .then(async (response)=>{
                if (response.status === 200) {
                    getblog.value = response.data.data

                    getblog.value.status = "approbation"

                    await putData('/updateblog/'+getblog.value.id,{
                        status: getblog.value.status
                    }).then(res=>{
                        if (res.status === 200) {
                            AllBlogFunction()
                        }
                    })

                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Email sent successfully",
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            })
            .catch(error=>{
                console.error("Error sending approval email:", error);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong while sending the email!',
                    showConfirmButton: false,
                    timer: 1500
                });
            })
    }

    const showModal = () => {
        addmodal.show()
    }

    onMounted(()=>{

        addmodal = new bootstrap.Modal(document.getElementById('addblog'))

        // Lorsque le modal est affiché, init TinyMCE
        document.getElementById('addblog').addEventListener('shown.bs.modal', () => {
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

        document.getElementById('addblog').addEventListener('hidden.bs.modal', () => {
            destroyTinyMCE('my-editor');
        });

        updatemodal = new bootstrap.Modal(document.getElementById('updateblog'))

        // Lorsque le modal de modification est affiché, init TinyMCE
        document.getElementById('updateblog').addEventListener('shown.bs.modal', () => {
            const editor = document.getElementById('my-Updateditor');
            if (editor) {
                initTinyMCE('my-Updateditor',{
                    height: 500,
                    setup: (editor) => {
                        editor.on('init', () => {
                            editor.setContent(getblog.value.content || '');
                        });
                        editor.on('change', () => {
                            getblog.value.content = editor.getContent();
                        });
                    }
                })
            }
        });

        document.getElementById('updateblog').addEventListener('hidden.bs.modal', () => {
            destroyTinyMCE('my-Updateditor');
        });

        window.GetBlogFunction = GetBlogFunction;
        window.DeleteBlogFunction = DeleteBlogFunction;
        window.sendApproverMail = sendApproverMail

        AllCategory();
        AllBlogFunction();
        CurrentUserFunction()
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
    .img-view{
        width: 400px;
        height: 250px;
        border-radius: 20px;
        overflow: hidden;
        display: flex;
        align-items: start;
        justify-content: start;
        padding: 15px;
        position: relative;
    }
    .img-view .btns{
        position: absolute;
        top: 0;
        left: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 400px;
        height: 250px;
        background: rgba(0, 0, 0, .4);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .img-view:hover .btns{
        opacity: 1;
    }
    .img-view img {
        max-width: 100%;
        max-height: 100%;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>
