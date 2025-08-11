import { defineConfig } from "vite";

export default defineConfig({
  root: ".",
  base: "",
  build: { 
    outDir: "dist", 
    emptyOutDir: true,
    rollupOptions: {
      input: "src/main.js"
    }
  },
  css: {
    postcss: false
  }
});