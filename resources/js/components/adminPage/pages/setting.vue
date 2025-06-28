<template >
    <main>
        <div class="container-fluid">

            <div class="row mb-4">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <h4 class="main-title">Settings</h4>
                    <!-- <button class="btn btn-primary mb-2" @click="showModal" >
                        <i class="iconoir-plus"></i> New Category
                    </button> -->
                </div>
            </div>

            <div class="row">

                <div class="col-lg-4 col-xxl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="vertical-tab setting-tab">
                                <ul class="nav nav-tabs tab-light-primary " id="v-bg" role="tablist">
                                    <li class="nav-item mb-3" role="presentation">
                                        <router-link to="/admins/settings" exact-active-class="active" class="nav-link" ><i class="ph-bold  ph-user-circle-gear pe-2"></i>
                                            Profile
                                        </router-link>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <router-link to="/admins/settings/password" exact-active-class="active" class="nav-link" ><i class="ph-bold  ph ph-password pe-2"></i>
                                            Password
                                        </router-link>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-8 col-xxl-9 d-flex align-items-center justify-content-center">
                    <router-view></router-view>
                </div>

            </div>

        </div>
    </main>
</template>
<script>
export default {

}
</script>
<style>

</style>
