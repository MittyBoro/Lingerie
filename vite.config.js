import { defineConfig } from 'vite';

import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        require('autoprefixer'),
        require('tailwindcss'),
        laravel({
            input: [
                'resources/admin/js/app.js',
                'resources/front/sass/style.sass',
                'resources/front/js/app.js',
                'resources/front/js/cart.js',
                'resources/front/js/catalog.js',
                'resources/front/js/checkout.js',
                'resources/front/js/home.js',
                'resources/front/js/product.js',
            ],
            refresh: true,
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
    server: {
        hmr: {
            host: 'localhost',
        },
    },
    resolve: {
        alias: {
            '@': '/resources/admin/js',
            '~': '/resources/js',
            ziggy: '/vendor/tightenco/ziggy/dist/vue.m',
        },
        extensions: ['.mjs', '.js', '.ts', '.jsx', '.tsx', '.json', '.vue']
    },
});
