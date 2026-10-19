<template>
  <main>
    <div class="container-fluid mt-3">

        <div class="row mb-4">
            <div class="col-12 d-flex flex-wrap justify-content-between align-items-end gap-2">
                <div>
                    <h4 class="main-title mb-1">Dashboard</h4>
                    <p class="text-muted mb-0">Overview of the Fungi For Nature website content.</p>
                </div>
                <small class="text-muted" v-if="loadedAt">Updated at {{ loadedAt }}</small>
            </div>
        </div>

        <div class="text-center py-5" v-if="isLoading">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <div class="alert alert-danger" v-else-if="hasError">
            The dashboard could not be loaded. <a href="#" @click.prevent="loadDashboard">Try again</a>
        </div>

        <template v-else>

            <!-- Indicateurs -->
            <div class="row">
                <div class="col-xxl-3 col-xl-4 col-sm-6 mb-4" v-for="tile in tiles" :key="tile.label">
                    <RouterLink :to="tile.to" class="card stat-tile h-100" :class="{ 'stat-tile-alert': tile.alert }">
                        <div class="card-body d-flex align-items-center gap-3">
                            <span class="stat-icon"><i :class="tile.icon"></i></span>
                            <div class="min-w-0">
                                <div class="stat-label">{{ tile.label }}</div>
                                <div class="stat-value">{{ tile.value }}</div>
                                <div class="stat-detail" v-if="tile.detail">{{ tile.detail }}</div>
                            </div>
                        </div>
                    </RouterLink>
                </div>
            </div>

            <div class="row">

                <!-- Statut des contenus -->
                <div class="col-xl-7 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0">Content status</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Content</th>
                                            <th class="text-end">Published</th>
                                            <th class="text-end">Draft</th>
                                            <th class="text-end">Awaiting approval</th>
                                            <th class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="row in statusRows" :key="row.label">
                                            <td><RouterLink :to="row.to" class="fw-semibold text-dark">{{ row.label }}</RouterLink></td>
                                            <td class="text-end">{{ row.published }}</td>
                                            <td class="text-end">{{ row.draft }}</td>
                                            <td class="text-end">
                                                <span class="badge text-bg-warning" v-if="row.approbation > 0">{{ row.approbation }} to review</span>
                                                <span v-else>0</span>
                                            </td>
                                            <td class="text-end fw-semibold">{{ row.published + row.draft + row.approbation }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- En attente d'approbation -->
                <div class="col-xl-5 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Awaiting approval</h5>
                            <span class="badge text-bg-warning" v-if="dashboard.pending.length">{{ dashboard.pending.length }}</span>
                        </div>
                        <ul class="list-group list-group-flush" v-if="dashboard.pending.length">
                            <li class="list-group-item" v-for="(item, index) in dashboard.pending" :key="index">
                                <RouterLink :to="item.page" class="d-flex justify-content-between gap-3 text-dark">
                                    <span class="min-w-0">
                                        <span class="badge text-bg-light me-2">{{ item.type }}</span>
                                        <span class="fw-semibold">{{ item.title }}</span>
                                        <small class="d-block text-muted" v-if="item.author">by {{ item.author }}</small>
                                    </span>
                                    <small class="text-muted text-nowrap">{{ formatDate(item.updated_at) }}</small>
                                </RouterLink>
                            </li>
                        </ul>
                        <div class="card-body empty-state" v-else>
                            <i class="iconoir-check-circle"></i>
                            <p class="mb-0">Nothing to review.</p>
                        </div>
                    </div>
                </div>

                <!-- Derniers messages -->
                <div class="col-xl-7 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Latest messages</h5>
                            <RouterLink to="/admins/contact" class="small">See all</RouterLink>
                        </div>
                        <ul class="list-group list-group-flush" v-if="dashboard.contacts.length">
                            <li class="list-group-item" v-for="contact in dashboard.contacts" :key="contact.id">
                                <RouterLink to="/admins/contact" class="d-flex justify-content-between gap-3 text-dark">
                                    <span class="min-w-0">
                                        <span :class="contact.is_read ? '' : 'fw-bold'">{{ contact.name }}</span>
                                        <span class="badge text-bg-primary ms-2" v-if="!contact.is_read">New</span>
                                        <small class="d-block text-muted text-truncate">{{ contact.excerpt }}</small>
                                    </span>
                                    <small class="text-muted text-nowrap">{{ formatDate(contact.created_at) }}</small>
                                </RouterLink>
                            </li>
                        </ul>
                        <div class="card-body empty-state" v-else>
                            <i class="iconoir-mail"></i>
                            <p class="mb-0">No messages yet.</p>
                        </div>
                    </div>
                </div>

                <!-- Prochains événements -->
                <div class="col-xl-5 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Upcoming events</h5>
                            <RouterLink to="/admins/events" class="small">Manage</RouterLink>
                        </div>
                        <ul class="list-group list-group-flush" v-if="dashboard.upcoming_events.length">
                            <li class="list-group-item d-flex gap-3 align-items-center" v-for="event in dashboard.upcoming_events" :key="event.id">
                                <span class="event-date">
                                    <span class="event-day">{{ dayOf(event.start_date) }}</span>
                                    <span class="event-month">{{ monthOf(event.start_date) }}</span>
                                </span>
                                <span class="min-w-0">
                                    <span class="fw-semibold d-block text-truncate">{{ event.title }}</span>
                                    <small class="text-muted">
                                        {{ event.location || 'No location' }}
                                        <span v-if="event.status !== 'published'"> · {{ statusLabels[event.status] }}</span>
                                    </small>
                                </span>
                            </li>
                        </ul>
                        <div class="card-body empty-state" v-else>
                            <i class="iconoir-calendar"></i>
                            <p class="mb-1">No upcoming events.</p>
                            <RouterLink to="/admins/events" class="small">Add an event</RouterLink>
                        </div>
                    </div>
                </div>

            </div>

        </template>

    </div>
  </main>
</template>

<script setup>
  import { computed, onMounted, ref } from 'vue';
  import { RouterLink } from 'vue-router';
  import { getData } from '../../plugin/api';

  const isLoading = ref(true)
  const hasError = ref(false)
  const loadedAt = ref('')
  const dashboard = ref({
    counts: {},
    status: {},
    pending: [],
    contacts: [],
    upcoming_events: [],
  })

  const statusLabels = {
    published: 'Published',
    draft: 'Draft',
    approbation: 'Awaiting approval',
  }

  const plural = (count, word) => `${count} ${word}${count > 1 ? 's' : ''}`

  const tiles = computed(() => {
    const c = dashboard.value.counts
    const s = dashboard.value.status
    const statusDetail = (key) => s[key] ? `${s[key].published} published · ${s[key].draft + s[key].approbation} not published` : ''
    return [
      { label: 'Projects', value: c.projects, detail: statusDetail('projects'), icon: 'iconoir-task-list', to: '/admins/projects' },
      { label: 'Events', value: c.events, detail: statusDetail('events'), icon: 'iconoir-calendar', to: '/admins/events' },
      { label: 'Blog posts', value: c.blogs, detail: statusDetail('blogs'), icon: 'iconoir-page-edit', to: '/admins/blogs' },
      { label: 'Expeditions', value: c.expeditions, icon: 'iconoir-map', to: '/admins/expeditions' },
      { label: 'Fungi Education', value: c.fungi_education, icon: 'iconoir-book', to: '/admins/fungiEducation' },
      { label: 'Gallery photos', value: c.gallery, icon: 'iconoir-media-image-list', to: '/admins/gallery' },
      { label: 'Videos', value: c.videos, icon: 'iconoir-media-video-list', to: '/admins/videos' },
      { label: 'Team', value: c.teams, detail: plural(c.advisors ?? 0, 'advisor'), icon: 'iconoir-group', to: '/admins/team' },
      {
        label: 'Messages',
        value: c.contacts,
        detail: c.unread_contacts ? `${c.unread_contacts} unread` : 'All read',
        icon: 'iconoir-mail',
        to: '/admins/contact',
        alert: c.unread_contacts > 0,
      },
    ]
  })

  const statusRows = computed(() => {
    const s = dashboard.value.status
    return [
      { label: 'Projects', to: '/admins/projects', ...s.projects },
      { label: 'Events', to: '/admins/events', ...s.events },
      { label: 'Blog', to: '/admins/blogs', ...s.blogs },
    ].filter(row => row.published !== undefined)
  })

  const formatDate = (value) => value ? new Date(value).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' }) : ''
  const dayOf = (value) => new Date(value).toLocaleDateString('en-GB', { day: '2-digit' })
  const monthOf = (value) => new Date(value).toLocaleDateString('en-GB', { month: 'short' })

  const loadDashboard = async () => {
    isLoading.value = true
    hasError.value = false
    try {
      const response = await getData('/dashboard')
      dashboard.value = response.data
      loadedAt.value = new Date().toLocaleTimeString('en-GB', { hour: '2-digit', minute: '2-digit' })
    } catch (error) {
      hasError.value = true
    } finally {
      isLoading.value = false
    }
  }

  onMounted(()=>{
    loadDashboard()
  })

</script>

<style scoped>
  .min-w-0{
    min-width: 0;
  }
  .stat-tile{
    text-decoration: none;
    color: inherit;
    border: 1px solid rgba(0, 0, 0, .06);
    transition: box-shadow .2s ease, transform .2s ease;
  }
  .stat-tile:hover{
    box-shadow: 0 6px 18px rgba(0, 0, 0, .08);
    transform: translateY(-2px);
  }
  .stat-icon{
    flex: 0 0 48px;
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    color: #179607;
    background: rgba(23, 150, 7, .1);
  }
  .stat-tile-alert .stat-icon{
    color: #fff;
    background: #179607;
  }
  .stat-label{
    font-size: 13px;
    color: #6c757d;
  }
  .stat-value{
    font-size: 28px;
    font-weight: 700;
    line-height: 1.2;
    color: #212529;
  }
  .stat-detail{
    font-size: 12px;
    color: #6c757d;
  }
  .stat-tile-alert .stat-detail{
    color: #212529;
    font-weight: 600;
  }
  .list-group-item a{
    text-decoration: none;
  }
  .list-group-item:hover{
    background: rgba(0, 0, 0, .02);
  }
  .empty-state{
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    color: #6c757d;
    min-height: 160px;
  }
  .empty-state i{
    font-size: 32px;
    margin-bottom: 8px;
    opacity: .6;
  }
  .event-date{
    flex: 0 0 52px;
    width: 52px;
    height: 52px;
    border-radius: 10px;
    background: rgba(23, 150, 7, .1);
    color: #179607;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    line-height: 1;
  }
  .event-day{
    font-size: 20px;
    font-weight: 700;
  }
  .event-month{
    font-size: 11px;
    text-transform: uppercase;
    margin-top: 2px;
  }
</style>
