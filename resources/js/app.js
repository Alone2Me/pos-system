import "./bootstrap";
import "../css/app.css";
import "@/assets/styles.scss";

import {
    createApp,
    h,
} from "vue";

import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import PrimeVue from "primevue/config";
import ConfirmationService from "primevue/confirmationservice";
import ToastService from "primevue/toastservice";

import { createInertiaApp } from "@inertiajs/vue3";
import Aura from "@primevue/themes/aura";

import { ZiggyVue } from "../../vendor/tightenco/ziggy";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(PrimeVue, {
                theme: {
                    preset: Aura,
                    options: {
                        darkModeSelector: ".app-dark",
                    },
                },
            })
            .use(ToastService)
            .use(ConfirmationService)
            .mount(el);
    },
    progress: {
        color: "#4B5563",
    },
});
