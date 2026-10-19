<template>
  <main>
    <div class="container-fluid">

        <div class="row mb-4">
            <div class="col-12">
                <h4 class="main-title">Home Slider</h4>
                <p class="text-muted mb-0">
                    Images scrolling at the top of the home page. Use landscape photos, ideally 1920 × 1080 px or larger (JPG, PNG or WebP, 10 MB max).
                    Click « Edit texts » to change the title, text and button of a slide.
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-4 col-md-6 mb-4" v-for="slide in allSlides" :key="slide.id">
                <div class="card h-100">
                    <div class="ratio ratio-16x9 slide-preview">
                        <img :src="slide.image" :alt="'Slide ' + slide.position">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title mb-1">Slide {{ slide.position }}</h5>
                        <p class="card-text text-muted mb-0">{{ [slide.title_light, slide.title].filter(Boolean).join(' ') || '(no title)' }}</p>
                    </div>
                    <div class="card-footer d-flex justify-content-end gap-2">
                        <button class="btn btn-outline-primary" @click="showEditModal(slide)"><i class="fas fa-edit"></i> Edit texts</button>
                        <button disabled v-if="loadingId === slide.id" class="btn btn-primary">
                            <div class="spinner-border spinner-border-sm text-light" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </button>
                        <label v-else class="btn btn-primary m-0">
                            <i class="fas fa-upload"></i> Change image
                            <input type="file" accept="image/jpeg,image/png,image/webp" hidden @change="changeImage($event, slide)">
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal des textes -->
        <div class="modal fade" id="editslide" tabindex="-1" role="dialog" aria-labelledby="slideModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="slideModalLabel">Slide {{ form.position }} — texts</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Title — light part</label>
                                <input type="text" class="form-control" maxlength="255" v-model="form.title_light" placeholder="Help us">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Title — bold part</label>
                                <input type="text" class="form-control" maxlength="255" v-model="form.title" placeholder="promote the mushrooms">
                            </div>
                            <div class="col-12 mb-3" v-if="form.position === 1">
                                <label class="form-label">Subtitle (green banner)</label>
                                <input type="text" class="form-control" maxlength="255" v-model="form.subtitle">
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Text</label>
                                <textarea class="form-control" rows="4" maxlength="1000" v-model="form.text"></textarea>
                                <small class="text-muted">Each line break is kept on the slide. Keep lines short so they fit on the image.</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Button label</label>
                                <input type="text" class="form-control" maxlength="60" v-model="form.button_label" placeholder="Learn More">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Button link</label>
                                <input type="text" class="form-control" maxlength="255" v-model="form.button_link" placeholder="/domain or https://...">
                                <small class="text-muted">A page of the site (/contact, /project…) or a full address (https://…). Leave the label or the link empty to hide the button.</small>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Preview</label>
                                <div class="slide-live" :class="{ 'slide-live-left': form.position === 1 }" :style="{ backgroundImage: 'url(' + form.image + ')' }">
                                    <div class="slide-live-inner">
                                        <template v-if="form.position === 1">
                                            <div class="live-h1"><span class="fw-light">{{ form.title_light }}</span> <strong>{{ form.title }}</strong></div>
                                            <div class="live-sub" v-if="form.subtitle">{{ form.subtitle }}</div>
                                        </template>
                                        <template v-else>
                                            <div class="live-h2 fw-light" v-if="form.title_light">{{ form.title_light }}</div>
                                            <div class="live-h2" v-if="form.title"><strong>{{ form.title }}</strong></div>
                                        </template>
                                        <div class="live-text" v-if="form.text">{{ form.text }}</div>
                                        <span class="live-btn" v-if="form.button_label && form.button_link">{{ form.button_label }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger me-3" data-bs-dismiss="modal">Fermer</button>
                        <button disabled v-if="isSaving" class="btn btn-primary">
                            <div class="spinner-border text-light" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </button>
                        <button v-else type="button" class="btn btn-primary" @click="SaveTexts">Save</button>
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
  import { getData, putData } from '../../plugin/api';
  import Swal from 'sweetalert2';

  const allSlides = ref([])
  const loadingId = ref(null)
  const isSaving = ref(false)
  const form = ref({})
  let editmodal;

  const textFields = ['title_light', 'title', 'subtitle', 'text', 'button_label', 'button_link']

  // Champs envoyés à l'API : chaînes vides converties en null
  const payloadOf = (slide) => {
    const payload = { image: slide.image }
    textFields.forEach(field => {
      const value = typeof slide[field] === 'string' ? slide[field].trim() : slide[field]
      payload[field] = value ? value : null
    })
    return payload
  }

  const showEditModal = (slide) =>{
    form.value = { ...slide }
    textFields.forEach(field => { form.value[field] = form.value[field] ?? '' })
    editmodal.show()
  }

  const SaveTexts = async ()=>{
    const link = form.value.button_link.trim()
    if (link && !(/^\/(?!\/)/.test(link) || /^https?:\/\//.test(link))) {
      Swal.fire({ icon: "warning", title: "Invalid link", text: "Use a page of the site starting with / or a full address starting with https://" })
      return
    }

    isSaving.value = true
    try {
      const res = await putData('/updateslide/' + form.value.id, payloadOf(form.value))
      if (res.status === 200) {
          Swal.fire({
                position: "center",
                icon: "success",
                title: "Slide updated",
                showConfirmButton: false,
                timer: 1500
          })
          editmodal.hide()
          AllSlidesFunction()
      }
    } catch (error) {
        console.log(error)
        Swal.fire({ icon: "error", title: "Error", text: error.response?.data?.message ?? "Please try again." })
    } finally {
        isSaving.value = false
    }
  }

  const AllSlidesFunction = async ()=>{
    await getData('/homeslides')
          .then(response =>{
            if (response.status === 200) {
              allSlides.value = response.data.slides
            }
          })
  }

  const changeImage = async (event, slide)=>{
    const file = event.target.files[0]
    event.target.value = ''
    if (!file) return

    if (file.size > 10 * 1024 * 1024) {
      Swal.fire({ icon: "error", title: "File too large", text: "The image must not exceed 10 MB." })
      return
    }

    const formData = new FormData()
    formData.append('image', file)
    loadingId.value = slide.id

    try {
      const upload = await axiosInstance.post('/uploadslideimg', formData, {
          headers: {
              'Content-Type': 'multipart/form-data'
          }
      });
      const res = await putData('/updateslide/' + slide.id, payloadOf({ ...slide, image: upload.data.image_url }))
      if (res.status === 200) {
          Swal.fire({
                position: "center",
                icon: "success",
                title: "Image updated",
                showConfirmButton: false,
                timer: 1500
          })
          AllSlidesFunction()
      }
    } catch (error) {
        console.log(error)
        Swal.fire({ icon: "error", title: "Error", text: error.response?.data?.message ?? "Please try again." })
    } finally {
        loadingId.value = null
    }
  }

  onMounted(()=>{
    editmodal = new bootstrap.Modal(document.getElementById('editslide'))
    AllSlidesFunction()
  })

</script>

<style scoped>
  .slide-preview{
    background: #e1e1e1;
    overflow: hidden;
  }
  .slide-preview img{
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center top;
  }

  /* Aperçu approximatif du rendu sur la page d'accueil */
  .slide-live{
    position: relative;
    aspect-ratio: 16 / 7;
    background-size: cover;
    background-position: center top;
    border-radius: 6px;
    overflow: hidden;
    color: #fff;
  }
  .slide-live::before{
    content: "";
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, .4);
  }
  .slide-live-inner{
    position: relative;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    gap: 8px;
    padding: 20px;
  }
  .slide-live-left .slide-live-inner{
    align-items: flex-start;
    text-align: left;
  }
  .live-h1{ font-size: 32px; text-transform: uppercase; line-height: 1.1; }
  .live-h2{ font-size: 26px; text-transform: uppercase; line-height: 1.1; }
  .live-sub{ background: #179607; padding: 4px 10px; font-weight: 700; text-transform: uppercase; }
  .live-text{ white-space: pre-line; font-size: 13px; }
  .live-btn{ border: 2px solid #fff; padding: 6px 14px; font-size: 12px; font-weight: 700; text-transform: uppercase; }
</style>
