<template>
  <div class="bg-white rounded-xl shadow-xl overflow-hidden">
    <!-- En-tête de l'article -->
    <div class="bg-gradient-to-r from-[#1E40AF] to-[#3B82F6] text-white p-8">
      <div class="flex items-center justify-between mb-6">
        <div class="flex items-center space-x-4">
          <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center text-white font-bold text-lg">
            {{ article.user.name.charAt(0).toUpperCase() }}
          </div>
          <div>
            <p class="font-semibold">{{ article.user.name }}</p>
            <p class="text-blue-100 text-sm">{{ formatDate(article.published_at) }}</p>
          </div>
        </div>
        
        <div v-if="canEdit" class="flex space-x-2">
          <a :href="`/articles/${article.id}/edit`" 
             class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-300">
            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            Modifier
          </a>
          
          <button @click="deleteArticle"
                  class="bg-red-500/20 hover:bg-red-500/30 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-300">
            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
            Supprimer
          </button>
        </div>
      </div>
      
      <h1 class="text-4xl font-bold mb-4">{{ article.title }}</h1>
    </div>

    <!-- Contenu de l'article -->
    <div class="p-8">
      <div class="prose prose-lg max-w-none" v-html="formattedContent"></div>
    </div>

    <!-- Navigation -->
    <div class="bg-gray-50 px-8 py-6 border-t">
      <div class="flex justify-between items-center">
        <a href="/" 
           class="inline-flex items-center text-[#D4B896] hover:text-[#C4A886] font-semibold transition-colors duration-300">
          <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
          </svg>
          Retour aux articles
        </a>
        
        <div class="text-sm text-gray-500">
          Article publié le {{ formatDate(article.published_at) }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'ArticleView',
  props: {
    article: {
      type: Object,
      required: true
    },
    content: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      user: null
    }
  },
  computed: {
    canEdit() {
      return this.user && 
             this.user.roles && 
             this.user.roles.some(role => role.name === 'redacteur') &&
             this.user.id === this.article.user_id
    },
    formattedContent() {
      // Convertir les retours à la ligne en paragraphes
      return this.content
        .split('\n\n')
        .map(paragraph => `<p class="mb-4">${paragraph.replace(/\n/g, '<br>')}</p>`)
        .join('')
    }
  },
  async mounted() {
    await this.checkAuth()
  },
  methods: {
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
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      })
    }, 
    async deleteArticle() {
      if (!confirm('Êtes-vous sûr de vouloir supprimer cet article ?')) {
        return
      }
      
      try {
        const response = await axios.delete(`/articles/${this.article.id}`)
        if (response.data.success) {
          alert('Article supprimé avec succès!')
          window.location.href = '/'
        }
      } catch (error) {
        console.error('Erreur lors de la suppression:', error)
        alert('Erreur lors de la suppression de l\'article')
      }
    }
  }
}
</script>