<template>
  <!-- Menu Navigation starts -->
  <nav>
        <div class="app-logo">
            <a class="logo d-inline-block" href="index.html">
                <img alt="#" src="/admin/assets/images/logo/1.png">
            </a>

            <span class="bg-light-primary toggle-semi-nav">
                <i class="ti ti-chevrons-right f-s-20"></i>
            </span>
        </div>
        <div class="app-nav mt-4" id="app-simple-bar">
            <ul class="main-nav p-0 mt-2">
                <li class="no-sub mb-2">
                    <router-link exact-active-class="active" to="/admins">
                        <i class="iconoir-home-alt"></i>
                        dashboard
                    </router-link>
                </li>
                <li class="no-sub mb-2">
                    <router-link exact-active-class="active" to="/admins/projects">
                        <i class="iconoir-task-list"></i> Projects
                    </router-link>
                </li>
                <li class="no-sub mb-2">
                    <a class="" href="widget.html">
                        <i class="iconoir-calendar"></i> Events
                    </a>
                </li>
                <li class="no-sub mb-2">
                    <a class="" href="widget.html">
                        <i class="iconoir-page-edit"></i> Blog
                    </a>
                </li>
                <li class="no-sub mb-2">
                    <a class="" href="widget.html">
                        <i class="iconoir-media-image-list"></i> Gallery
                    </a>
                </li>
                <li class="no-sub mb-2">
                    <a class="" href="widget.html">
                        <i class="iconoir-mail"></i> Contacts
                    </a>
                </li>
                <li class="no-sub mb-2">
                    <a class="" href="widget.html">
                        <i class="iconoir-user"></i> Users
                    </a>
                </li>


            </ul>
        </div>

        <div class="menu-navs">
            <span class="menu-previous"><i class="ti ti-chevron-left"></i></span>
            <span class="menu-next"><i class="ti ti-chevron-right"></i></span>
        </div>

    </nav>
    <!-- Menu Navigation ends -->
</template>

<script lang="ts" setup>

</script>

<style scoped>
    a.active{
        background: rgba(140,118,240, .3) !important;
        color: rgba(36,17,135, 1) !important;
        font-weight: 600 !important;
    }
</style>
