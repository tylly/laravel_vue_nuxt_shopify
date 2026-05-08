// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: '2025-07-15',
  devtools: { enabled: true },
  tailwindcss: {
  config: {
    theme: {
      extend: {          // <-- add extend here
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
      apiBase: process.env.API_BASE_URL || 'http://localhost:3000'
    }
  },

  modules: ['@nuxtjs/tailwindcss', '@nuxt/fonts']
})