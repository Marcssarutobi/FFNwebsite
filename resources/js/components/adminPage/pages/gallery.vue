<template>
  <main>
    <div class="container-fluid">

        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h4 class="main-title">Gallery</h4>
                <button @click="showModal" class="btn btn-primary mb-2" >
                    <i class="iconoir-plus"></i> Add New Image
                </button>
            </div>
        </div>

        <div class="rows" style="margin-top: 50px !important; justify-content: start !important;">

            <div  class="pic " v-for="(src,index) in allImage" :key="index">
                <img :src="src.image" />
                <div class="overlay">
                    <button class="btn btn-primary me-3" @click="viewPhoto(src.id)"><i class="fas fa-eye"></i></button>
                    <button class="btn btn-danger" @click="DeleteTmage(src.id)" ><i class="fas fa-trash"></i></button>
                </div>
            </div>

        </div>

        <!--  Modal content for the Large example -->
        <div class="modal fade" id="addimages" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-xl ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel">Add Gallery</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                          <div class="col-lg-12">
                              <div class="form d-flex align-items-center justify-content-center ">
                                  <label for="file" class="btn btn-primary btn-lg rounded-0 m-0  p-3" >
                                    <i class="fas fa-upload"></i> Choose a photo 
                                    <input type="file" id="file" accept="image/*" multiple hidden @change="handleFileImg">
                                  </label>
                              </div>
                          </div>

                          <div class="col-lg-12 mt-3">
                            <div class="text d-flex align-items-center justify-content-center">
                                <p class="m-0">{{ data.image.length }} Files Selected</p>
                            </div>
                          </div>

                          <div class="col-lg-12 mt-3 p-3">
                            <div class="rows modale"  >
                                <div  class="pic" v-for="(img,index) in data.image" :key="index" >
                                  <img :src="img" />
                                  <div class="overlay">
                                      <button class="btn btn-danger" @click="deleteImage(index,img)" ><i class="fas fa-trash"></i></button>
                                  </div>
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
                        <button v-else type="button" class="btn btn-primary" @click="CreateGallery">Save</button>
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
import { deleteData, getData, getSingleData } from '../../plugin/api';
import Swal from 'sweetalert2';

  let addmodal;
  let updatemodal;

  const data = ref({
    image:[]
  })

  const allImage = ref([])

  const showModal = () =>{
    addmodal.show();
  }

  const AllImageFunction = async ()=>{
    await getData('/allimages')
          .then(response =>{
            if (response.status === 200) {
              allImage.value = response.data.gly
            }
          })
  }

  const handleFileImg = async (event)=>{
    const selectImg = event.target.files
    const formData = new FormData()

    for (let i = 0; i < selectImg.length; i++) {
      if (selectImg[i].type.startsWith('image/')) {
          formData.append('image[]', selectImg[i])
      }
    }

    try {
      const res = await axiosInstance.post('/uploadimagesgal', formData, {
          headers: {
              'Content-Type': 'multipart/form-data'
          }
      });
      if (res.status === 200) {
          data.value.image = res.data.image_urls
      }
    } catch (error) {
        console.log(error)
    }

  }

  const deleteImage = async (index, img)=>{
    try {
      const res = await axiosInstance.post('/delimagesgal', { image: img });
      if (res.status === 200) {
          data.value.image.splice(index, 1);
      }
    } catch (error) {
        console.log(error);
    }
  }

  const CreateGallery = async ()=>{
    if (data.value.image.length > 0) {
      data.value.image.forEach(async (img)=>{
          const res = await axiosInstance.post('/addimages',{image:img},{
              headers: {
                  Authorization: `Bearer ${localStorage.getItem("token")}`,
              },
          })
          if (res.status === 200) {
              data.value.image = []
              addmodal.hide()
              AllImageFunction()
          }
      })
    }
  }

  const DeleteTmage = async(id)=>{

    Swal.fire({
        title: "Do you want to delete this Image?",
        text: "You can't go back!",
        icon: "warning",
        showCancelButton: true,
        cancelButtonColor: "#d33",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Delete",
        cancelButtonText: "Close"
    }).then(async (result) => {
        if (result.isConfirmed) {
            await getSingleData('/showimages/'+id)
                  .then(async (response) => {
                    if (response.status === 200) {
                      const img = response.data.gly
                      if (img) {
                        const delImage = await axiosInstance.post('/delimagesgal', { image: img.image })
                        if (delImage.status === 200 ) {
                          deleteData('/delimages/'+img.id).then(responseImage =>{
                            if (responseImage.status === 200) {
                              Swal.fire({
                                  position: "center",
                                  icon: "success",
                                  title: "Deletion performed",
                                  showConfirmButton: false,
                                  timer: 1500
                              })
                              AllImageFunction()
                            }
                          })
                        }
                      }
                    }
                  })
        }
    })

  }



  onMounted(()=>{
    addmodal = new bootstrap.Modal(document.getElementById('addimages'))
    AllImageFunction()
  })

</script>

<style scoped>

  .rows{
      display: flex;
      align-items: center;
      justify-content: center;
      flex-wrap: wrap;
      gap: 10px;
  }
  .rows .pic{
      display: flex;
      align-items: center;
      justify-content: center;
      width: 300px;
      height: 300px;
      overflow: hidden;
      background-color: #e1e1e1;
  }

  .pic img{
      max-width: 100%;
      max-height: 100%;
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.3s ease-in-out;
  }
  .pic img:hover{
      transform: scale(1.2);
  }

  .pic .overlay{
      position: absolute;
      width: 300px;
      height: 300px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: rgba(0, 0, 0, 0.5);
      opacity: 0;
      transition: all 0.3s ease-in-out ;
  }

  .pic .overlay:hover{
      opacity: 1;
  }


  .containers{
      max-width: 100%;
      width: 200px;
      background: #fff;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      cursor: pointer;
  }
  .containers .img-area{
      position: relative;
      width: 200px;
      height: 200px;
      background: #e1e1e1;
      border-radius: 5px;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
  }
  .img-area .icon{
      font-size: 55px;
  }
  .img-area h3{
      font-size: 14px;
      font-weight: 500;
      margin-bottom: 6px;
      margin: 0 !important;
  }
  .img-area p{
      color: #999;
      font-size: 15px;
      text-align: center;
      margin: 0 !important;
  }
  .img-area p span{
      font-weight: 600;
  }
  .img-area img
  {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: top;
    z-index: 100;
  }

</style>
