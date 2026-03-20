import { defineConfig } from "vite";
import * as path from 'path';
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    base: '/assets/',
    build: {
        outDir: path.resolve(__dirname, 'assets'),
        emptyOutDir: true,
        manifest: true,
        rollupOptions: {
            input: [
                path.resolve(__dirname, '/src/css/app.css'),
                path.resolve(__dirname, '/src/js/app.js')
            ],
            output: {
                entryFileNames: `[name]-[hash].js`,
                chunkFileNames: `[name]-[hash].js`,
                assetFileNames: `[name]-[hash].[ext]`,
            }
        }
    },
    plugins: [
        tailwindcss()
    ]
});
