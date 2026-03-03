// resources/js/app.ts
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';
import '../css/app.css';
import { initializeTheme } from './composables/useAppearance';

// --- Ziggy imports ---
import { ZiggyVue } from 'ziggy-js';
import { Ziggy } from './ziggy'; // make sure you ran `php artisan ziggy:generate resources/js/ziggy.ts`
declare global {
    interface Window {
        Pusher: any;
        Echo: any;
    }
}
// --- Reverb / Echo setup ---
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;
window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY?.replace(/"/g, '') || 'local',
    wsHost: import.meta.env.VITE_REVERB_HOST?.replace(/"/g, '') || '127.0.0.1',
    wsPort: parseInt(import.meta.env.VITE_REVERB_PORT || '8080'),
    wssPort: parseInt(import.meta.env.VITE_REVERB_PORT || '8080'),
    forceTLS: import.meta.env.VITE_REVERB_SCHEME === 'https',
    enabledTransports: ['ws', 'wss'],
});
// --- Inertia App ---
const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: (name) =>
        resolvePageComponent(
            `./pages/${name}.vue`,
            import.meta.glob<DefineComponent>('./pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .mount(el);
    },
    progress: { color: 'none' },
});

// Set light / dark mode on page load
initializeTheme();
