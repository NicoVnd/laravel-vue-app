<template>
  <div class="wysiwyg-editor">
    <!-- Barre d'outils personnalisée -->
    <div class="toolbar bg-gray-50 border border-gray-300 rounded-t-lg p-2 flex items-center space-x-2">
      <!-- Boutons de formatage -->
      <button type="button" class="ql-bold p-2 hover:bg-gray-200 rounded" title="Gras">
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
          <path d="M5 3v14h5.5c2.5 0 4.5-2 4.5-4.5 0-1.5-.8-2.8-2-3.5 1.2-.7 2-2 2-3.5C15 3 13 1 10.5 1H5v2zm2 2h3.5c1.4 0 2.5 1.1 2.5 2.5S11.9 10 10.5 10H7V5zm0 7h4c1.7 0 3 1.3 3 3s-1.3 3-3 3H7v-6z"/>
        </svg>
      </button>
      
      <button type="button" class="ql-italic p-2 hover:bg-gray-200 rounded" title="Italique">
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
          <path d="M8 1h8v2h-2.5L9.5 17H12v2H4v-2h2.5L10.5 3H8V1z"/>
        </svg>
      </button>
      
      <button type="button" class="ql-underline p-2 hover:bg-gray-200 rounded" title="Souligné">
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
          <path d="M4 18h12v2H4v-2zM6 2v8c0 2.2 1.8 4 4 4s4-1.8 4-4V2h2v8c0 3.3-2.7 6-6 6s-6-2.7-6-6V2h2z"/>
        </svg>
      </button>
      
      <button type="button" class="ql-link p-2 hover:bg-gray-200 rounded" title="Lien">
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
          <path d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5z"/>
          <path d="M7.414 15.414a2 2 0 01-2.828-2.828l3-3a2 2 0 012.828 0 1 1 0 001.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5z"/>
        </svg>
      </button>
      
      <div class="border-l border-gray-300 h-6 mx-2"></div>
      
      <!-- Menu déroulant pour les variables -->
      <div class="relative" ref="variableDropdown">
        <button 
          type="button" 
          @click="toggleVariableMenu"
          class="flex items-center space-x-1 px-3 py-2 bg-[#1E40AF] text-white rounded hover:bg-[#1D4ED8] transition-colors"
        >
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
          </svg>
          <span>Variables</span>
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
          </svg>
        </button>
        
        <div v-if="showVariableMenu" class="absolute top-full left-0 mt-1 bg-white border border-gray-300 rounded-lg shadow-lg z-10 min-w-48">
          <button 
            type="button"
            @click="insertVariable('{{nom_utilisateur}}')"
            class="w-full text-left px-4 py-2 hover:bg-gray-100 flex items-center space-x-2"
          >
            <span class="text-[#D4B896] font-mono">{{nom_utilisateur}}</span>
            <span class="text-gray-600 text-sm">- Nom du lecteur</span>
          </button>
          <button 
            type="button"
            @click="insertVariable('{{date_lecture}}')"
            class="w-full text-left px-4 py-2 hover:bg-gray-100 flex items-center space-x-2"
          >
            <span class="text-[#D4B896] font-mono">{{date_lecture}}</span>
            <span class="text-gray-600 text-sm">- Date du jour</span>
          </button>
        </div>
      </div>
    </div>
    
    <!-- Zone d'édition Quill -->
    <div 
      ref="editor" 
      class="min-h-64 border-l border-r border-b border-gray-300 rounded-b-lg"
      style="min-height: 300px;"
    ></div>
  </div>
</template>

<script>
import Quill from 'quill'
import 'quill/dist/quill.snow.css'

export default {
  name: 'WysiwygEditor',
  props: {
    modelValue: {
      type: String,
      default: ''
    }
  },
  emits: ['update:modelValue'],
  data() {
    return {
      quill: null,
      showVariableMenu: false,
      // Ajouter les variables pour éviter les erreurs Vue
      nom_utilisateur: '{{nom_utilisateur}}',
      date_lecture: '{{date_lecture}}'
    }
  },
  mounted() {
    this.initializeEditor()
    document.addEventListener('click', this.handleClickOutside)
  },
  beforeUnmount() {
    document.removeEventListener('click', this.handleClickOutside)
    if (this.quill) {
      this.quill = null
    }
  },
  watch: {
    modelValue(newVal) {
      if (this.quill && newVal !== this.quill.root.innerHTML) {
        this.quill.root.innerHTML = newVal
      }
    }
  },
  methods: {
    initializeEditor() {
      // Configuration de Quill
      this.quill = new Quill(this.$refs.editor, {
        theme: 'snow',
        modules: {
          toolbar: [
            [{ 'header': [1, 2, 3, false] }],
            ['bold', 'italic', 'underline'],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            ['link'],
            ['clean']
          ]
        },
        placeholder: 'Rédigez votre contenu ici...',
        formats: ['header', 'bold', 'italic', 'underline', 'list', 'link']
      })
      
      // Écouter les changements de contenu
      this.quill.on('text-change', () => {
        this.$emit('update:modelValue', this.quill.root.innerHTML)
      })
      
      // Initialiser le contenu si fourni
      if (this.modelValue) {
        this.quill.root.innerHTML = this.modelValue
      }
    },
    
    insertVariable(variable) {
      if (!this.quill) return
      
      try {
        // Approche alternative : manipulation directe du contenu HTML
        const currentHtml = this.quill.root.innerHTML
        const styledVariable = `<span style="background: #FEF3C7; color: #D97706; font-weight: bold; padding: 2px 4px; border-radius: 3px; margin: 0 2px;">${variable}</span>`
        
        // Ajouter la variable à la fin du contenu
        const newHtml = currentHtml + styledVariable
        
        // Mettre à jour le contenu sans passer par les méthodes Quill problématiques
        this.quill.root.innerHTML = newHtml
        
        // Émettre la mise à jour
        this.$emit('update:modelValue', newHtml)
        
      } catch (error) {
        console.error('Erreur lors de l\'insertion de variable:', error)
      }
      
      this.showVariableMenu = false
    },
    
    // styleVariables() {
    // // Commenté pour éviter les conflits
    // },
    
    // applyVariableStyles() {
    // // Commenté pour éviter les conflits
    // },
    
    toggleVariableMenu() {
      this.showVariableMenu = !this.showVariableMenu
    },
    
    handleClickOutside(event) {
      if (this.$refs.variableDropdown && !this.$refs.variableDropdown.contains(event.target)) {
        this.showVariableMenu = false
      }
    }
  }
}
</script>

<style scoped>
.wysiwyg-editor .ql-toolbar {
  display: none; /* Masquer la barre d'outils par défaut de Quill */
}

.wysiwyg-editor .ql-container {
  border: none;
  font-size: 16px;
}

.wysiwyg-editor .ql-editor {
  padding: 16px;
  min-height: 300px;
}

/* Style pour les variables dans l'éditeur */
.wysiwyg-editor .ql-editor .variable {
  background-color: #FEF3C7;
  color: #D97706;
  font-weight: bold;
  padding: 2px 4px;
  border-radius: 4px;
}
</style>