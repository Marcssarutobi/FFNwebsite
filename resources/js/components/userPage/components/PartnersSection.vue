<template>
    <!--Partners Section-->
    <section class="ffn-partners">
        <div class="auto-container">
            <div class="sec-title text-center">
                <h2>Our <span class="normal-font theme_color">Partners</span> &amp; Supporters</h2>
                <div class="text">Institutions and organisations that support our research, education and conservation work.</div>
            </div>

            <ul class="ffn-partners-grid">
                <li v-for="partner in partners" :key="partner.logo">
                    <component :is="partner.url ? 'a' : 'div'" class="ffn-partner" :href="partner.url || undefined" :target="partner.url ? '_blank' : undefined" :rel="partner.url ? 'noopener' : undefined" :title="partner.name">
                        <img :src="partner.logo" :alt="partner.name" loading="lazy">
                    </component>
                </li>
            </ul>
        </div>
    </section>
</template>

<script setup>
    // Logos des partenaires (renseigner url pour rendre un logo cliquable)
    const partners = [
        { name: 'The Rufford Foundation', logo: '/assets/images/clients/01.png', url: '' },
        { name: 'SPUN – Society for the Protection of Underground Networks', logo: '/assets/images/clients/03.jpg', url: '' },
        { name: 'Université de Parakou', logo: '/assets/images/clients/04.jpg', url: '' },
        { name: 'MyTIPS – Tropical Mycology and Plants-Soil Fungi Interactions', logo: '/assets/images/clients/05.jpg', url: '' },
        { name: 'British Ecological Society', logo: '/assets/images/clients/06.png', url: '' },
        { name: 'Society for Molecular Biology & Evolution', logo: '/assets/images/clients/07.jpeg', url: '' },
        { name: 'CEBioS', logo: '/assets/images/clients/image001.jpg', url: '' },
        { name: 'Museum', logo: '/assets/images/clients/image003.png', url: '' },
        { name: 'MOPGA', logo: '/assets/images/clients/mopga.jpg', url: '' },
        { name: 'Partner', logo: '/assets/images/clients/WhatsApp.jpeg', url: '' },
    ];
</script>

<style scoped>
.ffn-partners{
    padding: 80px 0 70px;
    background: #f7f9f6;
}
.ffn-partners .sec-title{
    margin-bottom: 40px;
}
.ffn-partners-grid{
    list-style: none;
    margin: 0;
    padding: 0;
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 20px;
}
.ffn-partner{
    display: flex;
    align-items: center;
    justify-content: center;
    height: 120px;
    padding: 20px;
    background: #fff;
    border: 1px solid #e6ebe4;
    border-radius: 8px;
    transition: box-shadow .3s ease, transform .3s ease;
}
.ffn-partner img{
    max-width: 100%;
    max-height: 64px;
    width: auto;
    height: auto;
    object-fit: contain;
    filter: grayscale(100%);
    opacity: .75;
    transition: filter .3s ease, opacity .3s ease;
}
.ffn-partner:hover{
    box-shadow: 0 8px 20px rgba(0, 0, 0, .08);
    transform: translateY(-3px);
}
.ffn-partner:hover img{
    filter: none;
    opacity: 1;
}
@media (max-width: 991px){
    .ffn-partners-grid{
        grid-template-columns: repeat(3, 1fr);
    }
}
@media (max-width: 575px){
    .ffn-partners{
        padding: 60px 0 50px;
    }
    .ffn-partners-grid{
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }
    .ffn-partner{
        height: 96px;
        padding: 14px;
    }
}
</style>
