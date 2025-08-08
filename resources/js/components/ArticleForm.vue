<template>
  <div class="bg-white rounded-xl shadow-xl p-8">
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-[#1E40AF] mb-2">{{ isEdit ? 'Modifier l\'article' : 'Créer un nouvel article' }}</h1>
      <p class="text-gray-600">{{ isEdit ? 'Modifiez votre article' : 'Rédigez votre article avec l\'éditeur' }}</p>
    </div>

    <form @submit.prevent="submitForm" class="space-y-6">
      <!-- Titre -->
      <div>
        <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Titre de l'article</label>
        <input 
          type="text" 
          id="title" 
          v-model="form.title" 
          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D4B896] focus:border-[#D4B896] transition-all duration-300"
          placeholder="Entrez le titre de votre article"
          required
        >
      </div>

      <!-- Contenu -->
      <div>
        <label for="content" class="block text-sm font-semibold text-gray-700 mb-2">Contenu</label>
        <wysiwyg-editor 
          v-model="form.content"
          class="border border-gray-300 rounded-lg focus-within:ring-2 focus-within:ring-[#D4B896] focus-within:border-[#D4B896] transition-all duration-300"
        />
        <p class="mt-2 text-sm text-gray-500">
          💡 Astuce : Utilisez le bouton "Variables" pour insérer <code class="bg-gray-100 px-1 rounded">{{nom_utilisateur}}</code> et <code class="bg-gray-100 px-1 rounded">{{date_lecture}}</code>
        </p>
      </div>

      <!-- Messages d'erreur -->
      <div v-if="error" class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
        {{ error }}
      </div>

      <!-- Boutons -->
      <div class="flex space-x-4">
        <button 
          type="submit" 
          :disabled="loading"
          class="flex-1 bg-gradient-to-r from-[#1E40AF] to-[#3B82F6] text-white py-3 px-6 rounded-lg font-semibold hover:from-[#1D4ED8] hover:to-[#2563EB] transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
        >
          <span v-if="loading" class="flex items-center justify-center">
            <svg class="animate-spin h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            {{ isEdit ? 'Modification...' : 'Création...' }}
          </span>
          <span v-else>
            {{ isEdit ? 'Modifier l\'article' : 'Créer l\'article' }}
          </span>
        </button>
        
        <a href="/" 
           class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition-colors duration-300">
          Annuler
        </a>
      </div>
    </form>
  </div>
</template>

<script>
import axios from 'axios'
import WysiwygEditor from './WysiwygEditor.vue'

export default {
  name: 'ArticleForm',
  components: {
    WysiwygEditor
  },
  props: {
    article: {
      type: Object,
      default: null
    }
  },
  data() {
    return {
      form: {
        title: '',
        content: ''
      },
      loading: false,
      error: null,
      // Ajouter les variables pour éviter les erreurs Vue
      nom_utilisateur: '{{nom_utilisateur}}',
      date_lecture: '{{date_lecture}}'
    }
  },
  computed: {
    isEdit() {
      return !!this.article
    }
  },
  mounted() {
    if (this.article) {
      this.form.title = this.article.title
      this.form.content = this.article.content
      // Ligne publish supprimée
    }
  },
  methods: {
    async submitForm() {
      this.loading = true
      this.error = null
      
      try {
        let response
        if (this.isEdit) {
          response = await axios.put(`/articles/${this.article.id}`, this.form)
        } else {
          response = await axios.post('/articles', this.form)
        }
        
        if (response.data.success) {
          window.location.href = response.data.redirect
        }
      } catch (error) {
        if (error.response && error.response.data.errors) {
          const errors = Object.values(error.response.data.errors).flat()
          this.error = errors.join(', ')
        } else if (error.response && error.response.data.message) {
          this.error = error.response.data.message
        } else {
          this.error = 'Une erreur est survenue'
        }
      } finally {
        this.loading = false
      }
    }
  }
}
</script>