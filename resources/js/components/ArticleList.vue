<template>
  <div class="space-y-8">
    <!-- En-tête -->
    <div class="text-center">
      <h1 class="text-4xl font-bold text-[#1E40AF] mb-4">Blog Platform</h1>
      <p class="text-gray-600 text-lg">Découvrez nos derniers articles</p>
    </div>

    <!-- Bouton créer un article (si rédacteur) -->
    <div v-if="canCreateArticle" class="flex justify-end">
      <a href="/articles/create" 
         class="bg-gradient-to-r from-[#1E40AF] to-[#3B82F6] text-white px-6 py-3 rounded-lg font-semibold hover:from-[#1D4ED8] hover:to-[#2563EB] transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-[1.02]">
        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Créer un article
      </a>
    </div>

    <!-- Liste des articles -->
    <div v-if="loading" class="text-center py-12">
      <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-[#1E40AF]"></div>
      <p class="mt-4 text-gray-600">Chargement des articles...</p>
    </div>

    <div v-else-if="articles.length === 0" class="text-center py-12">
      <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
      </svg>
      <h3 class="mt-4 text-lg font-medium text-gray-900">Aucun article</h3>
      <p class="mt-2 text-gray-500">Aucun article n'a encore été publié.</p>
    </div>

    <div v-else class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
      <article v-for="article in articles" :key="article.id" 
               class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-[#D4B896]">
        <div class="p-6">
          <div class="flex items-center justify-between mb-4">
            <div class="flex items-center space-x-3">
              <div class="w-10 h-10 bg-gradient-to-r from-[#1E40AF] to-[#3B82F6] rounded-full flex items-center justify-center text-white font-semibold">
                {{ article.user.name.charAt(0).toUpperCase() }}
              </div>
              <div>
                <p class="font-medium text-gray-900">{{ article.user.name }}</p>
                <p class="text-sm text-gray-500">{{ formatDate(article.published_at) }}</p>
              </div>
            </div>
          </div>
          
          <h2 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2">{{ article.title }}</h2>
          <p class="text-gray-600 mb-4 line-clamp-3">{{ getExcerpt(article.content) }}</p>
          
          <a :href="`/articles/${article.id}`" 
             class="inline-flex items-center text-[#D4B896] hover:text-[#C4A886] font-semibold transition-colors duration-300">
            Lire la suite
            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
          </a>
        </div>
      </article>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'ArticleList',
  data() {
    return {
      articles: [],
      loading: true,
      user: null
    }
  },
  computed: {
    canCreateArticle() {
      return this.user && this.user.roles && this.user.roles.some(role => role.name === 'redacteur')
    }
  },
  async mounted() {
    await this.loadArticles()
    await this.checkAuth()
  },
  methods: {
    async loadArticles() {
      try {
        const response = await axios.get('/api/articles')
        this.articles = response.data.data
      } catch (error) {
        console.error('Erreur lors du chargement des articles:', error)
      } finally {
        this.loading = false
      }
    },
    async checkAuth() {
      try {
        const response = await axios.get('/api/user')
        this.user = response.data.user
      } catch (error) {
        // Utilisateur non connecté
      }
    },
    formatDate(date) {
      return new Date(date).toLocaleDateString('fr-FR', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      })
    },
    getExcerpt(content) {
      const text = content.replace(/<[^>]*>/g, '')
      return text.length > 150 ? text.substring(0, 150) + '...' : text
    }
  }
}
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>