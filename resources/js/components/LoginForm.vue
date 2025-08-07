<template>
  <div class="bg-white rounded-lg shadow-md p-8">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Connexion</h2>
    
    <form @submit.prevent="login">
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
      
      <div class="mb-6">
        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Mot de passe</label>
        <input 
          type="password" 
          id="password" 
          v-model="form.password" 
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
        class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors disabled:opacity-50"
      >
        {{ loading ? 'Connexion...' : 'Se connecter' }}
      </button>
    </form>
    
    <p class="text-center text-gray-600 mt-4">
      Pas encore de compte ? 
      <a href="/register" class="text-blue-600 hover:underline">S'inscrire</a>
    </p>
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