<template>
  <div class="bg-white rounded-lg shadow-md p-8">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Inscription</h2>
    
    <form @submit.prevent="register">
      <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nom</label>
        <input 
          type="text" 
          id="name" 
          v-model="form.name" 
          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
          required
        >
      </div>
      
      <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
        <input 
          type="email" 
          id="email" 
          v-model="form.email" 
          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
          required
        >
      </div>
      
      <div class="mb-4">
        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Rôle</label>
        <select 
          id="role" 
          v-model="form.role" 
          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
          required
        >
          <option value="">Choisir un rôle</option>
          <option value="user">Utilisateur</option>
          <option value="redacteur">Rédacteur</option>
        </select>
      </div>
      
      <div class="mb-4">
        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Mot de passe</label>
        <input 
          type="password" 
          id="password" 
          v-model="form.password" 
          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
          required
        >
      </div>
      
      <div class="mb-6">
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirmer le mot de passe</label>
        <input 
          type="password" 
          id="password_confirmation" 
          v-model="form.password_confirmation" 
          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
          required
        >
      </div>
      
      <div v-if="error" class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
        {{ error }}
      </div>
      
      <button 
        type="submit" 
        :disabled="loading"
        class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition-colors disabled:opacity-50"
      >
        {{ loading ? 'Inscription...' : 'S\'inscrire' }}
      </button>
    </form>
    
    <p class="text-center text-gray-600 mt-4">
      Déjà un compte ? 
      <a href="/login" class="text-blue-600 hover:underline">Se connecter</a>
    </p>
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