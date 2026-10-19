<template>
  <main>
    <div class="container-fluid">

        <div class="row mb-4">
            <div class="col-12 d-flex flex-wrap justify-content-between align-items-end gap-2">
                <div>
                    <h4 class="main-title mb-1">Partners</h4>
                    <p class="text-muted mb-0">Logos shown in the « Our Partners &amp; Supporters » section of the website, in this order.</p>
                </div>
                <button class="btn btn-primary" @click="showModal()"><i class="iconoir-plus"></i> Add partner</button>
            </div>
        </div>

        <div class="text-center py-5" v-if="isLoading">
            <div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
        </div>

        <div class="row" v-else-if="partners.length">
            <div class="col-xxl-3 col-xl-4 col-md-6 mb-4" v-for="(partner, index) in partners" :key="partner.id">
                <div class="card h-100">
                    <div class="logo-box">
                        <img :src="partner.logo" :alt="partner.name">
                    </div>
                    <div class="card-body">
                        <h6 class="mb-1">{{ partner.name }}</h6>
                        <a v-if="partner.url" :href="partner.url" target="_blank" rel="noopener" class="small text-truncate d-block">{{ partner.url }}</a>
                        <span v-else class="small text-muted">No link</span>
                    </div>
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                            <button class="btn btn-sm btn-outline-secondary" :disabled="index === 0 || isMoving" @click="move(index, -1)" title="Move left" aria-label="Move left"><i class="fas fa-arrow-left"></i></button>
                            <button class="btn btn-sm btn-outline-secondary" :disabled="index === partners.length - 1 || isMoving" @click="move(index, 1)" title="Move right" aria-label="Move right"><i class="fas fa-arrow-right"></i></button>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-primary" @click="showModal(partner)" title="Edit" aria-label="Edit"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-danger" @click="remove(partner)" title="Delete" aria-label="Delete"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center text-muted py-5" v-else>
            <p>No partners yet. The section is hidden on the website until you add one.</p>
        </div>

        <!-- Modal ajout / modification -->
        <div class="modal fade" id="partnermodal" tabindex="-1" aria-labelledby="partnerModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="partnerModalLabel">{{ form.id ? 'Edit partner' : 'Add partner' }}</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Logo</label>
                            <div class="logo-box logo-box-edit mb-2" v-if="form.logo"><img :src="form.logo" alt=""></div>
                            <div v-if="isUploading" class="spinner-border spinner-border-sm text-primary" role="status"></div>
                            <label v-else class="btn btn-outline-primary m-0">
                                <i class="fas fa-upload"></i> {{ form.logo ? 'Change logo' : 'Choose a logo' }}
                                <input type="file" accept="image/jpeg,image/png,image/webp" hidden @change="uploadLogo">
                            </label>
                            <div class="form-text">PNG with a transparent background works best. Wide logos (about 3:1) fit the cards nicely.</div>
                            <div class="text-danger small mt-1" v-if="errors.logo">{{ errors.logo }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="p-name">Name</label>
                            <input id="p-name" type="text" class="form-control" :class="{ 'is-invalid': errors.name }" v-model="form.name" placeholder="e.g. Université de Parakou">
                            <div class="invalid-feedback">{{ errors.name }}</div>
                        </div>
                        <div class="mb-0">
                            <label class="form-label" for="p-url">Website (optional)</label>
                            <input id="p-url" type="url" class="form-control" :class="{ 'is-invalid': errors.url }" v-model="form.url" placeholder="https://…">
                            <div class="invalid-feedback">{{ errors.url }}</div>
                            <div class="form-text">If filled in, the logo becomes a link to this site.</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger me-3" data-bs-dismiss="modal">Fermer</button>
                        <button type="button" class="btn btn-primary" :disabled="isSaving || isUploading" @click="save">
                            <span v-if="isSaving" class="spinner-border spinner-border-sm me-1" role="status"></span> Save
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
  </main>
</template>

<script setup>
  import { onMounted, ref } from 'vue';
  import axiosInstance from '../../plugin/axios';
  import { deleteData, getData, postData, putData } from '../../plugin/api';
  import Swal from 'sweetalert2';

  let modal;
  const partners = ref([])
  const form = ref({})
  const errors = ref({})
  const isLoading = ref(true)
  const isSaving = ref(false)
  const isUploading = ref(false)
  const isMoving = ref(false)

  const load = async () => {
    try {
      const res = await getData('/partners')
      partners.value = res.data.partners
    } finally {
      isLoading.value = false
    }
  }

  const showModal = (partner = null) => {
    form.value = partner ? { id: partner.id, name: partner.name, logo: partner.logo, url: partner.url ?? '' } : { name: '', logo: '', url: '' }
    errors.value = {}
    modal.show()
  }

  const uploadLogo = async (event) => {
    const file = event.target.files[0]
    event.target.value = ''
    if (!file) return
    const formData = new FormData()
    formData.append('image', file)
    isUploading.value = true
    try {
      const res = await axiosInstance.post('/uploadpartnerimg', formData, { headers: { 'Content-Type': 'multipart/form-data' } })
      form.value.logo = res.data.image_url
    } catch (error) {
      Swal.fire({ icon: 'error', title: 'Upload failed', text: error.response?.data?.message ?? 'Please try again.' })
    } finally {
      isUploading.value = false
    }
  }

  const save = async () => {
    errors.value = {}
    if (!form.value.logo) {
      errors.value.logo = 'Please choose a logo.'
      return
    }
    isSaving.value = true
    const payload = { name: form.value.name, logo: form.value.logo, url: form.value.url?.trim() || null }
    try {
      if (form.value.id) {
        await putData('/updatepartner/' + form.value.id, payload)
      } else {
        await postData('/addpartner', payload)
      }
      modal.hide()
      Swal.fire({ position: 'center', icon: 'success', title: 'Partner saved', showConfirmButton: false, timer: 1500 })
      load()
    } catch (error) {
      if (error.response?.status === 422) {
        const fieldErrors = error.response.data.errors || {}
        errors.value = Object.fromEntries(Object.entries(fieldErrors).map(([field, messages]) => [field, messages[0]]))
      } else {
        Swal.fire({ icon: 'error', title: 'Error', text: 'The partner could not be saved.' })
      }
    } finally {
      isSaving.value = false
    }
  }

  const remove = (partner) => {
    Swal.fire({
      title: `Remove ${partner.name}?`,
      text: "The logo will no longer appear on the website.",
      icon: "warning",
      showCancelButton: true,
      cancelButtonColor: "#d33",
      confirmButtonColor: "#3085d6",
      confirmButtonText: "Delete",
      cancelButtonText: "Close"
    }).then(async (result) => {
      if (result.isConfirmed) {
        await deleteData('/deletepartner/' + partner.id)
        Swal.fire({ position: 'center', icon: 'success', title: 'Partner removed', showConfirmButton: false, timer: 1500 })
        load()
      }
    })
  }

  const move = async (index, step) => {
    const list = [...partners.value]
    const [item] = list.splice(index, 1)
    list.splice(index + step, 0, item)
    partners.value = list
    isMoving.value = true
    try {
      const res = await putData('/reorderpartners', { ids: list.map(p => p.id) })
      partners.value = res.data.partners
    } catch (error) {
      Swal.fire({ icon: 'error', title: 'The new order could not be saved' })
      load()
    } finally {
      isMoving.value = false
    }
  }

  onMounted(() => {
    modal = new bootstrap.Modal(document.getElementById('partnermodal'))
    load()
  })
</script>

<style scoped>
  .logo-box{
    height: 120px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    background: #f7f9f6;
    border-bottom: 1px solid rgba(0, 0, 0, .05);
  }
  .logo-box img{
    max-width: 100%;
    max-height: 70px;
    object-fit: contain;
  }
  .logo-box-edit{
    border: 1px solid #e6ebe4;
    border-radius: 6px;
  }
</style>
