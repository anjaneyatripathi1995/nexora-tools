import { defineConfig } from 'vite';
import { resolve } from 'path';

export default defineConfig({
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
