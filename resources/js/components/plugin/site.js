// Paramètres du site (modifiables dans l'admin « Site settings »), chargés une seule fois depuis l'API.
// Les valeurs ci-dessous servent tant que l'API n'a pas répondu, ou si elle est indisponible.
import { computed, reactive } from 'vue'
import axiosInstance from './axios'

export const siteSettings = reactive({
    contact_email: 'contact@fungifornature.com',
    contact_phone: '(+229) 0196975772',
    contact_address: 'Parakou, Bénin',
    social_facebook: '',
    social_x: '',
    social_instagram: '',
    social_linkedin: '',
    facts_title: 'We’re proud of the impact Fungi For Nature is making in preserving fungal biodiversity and promoting ecological sustainability',
    facts_text: 'Since its creation, Fungi For Nature has worked tirelessly to raise awareness about the ecological importance of fungi. Through education, research, and conservation, we are making an impact.',
    ceo_message: 'At Fungi For Nature, we believe fungi are not just organisms, but vital allies in restoring ecological balance. Our mission is to protect and promote fungal biodiversity, empower communities, and drive sustainable innovation through nature. Together, we can transform how we see and care for the world beneath our feet',
    ceo_name: 'Boris Armel Olou',
    ceo_role: 'CEO of Fungi For Nature',
    ceo_photo: '/assets/images/resource/Boris-Olou-ID-Photo.jpg',
    parallax_image: '/assets/images/parallax/ffn-parallax.jpg',
    parallax_title_start: 'Every',
    parallax_title_highlight: 'mushroom',
    parallax_title_end: 'matters',
    parallax_text: 'Help us document, protect and promote mushrooms for the next generation.',
})

let loading = null

export const loadSettings = (force = false) => {
    if (!loading || force) {
        loading = axiosInstance.get('/settings')
            .then(res => {
                Object.entries(res.data.settings || {}).forEach(([key, value]) => {
                    if (key in siteSettings) siteSettings[key] = value ?? ''
                })
            })
            .catch(() => { loading = null })
    }
    return loading
}

export const contactInfo = computed(() => ({
    email: siteSettings.contact_email,
    phoneDisplay: siteSettings.contact_phone,
    // « (+229) 0196975772 » -> « tel:+2290196975772 »
    phoneLink: 'tel:' + (siteSettings.contact_phone || '').replace(/[^\d+]/g, ''),
    address: siteSettings.contact_address,
}))

// Un réseau sans adresse n'est pas affiché
export const socialLinks = computed(() => [
    { name: 'Facebook', url: siteSettings.social_facebook, css: 'facebook', icon: 'fa-brands fa-facebook-f' },
    { name: 'X', url: siteSettings.social_x, css: 'twitter', icon: 'fa-brands fa-x-twitter' },
    { name: 'Instagram', url: siteSettings.social_instagram, css: 'google-plus', icon: 'fa-brands fa-instagram' },
    { name: 'LinkedIn', url: siteSettings.social_linkedin, css: 'linkedin', icon: 'fa-brands fa-linkedin' },
].filter(link => link.url))
