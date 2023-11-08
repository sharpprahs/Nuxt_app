// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  pages: true,
  css: ['~/assets/css/style.css'],
  devtools: { enabled: true },
  app: {
    head: {
      meta: [
        { name: 'robots', content: 'noindex, nofollow' }
      ]
    }
  }
})
