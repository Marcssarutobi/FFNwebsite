// Met en forme le contenu HTML d'un article avant affichage (v-html).
// Un paragraphe qui ne contient que des hashtags (ex. collé depuis LinkedIn)
// devient une rangée d'étiquettes ; les liens http(s) des hashtags sont conservés.
export const formatRichText = (html) => {
    if (!html || typeof DOMParser === 'undefined') return html;

    const doc = new DOMParser().parseFromString(`<div>${html}</div>`, 'text/html');
    const root = doc.body.firstElementChild;

    root.querySelectorAll('p').forEach((p) => {
        const words = p.textContent.trim().split(/\s+/).filter(Boolean);
        if (words.length < 2 || !words.every((w) => /^#[^\s#]+$/.test(w))) return;

        const links = {};
        p.querySelectorAll('a[href]').forEach((a) => {
            const href = a.getAttribute('href');
            if (/^https?:\/\//i.test(href)) links[a.textContent.trim()] = href;
        });

        const tags = doc.createElement('p');
        tags.className = 'ffn-hashtags';
        words.forEach((word) => {
            const tag = doc.createElement(links[word] ? 'a' : 'span');
            tag.className = 'ffn-hashtag';
            tag.textContent = word;
            if (links[word]) {
                tag.href = links[word];
                tag.target = '_blank';
                tag.rel = 'noopener';
            }
            tags.appendChild(tag);
        });
        p.replaceWith(tags);
    });

    return root.innerHTML;
}
