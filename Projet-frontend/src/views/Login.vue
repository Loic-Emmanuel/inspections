<template>
  <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center px-4">
    <div class="max-w-md w-full">
      <!-- Logo/Header -->
      <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-600 rounded-full mb-4">
          <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <h1 class="text-3xl font-bold text-gray-900">Gestion d'Inspections</h1>
        <p class="text-gray-600 mt-2">Connectez-vous à votre compte</p>
      </div>

      <!-- Formulaire de connexion -->
      <div class="bg-white rounded-2xl shadow-xl p-8">
        <form @submit.prevent="handleLogin">
          <!-- Email -->
          <div class="mb-6">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
              Adresse email
            </label>
            <input id="email" v-model="form.email" name="email" type="email" required autocomplete="username"
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
              placeholder="inspecteur@exemple.com" />
          </div>

          <!-- Mot de passe -->
          <div class="mb-6">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
              Mot de passe
            </label>
            <input id="password" v-model="form.password" name="password" type="password" required
              autocomplete="current-password"
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
              placeholder="••••••••" />
          </div>

          <!-- Remember me -->
          <div class="flex items-center justify-between mb-6">
            <label class="flex items-center">
              <input v-model="form.remember" type="checkbox"
                class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" />
              <span class="ml-2 text-sm text-gray-600">Se souvenir de moi</span>
            </label>
            <!-- <a href="#" class="text-sm text-indigo-600 hover:text-indigo-700">
              Mot de passe oublié ?
            </a> -->
          </div>

          <!-- Message d'erreur -->
          <div v-if="error" class="mb-4 p-3 bg-red-50 text-center border border-red-200 rounded-lg">
            <p class="text-sm text-red-600">{{ error }}</p>
          </div>

          <!-- Bouton de connexion -->
          <button type="submit" :disabled="loading"
            class="w-full bg-indigo-600 text-white py-3 rounded-lg font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition disabled:opacity-50 disabled:cursor-not-allowed">
            <span v-if="!loading">Se connecter</span>
            <span v-else class="flex items-center justify-center">
              <svg class="animate-spin h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
              </svg>
              Connexion en cours...
            </span>
          </button>
        </form>
      </div>

      <!-- Footer -->
      <p class="text-center text-sm text-gray-600 mt-6">
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
    error.value = err.response?.data?.message || 'Identifiants incorrects. Veuillez réessayer.'
  } finally {
    loading.value = false
  }
}
</script>
