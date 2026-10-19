import axiosInstance from './axios';


export function initTinyMCE(el, options) {
    tinymce.init({
        selector: '#' + el,
        menubar: true,
        language: 'fr_FR',
        //content_css: 'document',
        plugins: 'print importcss searchreplace autolink autosave save directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars',
        toolbar: 'undo redo | bold italic underline | link image | forecolor backcolor | alignleft aligncenter alignright alignjustify | fullscreen | lineheight | fontselect fontsizeselect formatselect | numlist bullist | outdent indent | pagebreak | table',
        
        // Les images insérées ou collées sont envoyées au serveur (TinyMCE 5 : success / failure)
        images_upload_handler: function (blobInfo, success, failure, progress) {
            const formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());

            axiosInstance.post('/uploadimgTi', formData, {
                headers: { 'Content-Type': 'multipart/form-data' },
                onUploadProgress: (e) => {
                    if (e.total) progress(Math.round((e.loaded * 100) / e.total));
                }
            })
            .then(res => {
                success(res.data.location);
                // TinyMCE remplace le lien blob: par l'adresse finale sans déclencher "change" :
                // on le déclenche pour que les pages (qui lisent le contenu sur "change") enregistrent la bonne URL
                setTimeout(() => tinymce.activeEditor?.fire('change'), 0);
            })
            .catch(error => {
                const message = error.response?.data?.message ?? error.message;
                failure('Image upload failed: ' + message, { remove: true });
            });
        },

        // Garder les chemins tels quels (/images/...) au lieu de les rendre relatifs à la page d'admin
        relative_urls: false,
        remove_script_host: true,

        automatic_uploads: true,
        file_picker_types: 'image media',
        file_picker_callback: function (cb, value, meta) {
          if (meta.filetype === 'image') {
            const input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            input.onchange = function () {
              const file = this.files[0];
              const reader = new FileReader();
              reader.onload = function () {
                const id = 'blobid' + (new Date()).getTime();
                const blobCache = tinymce.activeEditor.editorUpload.blobCache;
                const base64 = reader.result.split(',')[1];
                const blobInfo = blobCache.create(id, file, base64);
                blobCache.add(blobInfo);
                cb(blobInfo.blobUri(), { title: '/' + file.name });
              };
              reader.readAsDataURL(file);
            };
            input.click();
          }
          if (meta.filetype === 'media') {
            const input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'video/mp4,video/webm,video/quicktime');
            input.onchange = function () {
              const file = this.files[0];
              if (!file) return;
              const editor = tinymce.activeEditor;
              const notification = editor.notificationManager.open({ text: 'Uploading video...', progressBar: true });
              const formData = new FormData();
              formData.append('video', file);
              axiosInstance.post('/uploadvideo', formData, {
                headers: { 'Content-Type': 'multipart/form-data' },
                onUploadProgress: (e) => {
                  if (e.total) notification.progressBar.value(Math.round((e.loaded * 100) / e.total));
                }
              })
              .then(res => {
                notification.close();
                cb(res.data.video_file, { title: file.name });
              })
              .catch(error => {
                notification.close();
                editor.notificationManager.open({ text: 'Video upload failed: ' + (error.response?.data?.message ?? error.message), type: 'error' });
              });
            };
            input.click();
          }
        },
        ...options
    });

    // Prevent Bootstrap dialog from blocking focusin for TinyMCE
    document.addEventListener('focusin', (e) => {
        if (e.target.closest(".tox-tinymce-aux, .moxman-window, .tam-assetmanager-root") !== null) {
            e.stopImmediatePropagation();
        }
    });
}

export function updateTinyMCE(el, content) {
    tinymce.get(el).setContent(content);
}

export function destroyTinyMCE(el) {
    tinymce.get(el).destroy();
}