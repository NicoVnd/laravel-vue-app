<template>
  <nav class="bg-[#F8FAFC] shadow-sm w-full fixed top-0 z-50 transition-all duration-300" :class="{ 'scrolled shadow-md bg-white': isScrolled }">
    <div class="container mx-auto px-4">
      <div class="flex justify-between items-center h-20">
        <!-- Logo et navigation à gauche -->
        <div class="flex items-center space-x-8">
          <a href="/" class="flex items-center">
            <span class="text-2xl font-bold text-[#1E40AF]">BlogPlatform</span>
          </a>
          <!-- Menu navigation - visible uniquement sur desktop -->
          <div class="hidden md:flex items-center space-x-8">
            <a href="/" class="text-gray-600 hover:text-[#D4B896] font-medium transition-colors duration-300">Accueil</a>
            <a v-if="user && getUserRole() === 'Rédacteur'" href="/create-article" class="text-gray-600 hover:text-[#D4B896] font-medium transition-colors duration-300">Créer un article</a>
          </div>
        </div>

        <!-- Boutons de connexion/déconnexion à droite - visible uniquement sur desktop -->
        <div class="hidden md:flex items-center space-x-4">
          <!-- Si l'utilisateur est connecté -->
          <div v-if="user" class="relative" @click.away="closeDropdown">
            <button
              type="button"
              class="inline-flex items-center px-4 py-2 text-[#1E40AF] font-medium rounded-md hover:bg-blue-50 transition-colors focus:outline-none focus:ring-2 focus:ring-[#D4B896] focus:ring-offset-2"
              @click="toggleDropdown"
            >
              <div class="flex items-center space-x-2">
                <div class="w-8 h-8 bg-gradient-to-r from-[#1E40AF] to-[#3B82F6] rounded-full flex items-center justify-center text-white font-semibold text-sm">
                  {{ user.name.charAt(0).toUpperCase() }}
                </div>
                <span class="text-sm">{{ user.name }}</span>
                <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': isDropdownOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
              </div>
            </button>

            <!-- Dropdown Menu -->
            <div
              v-show="isDropdownOpen"
              class="absolute right-0 mt-2 w-56 bg-white rounded-md shadow-xl focus:outline-none z-50 transition-all duration-200"
              :class="isDropdownOpen ? 'opacity-100 scale-100' : 'opacity-0 scale-95'"
            >
              <div class="py-1">
                <div class="px-4 py-3 border-b border-gray-100">
                  <p class="text-sm font-medium text-gray-900">{{ user.name }}</p>
                  <p class="text-sm text-gray-500">{{ user.email }}</p>
                  <p class="text-xs text-[#D4B896] font-medium mt-1">{{ getUserRole() }}</p>
                </div>

                <a href="/profile"
                   class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 transition-colors">
                  <svg class="w-4 h-4 mr-3 text-[#1E40AF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                  </svg>
                  Mon profil
                </a>

                <a v-if="getUserRole() === 'Rédacteur'" href="/mes-articles"
                   class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 transition-colors">
                  <svg class="w-4 h-4 mr-3 text-[#1E40AF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                  </svg>
                  Mes articles
                </a>

                <div class="border-t border-gray-100 my-1"></div>

                <button 
                  @click="logout"
                  class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors"
                >
                  <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                  </svg>
                  Se déconnecter
                </button>
              </div>
            </div>
          </div>

          <!-- Si l'utilisateur n'est pas connecté -->
          <div v-else class="flex items-center space-x-2">
            <a href="/login" class="bg-[#1E40AF] text-white px-4 py-2 rounded-md font-medium hover:bg-[#1D4ED8] transition-colors">
              Se connecter
            </a>
            <a href="/register" class="border border-[#1E40AF] text-[#1E40AF] px-4 py-2 rounded-md font-medium hover:bg-[#1E40AF] hover:text-white transition-colors">
              S'inscrire
            </a>
          </div>
        </div>

        <!-- Bouton hamburger - visible uniquement sur mobile -->
        <button @click="toggleMobileMenu" class="md:hidden flex items-center p-2 rounded-md text-gray-600 hover:text-[#D4B896] hover:bg-blue-50 focus:outline-none">
          <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
      </div>

      <!-- Menu mobile - caché par défaut -->
      <div v-show="isMobileMenuOpen" class="md:hidden pb-6 mb-6 mt-2 bg-white rounded-lg shadow-lg animate-fadeIn">
        <div class="flex flex-col divide-y divide-gray-100">
          <div class="py-2 px-4">
            <a href="/" class="block text-gray-600 hover:text-[#D4B896] font-medium py-3 px-2 rounded-md hover:bg-blue-50 transition-all">
              <span class="flex items-center">
                <svg class="w-5 h-5 mr-2 text-[#1E40AF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Accueil
              </span>
            </a>
            <a v-if="user && getUserRole() === 'Rédacteur'" href="/create-article" class="block text-gray-600 hover:text-[#D4B896] font-medium py-3 px-2 rounded-md hover:bg-blue-50 transition-all">
              <span class="flex items-center">
                <svg class="w-5 h-5 mr-2 text-[#1E40AF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Créer un article
              </span>
            </a>
          </div>
          
          <div class="py-4 px-4 space-y-3">
            <div v-if="user">
              <!-- Utilisateur connecté - version mobile -->
              <div class="text-center text-[#1E40AF] font-medium mb-3">
                Bonjour, {{ user.name }}
                <div class="text-xs text-[#D4B896]">{{ getUserRole() }}</div>
              </div>
              <button @click="logout" class="w-full inline-flex items-center justify-center px-6 py-3 border border-[#D4B896] text-[#1E40AF] font-medium rounded-md hover:bg-[#D4B896] hover:text-white transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Se déconnecter
              </button>
            </div>
            
            <div v-else>
              <!-- Utilisateur non connecté - version mobile -->
              <a href="/login" class="block bg-[#1E40AF] text-white px-4 py-3 rounded-md font-medium hover:bg-[#1D4ED8] transition-colors text-center mb-3">
                <span class="flex items-center justify-center">
                  <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                  </svg>
                  Se connecter
                </span>
              </a>
              <a href="/register" class="block border border-[#1E40AF] text-[#1E40AF] px-4 py-3 rounded-md font-medium hover:bg-[#1E40AF] hover:text-white transition-colors text-center">
                <span class="flex items-center justify-center">
                  <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                  </svg>
                  S'inscrire
                </span>
              </a>
            </div>
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
      user: null,
      isDropdownOpen: false,
      isMobileMenuOpen: false,
      isScrolled: false
    }
  },
  async mounted() {
    await this.checkAuth()
    this.handleScroll()
    window.addEventListener('scroll', this.handleScroll)
  },
  beforeUnmount() {
    window.removeEventListener('scroll', this.handleScroll)
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
    toggleDropdown() {
      this.isDropdownOpen = !this.isDropdownOpen
    },
    closeDropdown() {
      this.isDropdownOpen = false
    },
    toggleMobileMenu() {
      this.isMobileMenuOpen = !this.isMobileMenuOpen
    },
    handleScroll() {
      this.isScrolled = window.scrollY > 50
    },
    async logout() {
      try {
        await axios.post('/logout')
        this.user = null
        this.isDropdownOpen = false
        this.isMobileMenuOpen = false
        window.location.href = '/'
      } catch (error) {
        console.error('Erreur lors de la déconnexion:', error)
      }
    }
  }
}
</script>

<style scoped>
@keyframes fadeIn {
  from { 
    opacity: 0; 
    transform: translateY(-10px); 
  }
  to { 
    opacity: 1; 
    transform: translateY(0); 
  }
}

.animate-fadeIn {
  animation: fadeIn 0.3s ease-out;
}

.scrolled {
  backdrop-filter: blur(10px);
}
</style>