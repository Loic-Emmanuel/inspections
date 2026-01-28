import axios from 'axios'

/**
 * ================================
 * CLIENT API (Sanctum TOKEN)
 * ================================
 * Utilisé pour TOUTES les routes Laravel API protégées par Sanctum token
 * Auth via Authorization: Bearer TOKEN
 */
const apiClient = axios.create({
  baseURL: import.meta.env.VITE_API_URL || 'http://localhost:8000/api/v1',

  headers: {
    'Content-Type': 'application/json',
    Accept: 'application/json',
    'X-Requested-With': 'XMLHttpRequest',
  },
})

/**
 * ================================
 * INTERCEPTEUR REQUEST
 * ================================
 * Injection automatique du token
 */
apiClient.interceptors.request.use((config) => {
  const token = localStorage.getItem('auth_token')

  if (token) {
    config.headers.Authorization = `Bearer ${token}`
  }

  return config
})

/**
 * ================================
 * INTERCEPTEUR RESPONSE
 * ================================
 * Gestion des erreurs globales
 */
apiClient.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401) {
      localStorage.removeItem('auth_token')

      if (!window.location.pathname.includes('/login')) {
        window.location.href = '/login'
      }
    }
    return Promise.reject(error)
  },
)

/**
 * ================================
 * SERVICES API
 * ================================
 */
const api = {
  // ================================
  // AUTHENTIFICATION
  // ================================
  async login(credentials) {
    const response = await apiClient.post('/login', credentials)

    // 🔐 Sauvegarde du token
    if (response.data?.token) {
      localStorage.setItem('auth_token', response.data.token)
    }

    return response
  },

  logout() {
    localStorage.removeItem('auth_token')
    return apiClient.post('/logout')
  },

  getUser() {
    return apiClient.get('/user')
  },

  // ================================
  // DASHBOARD
  // ================================
  getDashboard() {
    return apiClient.get('/stat/month')
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
    return apiClient.get(`/inspections/${inspectionId}/report`, {
      responseType: 'blob',
    })
  },

  downloadReport(inspectionId) {
    return apiClient.get(`/inspections/${inspectionId}/report/download`, {
      responseType: 'blob',
    })
  },
}

/**
 * ================================
 * EXPORTS
 * ================================
 */
export default api
export { apiClient }
