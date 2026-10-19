<template>
  <main>
    <div class="container-fluid">

        <div class="row mb-4">
            <div class="col-12">
                <h4 class="main-title mb-1">Site settings</h4>
                <p class="text-muted mb-0">Contact details, social networks and texts shown on the public website.</p>
            </div>
        </div>

        <div class="text-center py-5" v-if="isLoading">
            <div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
        </div>

        <form v-else @submit.prevent="save" novalidate>
            <div class="row">

                <!-- Coordonnées -->
                <div class="col-xl-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-transparent"><h5 class="mb-0">Contact details</h5></div>
                        <div class="card-body">
                            <p class="text-muted small">Shown in the header, the footer and on the Contact page.</p>
                            <div class="mb-3">
                                <label class="form-label" for="s-email">Email</label>
                                <input id="s-email" type="email" class="form-control" :class="{ 'is-invalid': errors.contact_email }" v-model="form.contact_email">
                                <div class="invalid-feedback">{{ errors.contact_email }}</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="s-phone">Phone</label>
                                <input id="s-phone" type="text" class="form-control" :class="{ 'is-invalid': errors.contact_phone }" v-model="form.contact_phone" placeholder="(+229) 0196975772">
                                <div class="invalid-feedback">{{ errors.contact_phone }}</div>
                            </div>
                            <div class="mb-0">
                                <label class="form-label" for="s-address">Address</label>
                                <input id="s-address" type="text" class="form-control" :class="{ 'is-invalid': errors.contact_address }" v-model="form.contact_address">
                                <div class="invalid-feedback">{{ errors.contact_address }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Réseaux sociaux -->
                <div class="col-xl-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-transparent"><h5 class="mb-0">Social networks</h5></div>
                        <div class="card-body">
                            <p class="text-muted small">Full page addresses (https://…). A network left empty is not shown on the website.</p>
                            <div class="mb-3" v-for="network in networks" :key="network.key">
                                <label class="form-label" :for="'s-' + network.key"><i :class="network.icon" class="me-1"></i> {{ network.label }}</label>
                                <input :id="'s-' + network.key" type="url" class="form-control" :class="{ 'is-invalid': errors[network.key] }" v-model="form[network.key]" :placeholder="network.placeholder">
                                <div class="invalid-feedback">{{ errors[network.key] }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Some Facts -->
                <div class="col-xl-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-transparent"><h5 class="mb-0">Home page – « Some Facts »</h5></div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="s-facts-title">Highlighted sentence</label>
                                <textarea id="s-facts-title" rows="2" class="form-control" :class="{ 'is-invalid': errors.facts_title }" v-model="form.facts_title"></textarea>
                                <div class="invalid-feedback">{{ errors.facts_title }}</div>
                            </div>
                            <div class="mb-0">
                                <label class="form-label" for="s-facts-text">Text</label>
                                <textarea id="s-facts-text" rows="4" class="form-control" :class="{ 'is-invalid': errors.facts_text }" v-model="form.facts_text"></textarea>
                                <div class="invalid-feedback">{{ errors.facts_text }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mot du CEO -->
                <div class="col-xl-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-transparent"><h5 class="mb-0">Home page – « Word from CEO »</h5></div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="s-ceo-message">Message</label>
                                <textarea id="s-ceo-message" rows="5" class="form-control" :class="{ 'is-invalid': errors.ceo_message }" v-model="form.ceo_message"></textarea>
                                <div class="invalid-feedback">{{ errors.ceo_message }}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="s-ceo-name">Name</label>
                                    <input id="s-ceo-name" type="text" class="form-control" v-model="form.ceo_name">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="s-ceo-role">Role</label>
                                    <input id="s-ceo-role" type="text" class="form-control" v-model="form.ceo_role">
                                </div>
                            </div>
                            <label class="form-label d-block">Photo</label>
                            <div class="d-flex align-items-center gap-3">
                                <img v-if="form.ceo_photo" :src="form.ceo_photo" alt="" class="ceo-photo">
                                <div v-if="isUploading" class="spinner-border spinner-border-sm text-primary" role="status"></div>
                                <label v-else class="btn btn-outline-primary m-0">
                                    <i class="fas fa-upload"></i> Change photo
                                    <input type="file" accept="image/jpeg,image/png,image/webp" hidden @change="uploadPhoto">
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="save-bar">
                <span class="text-muted small" v-if="savedAt">Saved at {{ savedAt }}</span>
                <button type="submit" class="btn btn-primary" :disabled="isSaving">
                    <span v-if="isSaving" class="spinner-border spinner-border-sm me-1" role="status"></span>
                    Save changes
                </button>
            </div>
        </form>

    </div>
  </main>
</template>

<script setup>
  import { onMounted, ref } from 'vue';
  import axiosInstance from '../../plugin/axios';
  import { getData, putData } from '../../plugin/api';
  import Swal from 'sweetalert2';

  const networks = [
    { key: 'social_facebook', label: 'Facebook', icon: 'fa-brands fa-facebook', placeholder: 'https://www.facebook.com/…' },
    { key: 'social_x', label: 'X (Twitter)', icon: 'fa-brands fa-x-twitter', placeholder: 'https://x.com/…' },
    { key: 'social_instagram', label: 'Instagram', icon: 'fa-brands fa-instagram', placeholder: 'https://www.instagram.com/…' },
    { key: 'social_linkedin', label: 'LinkedIn', icon: 'fa-brands fa-linkedin', placeholder: 'https://www.linkedin.com/company/…' },
  ]

  const form = ref({})
  const errors = ref({})
  const isLoading = ref(true)
  const isSaving = ref(false)
  const isUploading = ref(false)
  const savedAt = ref('')

  const load = async () => {
    isLoading.value = true
    try {
      const res = await getData('/settings')
      form.value = Object.fromEntries(Object.entries(res.data.settings).map(([key, value]) => [key, value ?? '']))
    } finally {
      isLoading.value = false
    }
  }

  const save = async () => {
    isSaving.value = true
    errors.value = {}
    try {
      const res = await putData('/settings', form.value)
      form.value = Object.fromEntries(Object.entries(res.data.settings).map(([key, value]) => [key, value ?? '']))
      savedAt.value = new Date().toLocaleTimeString('en-GB', { hour: '2-digit', minute: '2-digit' })
      Swal.fire({ position: 'center', icon: 'success', title: 'Settings saved', showConfirmButton: false, timer: 1500 })
    } catch (error) {
      if (error.response?.status === 422) {
        const fieldErrors = error.response.data.errors || {}
        errors.value = Object.fromEntries(Object.entries(fieldErrors).map(([field, messages]) => [field, messages[0]]))
        Swal.fire({ icon: 'warning', title: 'Please check the highlighted fields' })
      } else {
        Swal.fire({ icon: 'error', title: 'Error', text: 'The settings could not be saved. Please try again.' })
      }
    } finally {
      isSaving.value = false
    }
  }

  // La nouvelle photo est enregistrée avec le bouton « Save changes »
  const uploadPhoto = async (event) => {
    const file = event.target.files[0]
    event.target.value = ''
    if (!file) return

    const formData = new FormData()
    formData.append('image', file)
    isUploading.value = true
    try {
      const res = await axiosInstance.post('/uploadsettingimg', formData, { headers: { 'Content-Type': 'multipart/form-data' } })
      form.value.ceo_photo = res.data.image_url
      await save()
    } catch (error) {
      Swal.fire({ icon: 'error', title: 'Upload failed', text: error.response?.data?.message ?? 'Please try again.' })
    } finally {
      isUploading.value = false
    }
  }

  onMounted(load)
</script>

<style scoped>
  .ceo-photo{
    width: 64px;
    height: 64px;
    border-radius: 50%;
    object-fit: cover;
  }
  .save-bar{
    position: sticky;
    bottom: 0;
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 16px;
    padding: 14px 0;
    background: linear-gradient(to top, #f8f9fa 70%, rgba(248, 249, 250, 0));
    z-index: 5;
  }
</style>
