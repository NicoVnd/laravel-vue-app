<template>
  <div class="min-h-screen bg-gradient-to-br from-blue-400 via-purple-500 to-pink-500 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-md w-full text-center transform hover:scale-105 transition-transform duration-300">
      <div class="mb-6">
        <h1 class="text-4xl font-bold text-gray-800 mb-2">👋 Hello World!</h1>
        <p class="text-gray-600 text-lg">Bienvenue dans Vue + Tailwind</p>
      </div>
      
      <div class="space-y-4">
        <div class="bg-gradient-to-r from-green-400 to-blue-500 text-white p-4 rounded-lg">
          <p class="font-semibold">✨ Tailwind CSS fonctionne parfaitement !</p>
        </div>
        
        <button 
          @click="toggleGreeting" 
          class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-200 shadow-lg hover:shadow-xl"
        >
          {{ isGreeting ? '👋 Dire au revoir' : '🎉 Dire bonjour' }}
        </button>
        
        <div v-if="isGreeting" class="bg-yellow-100 border-l-4 border-yellow-500 p-4 rounded">
          <p class="text-yellow-800 font-medium">🌟 Bonjour ! Tout fonctionne à merveille !</p>
        </div>
      </div>
      
      <div class="mt-6 flex justify-center space-x-2">
        <div class="w-3 h-3 bg-red-500 rounded-full animate-bounce"></div>
        <div class="w-3 h-3 bg-yellow-500 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
        <div class="w-3 h-3 bg-green-500 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ExampleComponent',
  data() {
    return {
      isGreeting: false
    }
  },
  methods: {
    toggleGreeting() {
      this.isGreeting = !this.isGreeting
    }
  }
}
</script>
