import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import api, { sanctumClient } from '@/services/api'

/**
 * =====================================
 * STORE AUTHENTIFICATION (Pinia)
 * =====================================
 * 👉 Gère l'état utilisateur
 * 👉 Gère la connexion / déconnexion
 * 👉 Compatible Laravel Sanctum (session)
 */
export const useAuthStore = defineStore('auth', () => {

  /**
   * ================================
   * STATE
   * ================================
   * 👉 Utilisateur connecté
   * 👉 Persisté dans localStorage
   */
  const user = ref(
    localStorage.getItem('user') ? JSON.parse(localStorage.getItem('user')) : null
  )

  /**
   * ================================
   * GETTERS
   * ================================
   * 👉 Vérifie si l'utilisateur est connecté
   */
  const isAuthenticated = computed(() => !!user.value)

  /**
   * ================================
   * ACTIONS
   * ================================
   */

  /**
   * Connexion utilisateur (Laravel Sanctum)
   *
   * Étapes :
   * 1️⃣ Récupérer le cookie CSRF
   * 2️⃣ Envoyer les identifiants à l'API
   * 3️⃣ Stocker l'utilisateur connecté
   */
  const login = async (credentials) => {
    // 1️⃣ Récupération du cookie CSRF
    // OBLIGATOIRE pour Sanctum (auth par session)
    await sanctumClient.get('/sanctum/csrf-cookie')

    // 2️⃣ Appel API de connexion
    const response = await api.login(credentials)

    // 3️⃣ Sauvegarde de l'utilisateur
    user.value = response.data.user
    localStorage.setItem('user', JSON.stringify(user.value))
  }

  /**
   * Déconnexion utilisateur
   *
   * 👉 Supprime la session côté backend
   * 👉 Nettoie l'état local
   */
  const logout = async () => {
    try {
      await api.logout()
    } catch {
      // On ignore l'erreur si la session est déjà expirée
      console.warn('Erreur logout ignorée')
    }

    user.value = null
    localStorage.removeItem('user')
  }

  /**
   * Récupération du profil utilisateur connecté
   *
   * 👉 Utilisé après refresh ou rechargement de page
   * 👉 Permet de vérifier si la session est encore valide
   */
  const fetchUser = async () => {
    try {
      const response = await api.getUser()

      user.value = response.data
      localStorage.setItem('user', JSON.stringify(user.value))
    } catch {
      // Si la session est invalide → déconnexion
      logout()
    }
  }

  /**
   * Initialisation de l'authentification
   *
   * 👉 Appelée au démarrage de l'application
   * 👉 Vérifie l'état de la session serveur
   */
  const initialize = async () => {
    if (user.value) {
      await fetchUser()
    }
  }

  /**
   * ================================
   * EXPORT DU STORE
   * ================================
   */
  return {
    user,
    isAuthenticated,
    login,
    logout,
    fetchUser,
    initialize
  }
})
