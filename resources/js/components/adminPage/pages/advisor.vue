<template>
    <main>
        <div class="container-fluid">

            <div class="row mb-4">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <h4 class="main-title">List of Advisor</h4>
                    <button @click="showModal" class="btn btn-primary mb-2" >
                        <i class="iconoir-plus"></i> New Members
                    </button>
                </div>
            </div>

            <div class="row m-1">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="table">
                            <Datatable :data="teamMembers" :columns="columns" />
                        </div>
                    </div>
                </div>
            </div>

            <!--  Modal content for the Large example -->
            <div class="modal fade" id="addteam" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog  modal-lg ">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">Add Member</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form @submit.prevent="AddTeamsFunction">
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
                                            <label for="title">Full Name</label>
                                            <input v-model="data.name" :class="{ 'is-invalid': isEmpty.name }" type="text" class="form-control" id="title" placeholder="Enter full name">
                                            <span v-if="isEmpty.name" class="text-danger">{{ msgInput.name }}</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 mb-3">
                                        <div class="form-group">
                                            <label for="title">Profession</label>
                                            <input v-model="data.profession" :class="{ 'is-invalid': isEmpty.profession }" type="text" class="form-control" id="title" placeholder="Enter profession">
                                            <span v-if="isEmpty.profession" class="text-danger">{{ msgInput.profession }}</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 mb-3">
                                        <div class="form-group">
                                            <label for="">Facebook Link</label>
                                            <input v-model="data.facebook_link" :class="{ 'is-invalid': isEmpty.facebook_link }" type="text" class="form-control" @input="validateSocialLinks" placeholder="Enter Facebook link">
                                            <span v-if="isEmpty.facebook_link" class="text-danger">{{ msgInput.facebook_link }}</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 mb-3">
                                        <div class="form-group">
                                            <label for="">Twitter Link</label>
                                            <input v-model="data.twitter_link" :class="{ 'is-invalid': isEmpty.twitter_link }" type="text" @input="validateSocialLinks" class="form-control" placeholder="Enter Twitter link">
                                            <span v-if="isEmpty.twitter_link" class="text-danger">{{ msgInput.twitter_link }}</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 mb-3">
                                        <div class="form-group">
                                            <label for="">Linkedin Link</label>
                                            <input v-model="data.linkedin_link" :class="{ 'is-invalid': isEmpty.linkedin_link }" @input="validateSocialLinks" type="text" class="form-control" placeholder="Enter Linkedin link">
                                            <span v-if="isEmpty.linkedin_link" class="text-danger">{{ msgInput.linkedin_link }}</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 mb-3">
                                        <div class="form-group">
                                            <label for="">Researchgate Link</label>
                                            <input v-model="data.instagram_link" :class="{ 'is-invalid': isEmpty.instagram_link }" @input="validateSocialLinks" type="text" class="form-control" placeholder="Enter Researchgate link">
                                            <span v-if="isEmpty.instagram_link" class="text-danger">{{ msgInput.instagram_link }}</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 mb-3">
                                        <div class="form-group">
                                            <label for="">Description</label>
                                            <textarea v-model="data.brief_description" :class="{ 'is-invalid': isEmpty.brief_description }" maxlength="230" class="form-control" rows="5" id=""></textarea>
                                            <span class=" text-muted">{{ data.brief_description.length }}/ 230 </span>
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
                                <button v-else type="submit" class="btn btn-primary" >Save</button>
                            </div>
                        </form>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <!--  Modal content for the Large example -->
            <div class="modal fade" id="updateteam" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog  modal-lg ">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">Update Member</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form @submit.prevent="UpdateTeams">
                            <div class="modal-body">
                                <div class="row">

                                    <div class="col-lg-12 mb-3" @dragover.prevent="handleDragOverUpdate" @dragleave="handleDragLeaveUpdate" @drop.prevent="handleDropUpdate">

                                        <label for="input-fileUpdate" id="drop-area" :class="{ 'border border-primary': isDragging }" v-if=" getTeam.image === ''">
                                            <input type="file" accept="image/*" @change="handleFileImgUpdate" id="input-fileUpdate" hidden>
                                            <i class="fas fa-cloud-arrow-up"></i>
                                            <p>Drag and drop or click here to upload image</p>
                                            <span>Upload any images from desktop</span>
                                        </label>
                                        <div class="img-view" v-else>
                                            <div class="btns">
                                                <a @click="delImageUpdate" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                            </div>
                                            <img :src="getTeam.image" alt="">
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
                                            <label for="title">Full Name</label>
                                            <input v-model="getTeam.name" :class="{ 'is-invalid': isEmpty.name }" type="text" class="form-control" id="title" placeholder="Enter full name">
                                            <span v-if="isEmpty.name" class="text-danger">{{ msgInput.name }}</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 mb-3">
                                        <div class="form-group">
                                            <label for="title">Profession</label>
                                            <input v-model="getTeam.profession" :class="{ 'is-invalid': isEmpty.profession }" type="text" class="form-control" id="title" placeholder="Enter profession">
                                            <span v-if="isEmpty.profession" class="text-danger">{{ msgInput.profession }}</span>
                                        </div>
                                    </div>


                                    <div class="col-lg-6 mb-3">
                                        <div class="form-group">
                                            <label for="">Facebook Link</label>
                                            <input v-model="getTeam.facebook_link" :class="{ 'is-invalid': isEmpty.facebook_link }" type="text" class="form-control" @input="validateSocialLinks" placeholder="Enter Facebook link">
                                            <span v-if="isEmpty.facebook_link" class="text-danger">{{ msgInput.facebook_link }}</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 mb-3">
                                        <div class="form-group">
                                            <label for="">Twitter Link</label>
                                            <input v-model="getTeam.twitter_link" :class="{ 'is-invalid': isEmpty.twitter_link }" type="text" @input="validateSocialLinks" class="form-control" placeholder="Enter Twitter link">
                                            <span v-if="isEmpty.twitter_link" class="text-danger">{{ msgInput.twitter_link }}</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 mb-3">
                                        <div class="form-group">
                                            <label for="">Linkedin Link</label>
                                            <input v-model="getTeam.linkedin_link" :class="{ 'is-invalid': isEmpty.linkedin_link }" @input="validateSocialLinks" type="text" class="form-control" placeholder="Enter Linkedin link">
                                            <span v-if="isEmpty.linkedin_link" class="text-danger">{{ msgInput.linkedin_link }}</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 mb-3">
                                        <div class="form-group">
                                            <label for="">Instagram Link</label>
                                            <input v-model="getTeam.instagram_link" :class="{ 'is-invalid': isEmpty.instagram_link }" @input="validateSocialLinks" type="text" class="form-control" placeholder="Enter Instagram link">
                                            <span v-if="isEmpty.instagram_link" class="text-danger">{{ msgInput.instagram_link }}</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 mb-3">
                                        <div class="form-group">
                                            <label for="">Description</label>
                                            <textarea v-model="getTeam.brief_description" :class="{ 'is-invalid': isEmpty.brief_description }" maxlength="230" class="form-control" rows="5" id=""></textarea>
                                            <span class=" text-muted">{{ getTeam.brief_description?.length }}/ 230 </span>
                                            <span v-if="isEmpty.brief_description" class="text-danger">{{ msgInput.brief_description }}</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 mb-3">
                                        <div class="form-group">
                                            <label for="content">Content</label>
                                            <textarea v-model="getTeam.content" :class="{ 'is-invalid': isEmpty.title }" row="5" id="my-editorUpdate" type="text" class="form-control" placeholder="Enter content"></textarea>
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

