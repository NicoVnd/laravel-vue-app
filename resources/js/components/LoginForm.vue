<template>
  <div class="bg-white rounded-xl shadow-xl p-8 max-w-md mx-auto backdrop-blur-sm border border-gray-100">
    <div class="text-center mb-8">
      <h2 class="text-3xl font-bold text-[#1E40AF] mb-2">Connexion</h2>
      <p class="text-gray-600">Accédez à votre compte</p>
    </div>
    
    <form @submit.prevent="login" class="space-y-6">
      <div class="space-y-2">
        <label for="email" class="block text-sm font-semibold text-gray-700">Email</label>
        <div class="relative">
          <input 
            type="email" 
            id="email" 
            v-model="form.email" 
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D4B896] focus:border-[#D4B896] transition-all duration-300 bg-gray-50 focus:bg-white"
            placeholder="votre@email.com"
            required
          >
          <svg class="absolute right-3 top-3.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
          </svg>
        </div>
      </div>
      
      <div class="space-y-2">
        <label for="password" class="block text-sm font-semibold text-gray-700">Mot de passe</label>
        <div class="relative">
          <input 
            type="password" 
            id="password" 
            v-model="form.password" 
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D4B896] focus:border-[#D4B896] transition-all duration-300 bg-gray-50 focus:bg-white"
            placeholder="••••••••"
            required
          >
          <svg class="absolute right-3 top-3.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
          </svg>
        </div>
      </div>
      
      <div v-if="error" class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg flex items-center space-x-2">
        <svg class="h-5 w-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span class="text-sm">{{ error }}</span>
      </div>
      
      <button 
        type="submit" 
        :disabled="loading"
        class="w-full bg-gradient-to-r from-[#1E40AF] to-[#3B82F6] text-white py-3 px-6 rounded-lg font-semibold hover:from-[#1D4ED8] hover:to-[#2563EB] transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed transform hover:scale-[1.02] active:scale-[0.98] shadow-lg hover:shadow-xl"
      >
        <span v-if="loading" class="flex items-center justify-center space-x-2">
          <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          <span>Connexion...</span>
        </span>
        <span v-else class="flex items-center justify-center space-x-2">
          <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
          </svg>
          <span>Se connecter</span>
        </span>
      </button>
    </form>
    
    <div class="mt-8 text-center">
      <p class="text-gray-600">
        Pas encore de compte ? 
        <a href="/register" class="text-[#D4B896] hover:text-[#C4A886] font-semibold transition-colors duration-300 hover:underline">
          S'inscrire
        </a>
      </p>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'LoginForm',
  data() {
    return {
      form: {
        email: '',
        password: ''
      },
      loading: false,
      error: null
    }
  },
  methods: {
    async login() {
      this.loading = true
      this.error = null
      
      try {
        const response = await axios.post('/login', this.form)
        if (response.data.success) {
          window.location.href = response.data.redirect
        }
      } catch (error) {
        if (error.response && error.response.data.message) {
          this.error = error.response.data.message
        } else {
          this.error = 'Une erreur est survenue lors de la connexion'
        }
      } finally {
        this.loading = false
      }
    }
  }
}
</script>