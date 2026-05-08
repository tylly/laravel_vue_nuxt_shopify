// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: "2025-07-15",
  devtools: { enabled: true },
  tailwindcss: {
    config: {
      theme: {
        extend: {
          // <-- add extend here
          fontFamily: {
            saira: ["Saira", "sans-serif"],
            roboto: ["Roboto", "serif"],
          },
        },
      },
    },
  },
  runtimeConfig: {
    public: {
      apiBase: process.env.API_BASE_URL || "http://localhost:8000",
    },
  },

  modules: ["@nuxtjs/tailwindcss", "@nuxt/fonts", "shadcn-nuxt", "nuxt-auth-sanctum"],
  sanctum: {
    baseUrl: "http://localhost:8000", // Laravel API
    origin: "http://localhost:3000",
  },
  shadcn: {
    /**
     * Prefix for all the imported component.
     * @default "Ui"
     */
    prefix: "",
    /**
     * Directory that the component lives in.
     * Will respect the Nuxt aliases.
     * @link https://nuxt.com/docs/api/nuxt-config#alias
     * @default "@/components/ui"
     */
    componentDir: "@/components/ui",
  },
});
