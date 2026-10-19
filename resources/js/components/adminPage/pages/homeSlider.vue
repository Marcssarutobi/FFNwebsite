<template>
  <main>
    <div class="container-fluid">

        <div class="row mb-4">
            <div class="col-12">
                <h4 class="main-title">Home Slider</h4>
                <p class="text-muted mb-0">
                    Images scrolling at the top of the home page. Use landscape photos, ideally 1920 × 1080 px or larger (JPG, PNG or WebP, 10 MB max).
                    The texts on each slide stay the same.
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
                        <p class="card-text text-muted">{{ captions[slide.position - 1] }}</p>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
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

    </div>
  </main>
</template>

<script setup>
  import { onMounted, ref } from 'vue';
  import axiosInstance from '../../plugin/axios';
  import { getData, putData } from '../../plugin/api';
  import Swal from 'sweetalert2';

  // Texte affiché sur chaque diapositive (défini dans userPage/pages/home.vue)
  const captions = [
    'Fungi for Nature — Save the world of mushrooms',
    'Help us promote the mushrooms',
    'Help us promote the mushrooms',
    'Help us promote the mushrooms',
    'Help us promote the mushrooms',
  ]

  const allSlides = ref([])
  const loadingId = ref(null)

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
      const res = await putData('/updateslide/' + slide.id, { image: upload.data.image_url })
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
</style>
