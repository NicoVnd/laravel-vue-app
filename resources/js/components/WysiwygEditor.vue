<template>
  <div class="wysiwyg-editor">
    <!-- Barre d'outils personnalisée -->
    <div class="toolbar bg-gray-50 border border-gray-300 rounded-t-lg p-2 flex items-center space-x-2">
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
      date_lecture: '{{date_lecture}}',
      savedCursorPosition: null, // Ajouter cette ligne
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
    
    showVariables() {
      this.showVariableMenu = !this.showVariableMenu
    },
    
    insertVariable(variable) {
      if (!this.quill) return
      
      try {
        // Utiliser directement le fallback HTML qui fonctionne
        const currentHtml = this.quill.root.innerHTML || '<p><br></p>'
        const styledVariable = `<span style="color: #2563eb; font-weight: bold; margin: 0 2px;">${variable}</span>`
        
        let newHtml
        if (currentHtml === '<p><br></p>' || currentHtml.trim() === '') {
          newHtml = `<p>${styledVariable}<br></p>`
        } else {
          // Insérer avant la dernière balise fermante
          newHtml = currentHtml.replace(/<\/([^>]+)>\s*$/, ` ${styledVariable}</$1>`)
        }
        
        this.quill.root.innerHTML = newHtml
        this.$emit('update:modelValue', newHtml)
        
        console.log('Variable insérée:', variable)
        
      } catch (error) {
        console.error('Erreur insertion:', error)
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