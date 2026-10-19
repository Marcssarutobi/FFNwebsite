// Convertit un lien YouTube / Vimeo en URL intégrable dans une iframe.
// Retourne null si le lien n'est pas reconnu.
export const getEmbedUrl = (url) => {
    if (!url) return null;

    const youtube = url.match(/(?:youtube\.com\/(?:watch\?(?:.*&)?v=|embed\/|shorts\/|live\/)|youtu\.be\/)([\w-]{11})/);
    if (youtube) {
        return `https://www.youtube.com/embed/${youtube[1]}`;
    }

    const vimeo = url.match(/vimeo\.com\/(?:video\/)?(\d+)/);
    if (vimeo) {
        return `https://player.vimeo.com/video/${vimeo[1]}`;
    }

    return null;
}