<script setup>
import { nextTick, onMounted, ref, watchEffect } from 'vue';
import Datatable from '../components/Datatable.vue';
import {postData, getData, getSingleData, putData} from '../../plugin/api'
import {initTinyMCE,destroyTinyMCE} from '../../plugin/tinymce';
import Swal from 'sweetalert2';
import axiosInstance from '../../plugin/axios';

let addmodal;
let updatemodal;

// Exemple de variable réactive
const teamMembers = ref([])
const getTeam = ref({})
const data = ref({
    name:"",
    brief_description:"",
    profession:"",
    content:"",
    image:"",
    type:"advisors",
    facebook_link: "",
    twitter_link: "",
    linkedin_link: "",
    instagram_link: "",
})
const isEmpty = ref({})
const msgInput = ref({})
const isLoader = ref(false)

const ShowProgress = ref(false)
const ShowUploded = ref(false)
const percent = ref('')
const names = ref('')
const size = ref('')
const isDragging = ref(false);

// Exemple de fonction pour charger les membres de l'équipe
async function fetchTeamMembers() {
    await getData('/advisors')
        .then(function (res){
            if (res.status === 200) {
                teamMembers.value = res.data.advisors
            }
        })
}

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

            const res = await axiosInstance.post('/uploadimagesTeams',formData,{
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
            
        }
    }
}

const delImage = async () =>{
    const res = await axiosInstance.post('/delimagesTeams',{image: data.value.image})
    if (res.status === 200) {
        data.value.image = ""
    }
}

