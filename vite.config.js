import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/js/app_admin.js'],
            refresh: true,
        }),
        vue({
            template:{
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            }
        })
    ],
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
            '@': '/resources/js',
            '/admin/assets':'/public/admin/assets',
            '/assets':'/public/assets',
            '@components': '/resources/js/components',
        },
    },
});
