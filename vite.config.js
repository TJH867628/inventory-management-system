import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
      // Explicitly set the manifest path to the public directory
      manifest: 'public/manifest.json',
      // Ensure build output is in the correct location
      buildDirectory: 'build'
    }),
    vue(),
  ],
  build: {
    // Explicitly set the output directory
    outDir: 'public/build',
    // Ensure manifest is generated in the correct location
    manifest: true,
  }
});