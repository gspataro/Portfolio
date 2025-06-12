import { defineConfig } from "vite";
import * as path from 'path';
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    base: '/assets/',
    build: {
        outDir: path.resolve(__dirname, 'output/assets'),
        emptyOutDir: true,
        manifest: true,
        rollupOptions: {
            input: [
                path.resolve(__dirname, 'contents/view/assets/css/ui.css'),
                path.resolve(__dirname, 'contents/view/assets/js/main.js')
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
