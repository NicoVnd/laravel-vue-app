<template>
  <div class="bg-white rounded-xl shadow-xl p-8 max-w-md mx-auto backdrop-blur-sm border border-gray-100">
    <div class="text-center mb-8">
      <h2 class="text-3xl font-bold text-[#1E40AF] mb-2">Inscription</h2>
      <p class="text-gray-600">Créez votre compte</p>
    </div>
    
    <form @submit.prevent="register" class="space-y-6">
      <div class="space-y-2">
        <label for="name" class="block text-sm font-semibold text-gray-700">Nom complet</label>
        <div class="relative">
          <input 
            type="text" 
            id="name" 
            v-model="form.name" 
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D4B896] focus:border-[#D4B896] transition-all duration-300 bg-gray-50 focus:bg-white"
            placeholder="Votre nom complet"
            required
          >
          <svg class="absolute right-3 top-3.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
          </svg>
        </div>
      </div>
      
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
        <label for="role" class="block text-sm font-semibold text-gray-700">Rôle</label>
        <div class="relative">
          <select 
            id="role" 
            v-model="form.role" 
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D4B896] focus:border-[#D4B896] transition-all duration-300 bg-gray-50 focus:bg-white appearance-none"
            required
          >
            <option value="" disabled>Choisir un rôle</option>
            <option value="user">Utilisateur</option>
            <option value="redacteur">Rédacteur</option>
          </select>
          <svg class="absolute right-3 top-3.5 h-5 w-5 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
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
      
      <div class="space-y-2">
        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">Confirmer le mot de passe</label>
        <div class="relative">
          <input 
            type="password" 
            id="password_confirmation" 
            v-model="form.password_confirmation" 
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D4B896] focus:border-[#D4B896] transition-all duration-300 bg-gray-50 focus:bg-white"
            placeholder="••••••••"
            required
          >
          <svg class="absolute right-3 top-3.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
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
          <span>Inscription...</span>
        </span>
        <span v-else class="flex items-center justify-center space-x-2">
          <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
          </svg>
          <span>S'inscrire</span>
        </span>
      </button>
    </form>
    
    <div class="mt-8 text-center">
      <p class="text-gray-600">
        Déjà un compte ? 
        <a href="/login" class="text-[#D4B896] hover:text-[#C4A886] font-semibold transition-colors duration-300 hover:underline">
          Se connecter
        </a>
      </p>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'RegisterForm',
  data() {
    return {
      form: {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        role: ''
      },
      loading: false,
      error: null
    }
  },
  methods: {
    async register() {
      this.loading = true
      this.error = null
      
      try {
        const response = await axios.post('/register', this.form)
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
          this.error = 'Une erreur est survenue lors de l\'inscription'
        }
      } finally {
        this.loading = false
      }
    }
  }
}
</script>