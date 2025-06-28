<template >
    <div class="card">
        <div class="card-header">
            <h4 class="main-title">Change Password</h4>
        </div>

        <div class="card-body bg-white p-4">
            <div class="profile-tab profile-container">

                <form class="app-form" >
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Old password</label>
                                <input class="form-control" placeholder="********" type="password" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">New password</label>
                                <input class="form-control" placeholder="********" type="password" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Confirm new password</label>
                                <input class="form-control" placeholder="********" type="password" required>
                            </div>
                        </div>

                        <div class="col-12 mt-3">
                            <div class="text-end">

                                <button  class="btn btn-primary" type="submit">Save change</button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>

    </div>
</template>
<script setup>

</script>
<style scoped>

</style>
