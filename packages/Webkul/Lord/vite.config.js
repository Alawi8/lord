import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';
import { resolve } from 'path';

export default defineConfig(({ command, mode }) => {
    const env = loadEnv(mode, process.cwd(), '');
    
    return {
        build: {
            emptyOutDir: true,
        },

        envPrefix: 'VITE_',

        server: {
            host: env.VITE_HOST || 'localhost',
            port: env.VITE_PORT || 5173,
        },

        plugins: [
            laravel({
                hotFile: 'lord-vite.hot',
                publicDirectory: 'public',
                buildDirectory: 'themes/shop/lord/build',
                input: [
                    'packages/Webkul/Lord/src/Resources/assets/css/app.css',
                    'packages/Webkul/Lord/src/Resources/assets/js/app.js'
                ],
                refresh: true,
            }),
        ],

        resolve: {
            alias: {
                '@': resolve(__dirname, 'packages/Webkul/Lord/src/Resources/assets'),
            },
        },
    };
});