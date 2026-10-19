<template>
    <div class="post-share-options clearfix">
        <div class="pull-left tags"><strong>Share this post</strong> : </div>
        <div class="pull-right social-links-two clearfix">
            <a v-for="link in links" :key="link.name" :href="link.href" :class="link.css + ' img-circle'" target="_blank" rel="noopener" :title="'Share on ' + link.name" :aria-label="'Share on ' + link.name">
                <span :class="link.icon"></span>
            </a>
        </div>
    </div>
</template>

<script setup>
    import { computed } from 'vue';
    import { useRoute } from 'vue-router';

    const props = defineProps({
        title: { type: String, default: '' },
    })

    const route = useRoute()

    // Liens de partage vers l'adresse publique de la page en cours
    const links = computed(() => {
        const url = encodeURIComponent(window.location.origin + route.fullPath)
        const text = encodeURIComponent(props.title || 'Fungi For Nature')
        return [
            { name: 'Facebook', css: 'facebook', icon: 'fa-brands fa-facebook-f', href: `https://www.facebook.com/sharer/sharer.php?u=${url}` },
            { name: 'X', css: 'twitter', icon: 'fa-brands fa-x-twitter', href: `https://twitter.com/intent/tweet?url=${url}&text=${text}` },
            { name: 'LinkedIn', css: 'linkedin', icon: 'fa-brands fa-linkedin', href: `https://www.linkedin.com/sharing/share-offsite/?url=${url}` },
            { name: 'WhatsApp', css: 'google-plus', icon: 'fa-brands fa-whatsapp', href: `https://wa.me/?text=${text}%20${url}` },
        ]
    })
</script>
