// Coordonnées et réseaux sociaux de Fungi For Nature, utilisés dans l'en-tête et le pied de page.
// Un réseau sans adresse n'est pas affiché : renseigner l'URL complète pour le faire apparaître.
export const contactInfo = {
    email: 'contact@fungifornature.com',
    phoneDisplay: '(+229) 0196975772',
    phoneLink: 'tel:+2290196975772',
    address: 'Parakou, Bénin',
}

export const socialLinks = [
    { name: 'Facebook', url: '', css: 'facebook', icon: 'fa-brands fa-facebook-f' },
    { name: 'X', url: '', css: 'twitter', icon: 'fa-brands fa-x-twitter' },
    { name: 'Instagram', url: '', css: 'google-plus', icon: 'fa-brands fa-instagram' },
    { name: 'LinkedIn', url: '', css: 'linkedin', icon: 'fa-brands fa-linkedin' },
].filter(link => link.url)
