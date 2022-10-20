import { defineConfig } from 'vite';
import { viteStaticCopy } from 'vite-plugin-static-copy'

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
                // 'app/**/*.php',
                // 'config/**',
                'public/**/images/*.*',
                'resources/**/views/**',
                'lang/**'
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
        viteStaticCopy({
            targets: [
                {
                    src: 'resources/admin/images/**/*.*',
                    dest: 'public/assets/admin/images/',
                },
                {
                    src: 'resources/front/assets/images/**/*.*',
                    dest: 'public/front/assets/images/',
                }
            ]
        })
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
