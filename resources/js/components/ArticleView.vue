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
      let content = this.content
      
      // Remplacer les variables en préservant les styles HTML
      if (this.user) {
        // Remplacer {{nom_utilisateur}} en gardant les styles
        content = content.replace(
          /{{nom_utilisateur}}/g, 
          `<span style="color: #2563eb; font-weight: 600;">${this.user.name}</span>`
        )
      } else {
        content = content.replace(
          /{{nom_utilisateur}}/g, 
          `<span style="color: #2563eb; font-weight: 600;">Visiteur</span>`
        )
      }
      
      // Remplacer {{date_lecture}} en gardant les styles
      const currentDate = new Date().toLocaleDateString('fr-FR')
      content = content.replace(
        /{{date_lecture}}/g, 
        `<span style="color: #2563eb; font-weight: 600;">${currentDate}</span>`
      )
      
      return content
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

<style scoped>
/* Styles pour les titres générés par Quill */
.prose h1,
.prose .ql-header-1 {
  font-size: 1.875rem !important; /* 30px */
  font-weight: 700 !important;
  color: #111827 !important;
  margin-top: 2rem !important;
  margin-bottom: 1rem !important;
  line-height: 1.2 !important;
}

.prose h2,
.prose .ql-header-2 {
  font-size: 1.5rem !important; /* 24px */
  font-weight: 700 !important;
  color: #1f2937 !important;
  margin-top: 1.5rem !important;
  margin-bottom: 0.75rem !important;
  line-height: 1.3 !important;
}

.prose h3,
.prose .ql-header-3 {
  font-size: 1.25rem !important; /* 20px */
  font-weight: 700 !important;
  color: #374151 !important;
  margin-top: 1rem !important;
  margin-bottom: 0.5rem !important;
  line-height: 1.4 !important;
}

/* Styles pour les éléments Quill spécifiques */
.prose p {
  margin-bottom: 1rem;
  color: #374151;
  line-height: 1.6;
}

.prose strong {
  font-weight: 700;
  color: #111827;
}

.prose em {
  font-style: italic;
}

.prose ul {
  list-style-type: disc;
  list-style-position: inside;
  margin-bottom: 1rem;
}

.prose ol {
  list-style-type: decimal;
  list-style-position: inside;
  margin-bottom: 1rem;
}

.prose li {
  margin-bottom: 0.25rem;
}

/* Styles globaux pour tous les éléments dans le contenu */
.prose * {
  max-width: 100%;
}

/* Forcer les styles des titres même avec les classes Quill */
:deep(.ql-editor h1),
:deep(.ql-editor h2),
:deep(.ql-editor h3),
:deep(h1),
:deep(h2),
:deep(h3) {
  font-weight: 700 !important;

}

:deep(.ql-editor h1),
:deep(h1) {
  font-size: 1.875rem !important;
  margin-top: 2rem !important;
  margin-bottom: 1rem !important;
}

:deep(.ql-editor h2),
:deep(h2) {
  font-size: 1.5rem !important;
  margin-top: 1.5rem !important;
  margin-bottom: 0.75rem !important;
}

:deep(.ql-editor h3),
:deep(h3) {
  font-size: 1.25rem !important;
  margin-top: 1rem !important;
  margin-bottom: 0.5rem !important;
}
</style>