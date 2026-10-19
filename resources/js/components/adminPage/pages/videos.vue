<template>
  <main>
    <div class="container-fluid">

        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h4 class="main-title">Videos</h4>
                <button @click="showModal" class="btn btn-primary mb-2" >
                    <i class="iconoir-plus"></i> Add New Video
                </button>
            </div>
        </div>

        <div class="row" style="margin-top: 50px !important;" v-if="allVideo.length > 0">

            <div class="col-xl-4 col-md-6 mb-4" v-for="(video,index) in allVideo" :key="index">
                <div class="card h-100">
                    <div class="ratio ratio-16x9">
                        <iframe v-if="getEmbedUrl(video.video_url)" :src="getEmbedUrl(video.video_url)" allowfullscreen loading="lazy"></iframe>
                        <video v-else-if="video.video_file" :src="video.video_file" controls preload="metadata"></video>
                        <div v-else class="d-flex align-items-center justify-content-center bg-light">
                            <a :href="video.video_url" target="_blank">{{ video.video_url }}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ video.title }}</h5>
                        <p class="card-text text-muted" v-if="video.description">{{ video.description }}</p>
                    </div>
                    <div class="card-footer d-flex justify-content-end gap-2">
                        <button class="btn btn-primary" @click="showUpdateModal(video)" v-if="!video.video_file"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-danger" @click="DeleteVideo(video.id)"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            </div>

        </div>

        <div class=" d-flex align-items-center justify-content-center text-center" style="width: 100%; height: 400px;" v-else>
            <h4 class="text-muted">No Videos Found</h4>
        </div>

        <!-- Modal ajout / modification -->
        <div class="modal fade" id="addvideo" tabindex="-1" role="dialog" aria-labelledby="videoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="videoModalLabel">{{ editId ? 'Update Video' : 'Add Video' }}</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                          <div class="col-lg-12 mb-3">
                              <label class="form-label">Title</label>
                              <input type="text" class="form-control" v-model="data.title">
                          </div>

                          <div class="col-lg-12 mb-3">
                              <label class="form-label">Description</label>
                              <textarea class="form-control" rows="3" v-model="data.description"></textarea>
                          </div>

                          <div class="col-lg-12 mb-3" v-if="!editId">
                              <div class="btn-group" role="group">
                                  <button type="button" class="btn" :class="source === 'url' ? 'btn-primary' : 'btn-outline-primary'" @click="setSource('url')">YouTube / Vimeo link</button>
                                  <button type="button" class="btn" :class="source === 'file' ? 'btn-primary' : 'btn-outline-primary'" @click="setSource('file')">Upload a file</button>
                              </div>
                          </div>

                          <div class="col-lg-12 mb-3" v-if="source === 'url'">
                              <label class="form-label">Video link</label>
                              <input type="url" class="form-control" placeholder="https://www.youtube.com/watch?v=..." v-model="data.video_url">
                              <small class="text-danger" v-if="data.video_url && !getEmbedUrl(data.video_url)">Link not recognized: use a YouTube or Vimeo link.</small>
                              <div class="ratio ratio-16x9 mt-3" v-if="getEmbedUrl(data.video_url)">
                                  <iframe :src="getEmbedUrl(data.video_url)" allowfullscreen></iframe>
                              </div>
                          </div>

                          <div class="col-lg-12 mb-3" v-if="source === 'file'">
                              <div class="form d-flex align-items-center justify-content-center" v-if="!data.video_file">
                                  <label for="videofile" class="btn btn-primary btn-lg rounded-0 m-0 p-3">
                                    <i class="fas fa-upload"></i> Choose a video (MP4, WebM, MOV - 500 MB max)
                                    <input type="file" id="videofile" accept="video/mp4,video/webm,video/quicktime" hidden @change="handleFileVideo">
                                  </label>
                              </div>
                              <div v-if="uploadProgress !== null" class="progress mt-3">
                                  <div class="progress-bar" :style="{ width: uploadProgress + '%' }">{{ uploadProgress }}%</div>
                              </div>
                              <div v-if="data.video_file" class="mt-3">
                                  <div class="ratio ratio-16x9">
                                      <video :src="data.video_file" controls preload="metadata"></video>
                                  </div>
                                  <button class="btn btn-outline-danger mt-2" @click="removeUploadedFile"><i class="fas fa-trash"></i> Remove this video</button>
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
                        <button v-else type="button" class="btn btn-primary" @click="SaveVideo">Save</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

    </div>
  </main>
</template>

