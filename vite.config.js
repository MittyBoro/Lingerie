import { defineConfig } from 'vite';

import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';


export default defineConfig({
    plugins: [
        // require('autoprefixer'),
        // require('tailwindcss'),
        laravel({
            input: [
                'resources/admin/js/app.js',

                // 'resources/assets/js/app.js',
                // 'resources/assets/js/gallery.js',
                // 'resources/assets/sass/style.sass',
            ],
            refresh: [
                'app/View/Components/**',
                'lang/**',
                'resources/**/views/**',
                'routes/**',
            ],
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],

    resolve: {
        alias: {
            '@': '/resources/admin/js',
            '~': '/resources/js',
            ziggy: '/vendor/tightenco/ziggy/dist/vue.m',
        },
        extensions: ['.mjs', '.js', '.ts', '.jsx', '.tsx', '.json', '.vue']
    },
});
