import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            fonts: [
                bunny('Public Sans', {
                    weights: [400, 500, 600, 700],
                }),
                bunny('Inter', {
                    weights: [300, 400, 500, 600],
                }),
            ],
        }),
        tailwindcss(),
    ],
    server: {
        host: '0.0.0.0',
        origin: 'http://localhost:5173',
        cors: true,
        watch: {
            ignored: ['**/storage/framework/views/**', '**/.claude/**'],
        },
    },
});
