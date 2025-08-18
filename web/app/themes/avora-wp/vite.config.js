import { defineConfig } from "vite";

export default defineConfig({
  root: ".",
  base: "",
  build: { 
    outDir: "dist", 
    emptyOutDir: true,
    minify: 'terser',
    rollupOptions: {
      input: "src/main.js",
      output: {
        manualChunks: undefined,
        assetFileNames: 'assets/[name].[hash][extname]',
        chunkFileNames: 'assets/[name].[hash].js',
        entryFileNames: 'assets/[name].[hash].js',
      }
    }
  },
  css: {
    postcss: false
  }
});