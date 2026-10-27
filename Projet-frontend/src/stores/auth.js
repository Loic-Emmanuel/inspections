import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import api from '@/services/api'
/**
 * =====================================
 * STORE AUTHENTIFICATION (Pinia)
 * =====================================
 * Authentification via Laravel Sanctum TOKEN
 * Auth par Bearer Token (localStorage)
 */
export const useAuthStore = defineStore('auth', () => {
  /** STATE */
  const user = ref(null)
  const token = ref(null)

  /** GETTERS */
  const isAuthenticated = computed(() => !!token.value) // 🔥 Mieux de vérifier le token

  /** ACTIONS */
  
  const login = async (credentials) => {
    const response = await api.login(credentials)
    
    // Sauvegarder le token
    const authToken = response.data.token
    localStorage.setItem('auth_token', authToken)
    token.value = authToken // 🔥 IMPORTANT : synchroniser avec le state
    
    // Sauvegarder l'utilisateur
    user.value = {
      ...response.data.user,
      name: response.data.user.name || '',
      firstname: response.data.user.firstname || ''
    }
  }

  const logout = async () => {
    try {
      await api.logout()
    } catch {
      console.warn('Token déjà invalide ou expiré')
    }
    
    // Nettoyage complet
    localStorage.removeItem('auth_token')
    user.value = null
    token.value = null
  }

  const fetchUser = async () => {
    try {
      const response = await api.getUser()
      user.value = response.data
    } catch {
      localStorage.removeItem('auth_token')
      user.value = null
      token.value = null
    }
  }

  // 🔥 CORRECTION PRINCIPALE ICI
  const initialize = async () => {
    const storedToken = localStorage.getItem('auth_token')
    
    if (!storedToken) {
      user.value = null
      token.value = null
      return
    }

    // 🔥 CRUCIAL : Restaurer le token dans le state
    token.value = storedToken

    // Si user est déjà en mémoire (grâce à persist), on vérifie sa validité
    if (user.value) {
      // Optionnel : vérifier que les données sont complètes
      if (!user.value.name || !user.value.firstname) {
        await fetchUser()
      }
    } else {
      // Sinon, récupérer l'utilisateur
      await fetchUser()
    }
  }

  return {
    user,
    token,
    isAuthenticated,
    login,
    logout,
    fetchUser,
    initialize,
  }
}, {
  persist: {
    key: 'auth',
    storage: localStorage,
    paths: ['user', 'token'] // 🔥 Optionnel : persister aussi le token
  }
})