<template>
  <nav class="bg-white shadow-lg">
    <div class="container mx-auto px-4">
      <div class="flex justify-between items-center py-4">
        <!-- Logo -->
        <div class="flex items-center">
          <a href="/" class="text-2xl font-bold text-blue-600">BlogPlatform</a>
        </div>

        <!-- Menu de navigation -->
        <div class="flex items-center space-x-4">
          <a href="/" class="text-gray-700 hover:text-blue-600 transition-colors">Accueil</a>
          
          <!-- Si l'utilisateur n'est pas connecté -->
          <div v-if="!user" class="flex items-center space-x-2">
            <a href="/login" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
              Connexion
            </a>
            <a href="/register" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
              Inscription
            </a>
          </div>

          <!-- Si l'utilisateur est connecté -->
          <div v-else class="flex items-center space-x-4">
            <!-- Badge utilisateur -->
            <div class="flex items-center space-x-2 bg-gray-100 rounded-full px-4 py-2">
              <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold">
                {{ user.name.charAt(0).toUpperCase() }}
              </div>
              <div class="text-sm">
                <div class="font-semibold text-gray-800">{{ user.name }}</div>
                <div class="text-gray-500 text-xs">
                  {{ getUserRole() }}
                </div>
              </div>
            </div>
            
            <!-- Bouton de déconnexion -->
            <button 
              @click="logout" 
              class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors"
            >
              Déconnexion
            </button>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
import axios from 'axios'

export default {
  name: 'Navbar',
  data() {
    return {
      user: null
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
        console.error('Erreur lors de la vérification de l\'authentification:', error)
      }
    },
    getUserRole() {
      if (this.user && this.user.roles && this.user.roles.length > 0) {
        const role = this.user.roles[0].name
        return role === 'redacteur' ? 'Rédacteur' : 'Utilisateur'
      }
      return 'Utilisateur'
    },
    async logout() {
      try {
        await axios.post('/logout')
        this.user = null
        window.location.href = '/'
      } catch (error) {
        console.error('Erreur lors de la déconnexion:', error)
      }
    }
  }
}
</script>