function validateSocialLinks() {
    const socialFields = ['facebook_link', 'twitter_link', 'linkedin_link', 'instagram_link'];

    const pattern = /^(https?:\/\/)[^\s/$.?#].[^\s]*$/i;

    socialFields.forEach((field) => {
        const value = data.value[field];

        if (!value) {
            msgInput.value[field] = "";
            isEmpty.value[field] = false;
        } else if (!pattern.test(value)) {
            msgInput.value[field] = `Please enter a valid URL for ${field.replace('_', ' ')}`;
            isEmpty.value[field] = true;
        } else {
            msgInput.value[field] = "";
            isEmpty.value[field] = false;
        }
    });
}

async function AddTeamsFunction() {
    const excludedFields = ['facebook_link', 'twitter_link', 'linkedin_link', 'instagram_link'];
    for (const field in data.value) {
        if (excludedFields.includes(field)) continue;
        isEmpty.value[field] = !data.value[field]
        msgInput.value[field] = `Please enter ${field.replace('_', ' ')}`;
    }
    const allEmpty = Object.values(isEmpty.value).every(value => value === false)
    if (allEmpty) {
        isLoader.value = true
        await postData('/addteam',data.value)
            .then(function(res){
                if (res.status === 200) {
                    isLoader.value = false
                    data.value = {
                        name:"",
                        brief_description:"",
                        content:"",
                        image:"",
                        type:"teams",
                    }
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Add performed",
                        showConfirmButton: false,
                        timer: 1500
                    })
                    fetchTeamMembers()
                    addmodal.hide();
                }
            })
    }
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
                ? `<img class="avatar-img rounded-circle" src="${row.image}" alt="User Image" style="max-width:100%; max-height:100%; width:100%; height:100%; object-fit: cover;">`
                : `<div class="avatar-placeholder" style="background-color: #8C76F0; border-radius:50%; width:40px; height:40px; color:#fff; display:flex; justify-content:center; align-items:center;">
                        ${row.name.charAt(0).toUpperCase()}
                </div>`;

            return `
                <h6 class="d-flex align-items-center justify-content-start">
                    <a href="#" class="avatar avatar-md me-2" style=" border-radius:50%; width:40px; height:40px; display:flex; justify-content:center; align-items:center; overflow:hidden;">${userImage}</a>
                    <a href="#" class="d-flex flex-column">${row.name}</a>
                </h6>
            `;
        }
    },
    {
        title:"Proffession",
        data: 'profession',
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
            <a class="btn btn-secondary" onClick="GetTeamInfo('${row.slug}')" ><i class="far fa-edit"></i></a>
            <a class="btn btn-danger" onClick="DeleteTeamsFunction('${row.slug}')" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="far fa-trash-alt"></i></a>
        `;
        }
    }
])

async function GetTeamInfo(slug){
    await getSingleData('/showteam/'+slug)
        .then(function(res){
            if (res.status === 200) {
                getTeam.value = res.data.team
                updatemodal.show()
            }
        })
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

            const res = await axiosInstance.post('/uploadimagesTeams',formData,{
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
                getTeam.value.image = res.data.image_url
            }

        } catch (error) {
            console.log(error)
            
        }
    }
}

const delImageUpdate = async () =>{
    const res = await axiosInstance.post('/deleteeventimg',{image: getTeam.value.image})
    if (res.status === 200) {
        getTeam.value.image = ""
    }
}

async function UpdateTeams(){
    try {
        isLoader.value = true
        await putData('/updateteam/'+getTeam.value.slug,getTeam.value)
            .then(function(res){
                if (res.status === 200) {
                    isLoader.value = false
                    getTeam.value = {}
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Update performed",
                        showConfirmButton: false,
                        timer: 1500
                    })
                    fetchTeamMembers()
                    updatemodal.hide()
                }
            })

    } catch (error) {
        console.log(error)
    }
}

async function DeleteTeamsFunction (slug){
    Swal.fire({
            title: "Do you want to delete this Member?",
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

                await getSingleData('/showteam/'+slug)
                    .then(async(response)=>{
                        if (response.status === 200) {
                            const team = response.data.team;
                            if (team.image) {
                                await axiosInstance.post('/delimagesTeams', { image: team.image });
                            }
                            const deleteResponse = await axiosInstance.delete('/deleteteam/'+team.slug);
                            if (deleteResponse.status === 200) {

                                Swal.fire({
                                    position: "center",
                                    icon: "success",
                                    title: "Deletion performed",
                                    showConfirmButton: false,
                                    timer: 1500
                                })

                                fetchTeamMembers()
                            }
                        }
                    })
            }
        })
}

const showModal = () => {
    addmodal.show()
}


onMounted(() => {

    addmodal = new bootstrap.Modal(document.getElementById('addteam'))

    // Lorsque le modal est affiché, init TinyMCE
    document.getElementById('addteam').addEventListener('shown.bs.modal', () => {
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

    document.getElementById('addteam').addEventListener('hidden.bs.modal', () => {
        destroyTinyMCE('my-editor');
    });

    updatemodal = new bootstrap.Modal(document.getElementById('updateteam'));

    // Lorsque le modal est affiché, init TinyMCE
    document.getElementById('updateteam').addEventListener('shown.bs.modal', () => {
        const editor = document.getElementById('my-editorUpdate');
        if (editor) {
            initTinyMCE('my-editorUpdate',{
                height: 500,
                setup: (editor) => {
                    editor.on('init', () => {
                        editor.setContent(getTeam.value.content);
                    });
                    editor.on('change', () => {
                        getTeam.value.content = editor.getContent();
                    });
                }
            })
        }
    });

    document.getElementById('updateteam').addEventListener('hidden.bs.modal', () => {
        destroyTinyMCE('my-editorUpdate');
    });

    window.GetTeamInfo = GetTeamInfo
    window.DeleteTeamsFunction = DeleteTeamsFunction

    fetchTeamMembers()

})
</script>

<style scoped>

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