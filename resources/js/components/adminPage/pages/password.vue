<template>
    <div class="card">
        <div class="card-header">
            <h4 class="main-title mb-1">Change Password</h4>
            <p class="text-muted mb-0 small">For your security, other devices signed in to your account will be signed out after the change.</p>
        </div>

        <div class="card-body bg-white p-4">
            <form class="app-form" @submit.prevent="UpdatePassword" novalidate>
                <div class="row">

                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label" for="current-password">Current password</label>
                            <div class="input-group has-validation">
                                <input id="current-password" class="form-control" :class="{ 'is-invalid': errors.current_password }"
                                       v-model="data.current_password" :type="show.current ? 'text' : 'password'" autocomplete="current-password">
                                <button type="button" class="btn btn-outline-secondary" @click="show.current = !show.current"
                                        :aria-label="show.current ? 'Hide password' : 'Show password'" :title="show.current ? 'Hide' : 'Show'">
                                    <i :class="show.current ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                                </button>
                                <div class="invalid-feedback">{{ errors.current_password }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label" for="new-password">New password</label>
                            <div class="input-group has-validation">
                                <input id="new-password" class="form-control" :class="{ 'is-invalid': errors.new_password }"
                                       v-model="data.new_password" :type="show.new ? 'text' : 'password'" autocomplete="new-password" aria-describedby="password-rules">
                                <button type="button" class="btn btn-outline-secondary" @click="show.new = !show.new"
                                        :aria-label="show.new ? 'Hide password' : 'Show password'" :title="show.new ? 'Hide' : 'Show'">
                                    <i :class="show.new ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                                </button>
                                <div class="invalid-feedback">{{ errors.new_password }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label" for="confirm-password">Confirm new password</label>
                            <div class="input-group has-validation">
                                <input id="confirm-password" class="form-control" :class="{ 'is-invalid': errors.new_password_confirmation }"
                                       v-model="data.new_password_confirmation" :type="show.confirm ? 'text' : 'password'" autocomplete="new-password">
                                <button type="button" class="btn btn-outline-secondary" @click="show.confirm = !show.confirm"
                                        :aria-label="show.confirm ? 'Hide password' : 'Show password'" :title="show.confirm ? 'Hide' : 'Show'">
                                    <i :class="show.confirm ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                                </button>
                                <div class="invalid-feedback">{{ errors.new_password_confirmation }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Règles du nouveau mot de passe, cochées au fur et à mesure de la saisie -->
                    <div class="col-12">
                        <ul class="password-rules" id="password-rules">
                            <li v-for="rule in rules" :key="rule.label" :class="{ ok: rule.ok }">
                                <i :class="rule.ok ? 'fas fa-circle-check' : 'far fa-circle'"></i> {{ rule.label }}
                            </li>
                        </ul>
                    </div>

                    <div class="col-12 mt-2">
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary" type="submit" :disabled="isLoader">
                                <span v-if="isLoader" class="spinner-border spinner-border-sm me-1" role="status"></span>
                                Change password
                            </button>
                        </div>
                    </div>

                </div>
            </form>
        </div>

    </div>
</template>
<script setup>
    import { computed, ref } from 'vue';
    import Swal from 'sweetalert2';
    import axiosInstance from '../../plugin/axios';

    const emptyForm = () => ({
        current_password: '',
        new_password: '',
        new_password_confirmation: '',
    })

    const data = ref(emptyForm())
    const errors = ref({})
    const isLoader = ref(false)
    const show = ref({ current: false, new: false, confirm: false })

    const rules = computed(() => [
        { label: 'At least 8 characters', ok: data.value.new_password.length >= 8 },
        { label: 'Different from the current password', ok: data.value.new_password !== '' && data.value.new_password !== data.value.current_password },
        { label: 'Both new passwords match', ok: data.value.new_password !== '' && data.value.new_password === data.value.new_password_confirmation },
    ])

    const validate = () => {
        const e = {}
        if (!data.value.current_password) e.current_password = 'Please enter your current password.'
        if (!data.value.new_password) e.new_password = 'Please choose a new password.'
        else if (data.value.new_password.length < 8) e.new_password = 'The new password must be at least 8 characters.'
        else if (data.value.new_password === data.value.current_password) e.new_password = 'The new password must be different from the current one.'
        if (!data.value.new_password_confirmation) e.new_password_confirmation = 'Please confirm the new password.'
        else if (data.value.new_password_confirmation !== data.value.new_password) e.new_password_confirmation = 'The two new passwords do not match.'
        errors.value = e
        return Object.keys(e).length === 0
    }

    const UpdatePassword = async () => {
        if (!validate()) return

        isLoader.value = true
        try {
            // Le serveur change le mot de passe de l'utilisateur connecté (l'identifiant de l'URL est ignoré)
            await axiosInstance.put('/updatepwd/me', data.value)
            data.value = emptyForm()
            errors.value = {}
            show.value = { current: false, new: false, confirm: false }
            Swal.fire({
                icon: 'success',
                title: 'Password changed',
                text: 'Your new password is active. Other devices have been signed out.',
                confirmButtonColor: '#179607',
            })
        } catch (error) {
            if (error.response?.status === 422) {
                const fieldErrors = error.response.data.errors || {}
                const mapped = Object.fromEntries(Object.entries(fieldErrors).map(([field, messages]) => [field, messages[0]]))
                // « confirmed » est rattaché au nouveau mot de passe par Laravel : on l'affiche sous la confirmation
                if (mapped.new_password === 'The two new passwords do not match.') {
                    mapped.new_password_confirmation = mapped.new_password
                    delete mapped.new_password
                }
                errors.value = mapped
            } else {
                Swal.fire({ icon: 'error', title: 'Error', text: 'The password could not be changed. Please try again.' })
            }
        } finally {
            isLoader.value = false
        }
    }
</script>
<style scoped>
    .password-rules{
        list-style: none;
        margin: 0 0 8px;
        padding: 12px 16px;
        border-radius: 8px;
        background: #f6f7f9;
        display: flex;
        flex-wrap: wrap;
        gap: 8px 24px;
        font-size: 13px;
        color: #6c757d;
    }
    .password-rules li i{
        margin-right: 4px;
    }
    .password-rules li.ok{
        color: #198754;
        font-weight: 600;
    }
</style>
