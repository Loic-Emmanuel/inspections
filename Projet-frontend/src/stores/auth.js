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

  /**
   * ================================
   * STATE
   * ================================
   */
  const user = ref(null)

  /**
   * ================================
   * GETTERS
   * ================================
   */
  const isAuthenticated = computed(() => !!user.value)

  /**
   * ================================
   * ACTIONS
   * ================================
   */

  // Connexion utilisateur
  const login = async (credentials) => {
    const response = await api.login(credentials)

    // Sauvegarde du token dans localStorage
    localStorage.setItem('auth_token', response.data.token)

    // user retourné par l'API
    user.value = response.data.user
  }

  // Déconnexion utilisateur
  const logout = async () => {
    try {
      await api.logout()
    } catch {
      console.warn('Token déjà invalide ou expiré')
    }

    // Nettoyage local
    localStorage.removeItem('auth_token')
    user.value = null
  }

  // Récupération de l'utilisateur connecté
  const fetchUser = async () => {
    try {
      const response = await api.getUser()
      user.value = response.data
    } catch {
      localStorage.removeItem('auth_token')
      user.value = null
    }
  }

  // Initialisation de l'auth
  const initialize = async () => {
    const token = localStorage.getItem('auth_token')
    if (!token) {
      user.value = null
      return
    }
    await fetchUser()
  }

  return {
    user,
    isAuthenticated,
    login,
    logout,
    fetchUser,
    initialize,
  }
},
{
  // Persist user in localStorage
  persist: {
    key: 'auth',        // clé dans le localStorage
    storage: localStorage,
    paths: ['user']     // seuls les champs à persister
  }
})
