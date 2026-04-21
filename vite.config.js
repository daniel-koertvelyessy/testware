import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import { viteStaticCopy } from "vite-plugin-static-copy";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/sass/app.scss",
                "resources/js/app.js",
                "resources/js/main.js",
            ],
            refresh: true,
        }),
        viteStaticCopy({
            targets: [
                {
                    src: "node_modules/@fortawesome/fontawesome-free/webfonts/*",
                    dest: "webfonts"
                }
            ]
        })
    ],
    optimizeDeps: {
        include: ["jquery"]
    },
    define: {
        global: "window"
    },
    server: {
        proxy: {
            "/fonts": {
                target: "http://127.0.0.1:8000",
                changeOrigin: true,
            }
        }
    },
    build: {
        rollupOptions: {
            external: ["jquery", "bootstrap", "popper.js"],
        }
    },
    css: {
        preprocessorOptions: {
            scss: {
                silenceDeprecations: ["import", "global-builtin", "if-function"]
            }
        }
    }
});

