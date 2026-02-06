<template>
  <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 flex items-center justify-center px-3 sm:px-4 py-6 sm:py-8">
    <div class="max-w-md w-full">
      <!-- Logo/Header -->
      <div class="text-center mb-6 sm:mb-8">
        <div class="inline-flex items-center justify-center w-14 h-14 sm:w-16 sm:h-16 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-2xl shadow-lg mb-3 sm:mb-4 transform hover:scale-105 transition-transform">
          <svg class="w-8 h-8 sm:w-10 sm:h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mb-1 sm:mb-2">Gestion d'Inspections</h1>
        <p class="text-sm sm:text-base text-gray-600">Connectez-vous à votre compte</p>
      </div>

      <!-- Formulaire de connexion -->
      <div class="bg-white rounded-xl sm:rounded-2xl shadow-2xl p-5 sm:p-6 md:p-8 backdrop-blur-sm bg-opacity-95">
        <form @submit.prevent="handleLogin" class="space-y-4 sm:space-y-5 md:space-y-6">
          <!-- Email -->
          <div>
            <label for="email" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">
              Adresse email
            </label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                </svg>
              </div>
              <input 
                id="email" 
                v-model="form.email" 
                name="email" 
                type="email" 
                required 
                autocomplete="username"
                class="w-full pl-9 sm:pl-10 pr-3 sm:pr-4 py-2.5 sm:py-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 hover:border-indigo-300"
                placeholder="inspecteur@exemple.com" 
              />
            </div>
          </div>

          <!-- Mot de passe -->
          <div>
            <label for="password" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">
              Mot de passe
            </label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
              </div>
              <input 
                id="password" 
                v-model="form.password" 
                name="password" 
                :type="showPassword ? 'text' : 'password'" 
                required
                autocomplete="current-password"
                class="w-full pl-9 sm:pl-10 pr-10 sm:pr-12 py-2.5 sm:py-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 hover:border-indigo-300"
                placeholder="••••••••" 
              />
              <button
                type="button"
                @click="showPassword = !showPassword"
                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition-colors"
              >
                <svg v-if="showPassword" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                <svg v-else class="h-4 w-4 sm:h-5 sm:w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                </svg>
              </button>
            </div>
          </div>

          <!-- Remember me -->
          <div class="flex items-center justify-between">
            <label class="flex items-center cursor-pointer group">
              <input 
                v-model="form.remember" 
                type="checkbox"
                class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 transition cursor-pointer" 
              />
              <span class="ml-2 text-xs sm:text-sm text-gray-600 group-hover:text-gray-800 transition">Se souvenir de moi</span>
            </label>
            <!-- <a href="#" class="text-xs sm:text-sm text-indigo-600 hover:text-indigo-700 font-medium transition">
              Mot de passe oublié ?
            </a> -->
          </div>

          <!-- Message d'erreur -->
          <div v-if="error" class="p-3 sm:p-4 bg-red-50 border border-red-200 rounded-lg animate-shake">
            <div class="flex items-start">
              <svg class="w-4 h-4 sm:w-5 sm:h-5 text-red-600 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <p class="text-xs sm:text-sm text-red-700 font-medium">{{ error }}</p>
            </div>
          </div>

          <!-- Bouton de connexion -->
          <button 
            type="submit" 
            :disabled="loading"
            class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-2.5 sm:py-3 rounded-lg font-semibold text-sm sm:text-base hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed transform hover:scale-[1.02] active:scale-[0.98] shadow-lg hover:shadow-xl"
          >
            <span v-if="!loading" class="flex items-center justify-center">
              Se connecter
            </span>
            <span v-else class="flex items-center justify-center">
              <svg class="animate-spin h-4 w-4 sm:h-5 sm:w-5 mr-2" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
              </svg>
              Connexion en cours...
            </span>
          </button>
        </form>

        <!-- Divider -->
        <div class="relative my-5 sm:my-6">
          <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-gray-200"></div>
          </div>
          <div class="relative flex justify-center text-xs sm:text-sm">
            <span class="px-2 sm:px-3 bg-white text-gray-500 font-medium">Connexion sécurisée</span>
          </div>
        </div>

        <!-- Security badge -->
        <div class="flex items-center justify-center text-xs sm:text-sm text-gray-500">
          <svg class="w-4 h-4 mr-1.5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
          </svg>
          <span>Vos données sont protégées</span>
        </div>
      </div>

      <!-- Footer -->
      <p class="text-center text-xs sm:text-sm text-gray-600 mt-4 sm:mt-6 font-medium">
        © 2025 Gestion d'Inspections. Tous droits réservés.
      </p>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const router = useRouter()
const authStore = useAuthStore()

const form = ref({
  email: '',
  password: '',
  remember: false,
})

const loading = ref(false)
const error = ref('')
const showPassword = ref(false)

const handleLogin = async () => {
  loading.value = true
  error.value = ''

  try {
    // Appel du store Pinia
    await authStore.login({
      email: form.value.email,
      password: form.value.password,
      remember: form.value.remember,
    })

    // Redirection après succès
    router.push({ name: 'Dashboard' })
  } catch (err) {
    // Reset message
    error.value = 'Une erreur est survenue'

    // Erreur Axios avec réponse serveur
    if (err.response) {
      const status = err.response.status
      const data = err.response.data

      switch (status) {
        case 401:
          error.value = 'Email ou mot de passe incorrect'
          break

        case 422:
          // Si l'API renvoie des erreurs de validation
          if (data?.errors) {
            error.value = Object.values(data.errors)
              .flat()
              .join(', ')
          } else {
            error.value = data?.message || 'Données invalides'
          }
          break

        case 403:
          error.value = 'Accès refusé'
          break

        case 500:
          error.value = 'Erreur serveur. Réessayez plus tard.'
          break

        default:
          error.value = data?.message || 'Erreur inconnue'
      }

      // Pas de réponse → problème réseau
    } else if (err.request) {
      error.value = 'Impossible de joindre le serveur. Vérifiez votre connexion.'

      // Autre erreur JS
    } else {
      error.value = err.message || 'Erreur inattendue'
    }
  } finally {
    loading.value = false
  }
}
</script>

<style scoped>
@keyframes shake {
  0%, 100% { transform: translateX(0); }
  10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
  20%, 40%, 60%, 80% { transform: translateX(5px); }
}

.animate-shake {
  animation: shake 0.5s ease-in-out;
}
</style>