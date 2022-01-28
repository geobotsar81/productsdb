require("./bootstrap");

//Import Bootsraip 5 library
import "bootstrap";

import { createApp, h } from "vue";
import { App as InertiaApp, plugin as InertiaPlugin } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";

//Import Sentry
import * as Sentry from "@sentry/vue";
import { Integrations } from "@sentry/tracing";

//Initiate Progress Bar
InertiaProgress.init({
    delay: 0,
    color: "#b40900",
    includeCSS: true,
    showSpinner: true,
});

const el = document.getElementById("app");

const app = createApp({
    render: () =>
        h(InertiaApp, {
            initialPage: JSON.parse(el.dataset.page),
            resolveComponent: (name) => require(`./Pages/${name}`).default,
        }),
})
    .mixin({ methods: { route } })
    .use(InertiaPlugin);

Sentry.init({
    app,
    dsn: "https://ed84bb6e58c5409699f58c3d38f5e85b@o1128328.ingest.sentry.io/6172121",
    integrations: [new Integrations.BrowserTracing()],
    // Set tracesSampleRate to 1.0 to capture 100%
    // of transactions for performance monitoring.
    // We recommend adjusting this value in production
    tracesSampleRate: 1.0,
});

app.mount(el);
