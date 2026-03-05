import { defineConfig } from 'vite';
import { resolve } from 'path';

export default defineConfig({
    // Disable Vite's default publicDir copy — we manage public/assets/ ourselves
    publicDir: false,

    build: {
        // Vite output goes to public/build/ (correct for both XAMPP and Hostinger)
        outDir:     'public/build',
        emptyOutDir: true,
        rollupOptions: {
            input: {
                app: resolve(__dirname, 'resources/js/app.js'),
            },
        },
        manifest: true,
    },
    // Dev server proxies PHP via XAMPP
    server: {
        port: 3000,
    },
});
