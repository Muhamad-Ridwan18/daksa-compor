import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    build: {
        rollupOptions: {
            output: {
                manualChunks: {
                    'vendor': ['alpinejs'],
                    'animate': ['animate.css'],
                },
            },
        },
        cssCodeSplit: true,
        minify: 'esbuild', // Using esbuild (default) - faster than terser
        chunkSizeWarningLimit: 1000,
    },
});
