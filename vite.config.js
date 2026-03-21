import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/books.js',
                'resources/js/borrow-return.js',
                'resources/js/categories.js',
                'resources/js/main-dashboard.js',
                'resources/js/members.js',
            ],
            refresh: true,
        })
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    }

});