<script setup>
  import { onMounted, ref } from 'vue';
  import axiosInstance from '../../plugin/axios';
  import { deleteData, getData, postData, putData } from '../../plugin/api';
  import { getEmbedUrl } from '../../plugin/video';
  import Swal from 'sweetalert2';

  let addmodal;

  const emptyData = () => ({
    title: '',
    description: '',
    video_url: '',
    video_file: ''
  })

  const data = ref(emptyData())
  const source = ref('url')
  const editId = ref(null)
  const isLoader = ref(false)
  const uploadProgress = ref(null)
  const allVideo = ref([])

  const showModal = () =>{
    editId.value = null
    source.value = 'url'
    data.value = emptyData()
    addmodal.show();
  }

  const showUpdateModal = (video) =>{
    editId.value = video.id
    source.value = 'url'
    data.value = {
      title: video.title,
      description: video.description ?? '',
      video_url: video.video_url ?? '',
      video_file: ''
    }
    addmodal.show();
  }

  const setSource = async (value) =>{
    // Un fichier déjà téléversé mais non enregistré est supprimé du serveur
    if (value === 'url' && data.value.video_file) {
      await removeUploadedFile()
    }
    if (value === 'file') {
      data.value.video_url = ''
    }
    source.value = value
  }

  const AllVideoFunction = async ()=>{
    await getData('/allvideos')
          .then(response =>{
            if (response.status === 200) {
              allVideo.value = response.data.videos
            }
          })
  }

  const handleFileVideo = async (event)=>{
    const file = event.target.files[0]
    event.target.value = ''
    if (!file) return

    if (file.size > 500 * 1024 * 1024) {
      Swal.fire({ icon: "error", title: "File too large", text: "The video must not exceed 500 MB." })
      return
    }

    const formData = new FormData()
    formData.append('video', file)
    uploadProgress.value = 0

    try {
      const res = await axiosInstance.post('/uploadvideo', formData, {
          headers: {
              'Content-Type': 'multipart/form-data'
          },
          onUploadProgress: (e) => {
              if (e.total) {
                  uploadProgress.value = Math.round((e.loaded * 100) / e.total)
              }
          }
      });
      if (res.status === 200) {
          data.value.video_file = res.data.video_file
      }
    } catch (error) {
        console.log(error)
        Swal.fire({ icon: "error", title: "Upload failed", text: error.response?.data?.message ?? "Please try again." })
    } finally {
        uploadProgress.value = null
    }
  }

  const removeUploadedFile = async ()=>{
    try {
      const res = await axiosInstance.post('/deletevideofile', { video_file: data.value.video_file });
      if (res.status === 200) {
          data.value.video_file = ''
      }
    } catch (error) {
        console.log(error);
    }
  }

  const SaveVideo = async ()=>{
    if (!data.value.title.trim()) {
      Swal.fire({ icon: "warning", title: "Title is required" })
      return
    }
    if (source.value === 'url' && !getEmbedUrl(data.value.video_url)) {
      Swal.fire({ icon: "warning", title: "Please enter a valid YouTube or Vimeo link" })
      return
    }
    if (source.value === 'file' && !data.value.video_file) {
      Swal.fire({ icon: "warning", title: "Please upload a video file" })
      return
    }

    const payload = {
      title: data.value.title,
      description: data.value.description || null,
      video_url: source.value === 'url' ? data.value.video_url : null,
      video_file: source.value === 'file' ? data.value.video_file : null,
    }

    isLoader.value = true
    try {
      const res = editId.value
        ? await putData('/updatevideo/' + editId.value, payload)
        : await postData('/addvideo', payload)
      if (res.status === 200) {
          data.value = emptyData()
          Swal.fire({
                position: "center",
                icon: "success",
                title: editId.value ? "Update performed" : "Add performed",
                showConfirmButton: false,
                timer: 1500
          })
          addmodal.hide()
          AllVideoFunction()
      }
    } catch (error) {
        console.log(error)
        Swal.fire({ icon: "error", title: "Error", text: error.response?.data?.message ?? "Please try again." })
    } finally {
        isLoader.value = false
    }
  }

  const DeleteVideo = async(id)=>{

    Swal.fire({
        title: "Do you want to delete this Video?",
        text: "You can't go back!",
        icon: "warning",
        showCancelButton: true,
        cancelButtonColor: "#d33",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Delete",
        cancelButtonText: "Close"
    }).then(async (result) => {
        if (result.isConfirmed) {
            const res = await deleteData('/deletevideo/'+id)
            if (res.status === 200) {
              Swal.fire({
                  position: "center",
                  icon: "success",
                  title: "Deletion performed",
                  showConfirmButton: false,
                  timer: 1500
              })
              AllVideoFunction()
            }
        }
    })

  }

  onMounted(()=>{
    const modalEl = document.getElementById('addvideo')
    addmodal = new bootstrap.Modal(modalEl)
    // À la fermeture sans enregistrer, on supprime le fichier téléversé orphelin
    modalEl.addEventListener('hidden.bs.modal', () => {
      if (data.value.video_file) {
        removeUploadedFile()
      }
    })
    AllVideoFunction()
  })

</script>
