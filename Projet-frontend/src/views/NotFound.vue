<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 px-6">
      <div class="text-center max-w-md">
  
        <!-- Illustration SVG -->
        <div class="flex justify-center mb-6">
          <svg
            class="w-56 h-56"
            viewBox="0 0 400 300"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <circle cx="200" cy="150" r="120" fill="#EEF2FF" />
            <path
              d="M140 170h120v20H140z"
              fill="#6366F1"
              opacity="0.8"
            />
            <path
              d="M160 120h80v40h-80z"
              fill="#818CF8"
            />
            <circle cx="180" cy="140" r="5" fill="#fff" />
            <circle cx="220" cy="140" r="5" fill="#fff" />
            <path
              d="M185 155c10 8 20 8 30 0"
              stroke="#fff"
              stroke-width="3"
              stroke-linecap="round"
            />
          </svg>
        </div>
  
        <!-- Texte -->
        <h1 class="text-8xl font-extrabold text-indigo-600">404</h1>
  
        <p class="mt-4 text-2xl font-semibold text-gray-800">
          Page introuvable
        </p>
  
        <p class="mt-2 text-gray-500">
          Désolé, la page que vous recherchez n’existe pas ou a été déplacée.
        </p>
  
        <!-- Boutons -->
        <div class="mt-8 flex justify-center gap-4">
          <router-link
            to="/"
            class="px-6 py-3 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition"
          >
            Retour à l’accueil
          </router-link>
  
          <button
            @click="$router.back()"
            class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition"
          >
            Page précédente
          </button>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  </script>

  <style scoped>
  @keyframes bounce-slow {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-8px); }
}

.animate-bounce-slow {
  animation: bounce-slow 3s infinite;
}

  </style>
  