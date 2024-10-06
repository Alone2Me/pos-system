import laravel from "laravel-vite-plugin";
import Components from "unplugin-vue-components/vite";
import { defineConfig } from "vite";

import { PrimeVueResolver } from "@primevue/auto-import-resolver";
import vue from "@vitejs/plugin-vue";

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            ssr: 'resources/js/ssr.js',
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
        Components({
            resolvers: [PrimeVueResolver()]
        }),
    ],
});
