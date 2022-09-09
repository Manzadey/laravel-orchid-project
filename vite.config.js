import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel([
            'resources/platform/css/platform.main.css',
            'resources/web/js/app.js',
            'resources/platform/js/app.js'
        ]),
    ],
});
