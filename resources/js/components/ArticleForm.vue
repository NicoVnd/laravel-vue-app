<template>
  <div class="bg-white rounded-lg shadow-lg p-8">
    <div class="mb-6">
      <h1 class="text-3xl font-bold text-gray-900">
        {{ isEditing ? 'Modifier l\'article' : 'Créer un nouvel article' }}
      </h1>
      <p class="text-gray-600 mt-2">
        {{ isEditing ? 'Modifiez votre article ci-dessous' : 'Rédigez votre article en utilisant l\'éditeur ci-dessous' }}
      </p>
    </div>

    <form @submit.prevent="submitForm" class="space-y-6">
      <!-- Titre -->
      <div>
        <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
          Titre de l'article
        </label>
        <input
          type="text"
          id="title"
          v-model="form.title"
          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1E40AF] focus:border-transparent transition-colors"
          placeholder="Entrez le titre de votre article"
          required
        >
      </div>

      <!-- Contenu -->
      <div>
        <label for="content" class="block text-sm font-semibold text-gray-700 mb-2">
          Contenu de l'article
        </label>
        <wysiwyg-editor 
          v-model="form.content" 
          placeholder="Rédigez votre article ici..."
        ></wysiwyg-editor>
      </div>

      <!-- Boutons -->
      <div class="flex justify-between items-center pt-6">
        <a href="/" class="text-gray-600 hover:text-gray-800 font-medium transition-colors">
          ← Retour à l'accueil
        </a>
        
        <div class="flex space-x-4">
          <button
            type="button"
            @click="saveDraft"
            class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition-colors"
          >
            Sauvegarder en brouillon
          </button>
          
          <button
            type="submit"
            :disabled="isSubmitting"
            class="px-6 py-3 bg-[#1E40AF] text-white rounded-lg hover:bg-[#1D4ED8] font-medium transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
          >
            {{ isSubmitting ? 'Publication...' : (isEditing ? 'Mettre à jour' : 'Publier l\'article') }}
          </button>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import WysiwygEditor from './WysiwygEditor.vue'
import axios from 'axios'

export default {
  name: 'ArticleForm',
  components: {
    WysiwygEditor
  },
  props: {
    article: {
      type: Object,
      default: null
    },
    isEditing: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      form: {
        title: '',
        content: ''
      },
      isSubmitting: false
    }
  },
  mounted() {
    if (this.isEditing && this.article) {
      this.form.title = this.article.title
      this.form.content = this.article.content
    }
  },
  methods: {
    async submitForm() {
      this.isSubmitting = true
      
      try {
        let response
        
        if (this.isEditing && this.article && this.article.id) {
          // Mise à jour de l'article existant
          response = await axios.put(`/articles/${this.article.id}`, {
            title: this.form.title,
            content: this.form.content,
            publish: true
          })
          
          // Redirection après mise à jour
          window.location.href = '/'
        } else {
          // Création d'un nouvel article
          response = await axios.post('/articles', {
            title: this.form.title,
            content: this.form.content
          })
          
          if (response.data.success) {
            window.location.href = response.data.redirect
          }
        }
      } catch (error) {
        console.error('Erreur lors de la soumission:', error)
        
        // Affichage d'erreur plus détaillé
        if (error.response) {
          console.error('Status:', error.response.status)
          console.error('Data:', error.response.data)
          alert(`Erreur ${error.response.status}: ${error.response.data.message || 'Une erreur est survenue'}`)
        } else {
          alert('Une erreur est survenue lors de la sauvegarde')
        }
      } finally {
        this.isSubmitting = false
      }
    },
    
    async saveDraft() {
      // Fonctionnalité de brouillon (optionnelle)
      console.log('Sauvegarde en brouillon')
    }
  }
}
</script>