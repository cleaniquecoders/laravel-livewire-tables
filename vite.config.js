import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

// Builds the workbench (dev-harness) assets into workbench/public/build,
// which Testbench publishes to the served public dir via the asset-publish
// build step. This is dev-tooling only — it does not ship with the package.
export default defineConfig({
    plugins: [
        laravel({
            input: [
                'workbench/resources/css/app.css',
                // Tailwind-only bundle (no Flux) for the isolated Tailwind theme demo.
                'workbench/resources/css/app-tailwind.css',
                'workbench/resources/js/app.js',
            ],
            publicDirectory: 'workbench/public',
            refresh: false,
        }),
        tailwindcss(),
    ],
});
