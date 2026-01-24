import axios from 'axios'

/**
 * ================================
 * CLIENT API (routes /api/*)
 * ================================
 * 👉 Utilisé pour TOUTES les routes Laravel API protégées par Sanctum
 * 👉 Exemple : /api/login, /api/user, /api/inspections
 */
const apiClient = axios.create({
  // Backend API
  baseURL: import.meta.env.VITE_API_URL_DEV || 'http://localhost:8000/api',

  // Headers standards pour Laravel
  headers: {
    'Content-Type': 'application/json',
    Accept: 'application/json',
    'X-Requested-With': 'XMLHttpRequest',
  },

  // OBLIGATOIRE pour Sanctum (cookies de session)
  withCredentials: true,
  withXSRFToken: true,
})

/**
 * ================================
 * INTERCEPTEUR GLOBAL
 * ================================
 * 👉 Gestion centralisée des erreurs
 * 👉 En cas de 401, redirection vers login
 */
apiClient.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401) {
      // Évite une boucle infinie si déjà sur /login
      if (!window.location.pathname.includes('/login')) {
        window.location.href = '/auth/login'
      }
    }
    return Promise.reject(error)
  },
)

/**
 * ================================
 * SERVICES API
 * ================================
 * 👉 Un seul point d’entrée pour les appels backend
 */
const api = {
  // ================================
  // AUTHENTIFICATION
  // ================================
  login(credentials) {
    // POST /api/login
    return apiClient.post('auth/login', credentials)
  },

  logout() {
    // POST /api/logout
    return apiClient.post('/logout')
  },

  getUser() {
    // GET /api/user
    return apiClient.get('/user')
  },

  // ================================
  // DASHBOARD
  // ================================
  getDashboard() {
    return apiClient.get('/dashboard')
  },

  // ================================
  // INSPECTIONS
  // ================================
  getInspections(params = {}) {
    return apiClient.get('/inspections', { params })
  },

  getInspection(id) {
    return apiClient.get(`/inspections/${id}`)
  },

  createInspection(data) {
    return apiClient.post('/inspections', data)
  },

  updateInspection(id, data) {
    return apiClient.put(`/inspections/${id}`, data)
  },

  deleteInspection(id) {
    return apiClient.delete(`/inspections/${id}`)
  },

  // ================================
  // IMAGES
  // ================================
  uploadInspectionImages(inspectionId, images, category) {
    const formData = new FormData()

    images.forEach((image, index) => {
      formData.append(`images[${index}]`, image)
    })

    formData.append('category', category)

    return apiClient.post(`/inspections/${inspectionId}/images`, formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    })
  },

  getInspectionImages(inspectionId) {
    return apiClient.get(`/inspections/${inspectionId}/images`)
  },

  deleteImage(imageId) {
    return apiClient.delete(`/images/${imageId}`)
  },

  // ================================
  // RAPPORTS
  // ================================
  generateReport(inspectionId) {
    return apiClient.get(`/inspections/${inspectionId}/report`, { responseType: 'blob' })
  },

  downloadReport(inspectionId) {
    return apiClient.get(`/inspections/${inspectionId}/report/download`, { responseType: 'blob' })
  },
}

/**
 * ================================
 * CLIENT SANCTUM (sans /api)
 * ================================
 * 👉 UTILISÉ UNIQUEMENT pour :
 *    /sanctum/csrf-cookie
 * 👉 IMPORTANT : pas de /api ici
 */
export const sanctumClient = axios.create({
  baseURL: import.meta.env.VITE_API_URL_BASE || 'http://localhost:8000',
  withCredentials: true,
  withXSRFToken: true,
})

/**
 * ================================
 * EXPORTS
 * ================================
 */
export default api
export { apiClient }
