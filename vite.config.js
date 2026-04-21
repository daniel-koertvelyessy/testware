import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
            publicDirectory: 'public',
        }),
    ],
    server: {
        proxy: {
            '/fonts': {
                target: 'http://127.0.0.1:8000',
                changeOrigin: true,
            }
        }
    },
    css: {
        preprocessorOptions: {
            scss: {
                silenceDeprecations: ['import', 'global-builtin', 'if-function']
            }
        }
    }
});