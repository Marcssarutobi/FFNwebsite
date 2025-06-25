<template>
  <main>
    <div class="container-fluid">
        
      <div class="row mb-4">
          <div class="col-12 d-flex justify-content-between align-items-center">
              <h4 class="main-title">Contacts</h4>
              <!-- <button class="btn btn-primary mb-2" @click="showModal" >
                  <i class="iconoir-plus"></i> New Category
              </button> -->
          </div>
      </div>

      <div class="row">
          <div class="col-12">
              <div class="card">
                  <div class="card-body p-3">
                      <DataTable :data="allcontact" :columns="columns" :DeleteAllFunction="DeleteAllFunction" />
                  </div>
              </div>
          </div>
      </div>

      <!--  Modal content for the Large example -->
        <div class="modal fade" id="updatecontact" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog  modal-lg ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel">View Contact</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                   
                    <div class="modal-body">
                        <div class="row">
                          
                          <div class="col-lg-6 mb-3">
                            <div class="form-group">
                              <label for="">Full Name :</label>
                              <h5 for="">{{getcontact.name}}</h5>
                            </div>
                          </div>

                          <div class="col-lg-6 mb-3">
                            <div class="form-group">
                              <label for="">Email :</label>
                              <h5 for="">{{getcontact.email}}</h5>
                            </div>
                          </div>

                          <div class="col-lg-12">
                            <div class="form-group">
                              <h6 for="">Message :</h6>
                              <span  style="text-align: justify !important;">{{getcontact.message}}</span>
                            </div>
                          </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger me-3" data-bs-dismiss="modal">Close</button>
                        <!-- <button disabled v-if="isLoader" class="btn btn-primary">
                        <div class="spinner-border text-light" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        </button> -->
                        <a  :href="'mailto:'+getcontact.email" class="btn btn-primary" >Reply</a>
                    </div>
                    
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

    </div>
  </main>
</template>

<script setup>

  import { ref,onMounted, render } from 'vue';
  import axiosInstance from '../../plugin/axios.js';
  import DataTable from'../components/Datatable.vue'
  import Swal from 'sweetalert2';
  import { getData, getSingleData, putData } from '../../plugin/api.js';

  const allcontact = ref([])
  const getcontact = ref({})
  let updatemodal;

  const AllContactFunction = async () =>{
    await getData('/contacts')
          .then(response =>{
            if (response.status === 200) {
              allcontact.value = response.data.contacts
            }
          })
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
    { title: 'Name', data: 'name' },
    { title: 'Email', data: 'email' },
    { 
      title: 'Status', 
      data: 'is_read',
      render: function (data, type, row){
        return `
        
          ${row.is_read === 0 ? `<span class="badge bg-danger">New</span>`:`<span class="badge bg-secondary">Read</span>`}

        `
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
    { title: 'Actions', data: null, render: (data, type, row) => {
        // Personnalise ici l'affichage des actions si nécessaire
        return `
            <a class="btn btn-secondary" onClick="GetContactFunction(${row.id})" ><i class="far fa-eye"></i></a>
            <a class="btn btn-danger" onClick="DeleteFunctionContact(${row.id})" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="far fa-trash-alt"></i></a>
        `;
      }
    }
  ]

  const GetContactFunction = async (id)=>{
    await getSingleData('/showcontact/'+id)
          .then(async (response)=>{
            if (response.status === 200) {
              getcontact.value = response.data.data
              await putData('/updatecontact/'+getcontact.value.id)
                    .then(res=>{
                      if (res.status === 200) {
                        updatemodal.show()
                        AllContactFunction()
                      }
                    })
            }
          })
  }

  const DeleteFunctionContact = async (id)=>{
    Swal.fire({
        title: "Do you want to delete this Contact ?",
        text: "You can't go back!",
        icon: "warning",
        showCancelButton: true,
        cancelButtonColor: "#d33",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Delete",
        cancelButtonText: "Close"
    }).then(async (result) => {
        if (result.isConfirmed) {
            const del = await axiosInstance.delete('/deletecontact/' + id, {
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('token')}`
                }
            })
            if (del.status === 200) {
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Deletion performed",
                    showConfirmButton: false,
                    timer: 1500
                })
                AllContactFunction()
            }
        }
    })
  }

  const DeleteAllFunction = async (ids=[])=>{
    if (ids.length === 0) return;

    Swal.fire({
        title: `Delete ${ids.length} Contact ?`,
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
                    const del = await axiosInstance.delete(`/deletecontact/${ids[i]}`, {
                        headers: {
                            'Authorization': `Bearer ${localStorage.getItem('token')}`
                        }
                    });

                    if (del.status !== 200) {
                        throw new Error(`Échec de la suppression de l'ID ${ids[i]}`);
                    }
                }

                Swal.fire({
                    icon: "success",
                    title: "Suppression réussie",
                    text: `${ids.length} catégories supprimées.`,
                    showConfirmButton: false,
                    timer: 2000
                });

                AllContactFunction(); // 🔄 recharge les données

            } catch (error) {
                Swal.fire("Erreur", "Une erreur est survenue pendant la suppression.", "error");
                console.error(error);
            }
        }
    });
  }

  onMounted(()=>{
    updatemodal = new bootstrap.Modal(document.getElementById('updatecontact'))
    AllContactFunction()
    window.GetContactFunction = GetContactFunction
    window.DeleteFunctionContact = DeleteFunctionContact
  })

</script>

<style>

</style>
