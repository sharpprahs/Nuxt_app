// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  pages: true,
  css: ['~/assets/css/style.css'],
  devtools: { enabled: true },
  modules: ['@pinia/nuxt'],
  proxy: {
    '/api': {
      target: 'http://localhost:8000',
      pathRewrite: { '^/api': '' }
    }
  },
  app: {
    head: {
      meta: [
        { name: 'robots', content: 'noindex, nofollow' }
      ]
    }
  }
})
