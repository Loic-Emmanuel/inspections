import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

// Layout
import MainLayout from '@/components/MainLayout.vue'

// Vues
import Login from '@/views/Login.vue'
import Dashboard from '@/views/Dashboard.vue'
import NewInspection from '@/views/NewInspection.vue'
import InspectionHistory from '@/views/InspectionHistory.vue'
import InspectionDetail from '@/views/InspectionDetail.vue'

const routes = [
  /**
   * Route publique (sans layout)
   */
  {
    path: '/login',
    name: 'Login',
    component: Login,
    meta: { requiresAuth: false }
  },

  /**
   * Routes protégées (avec MainLayout)
   */
  {
    path: '/',
    component: MainLayout,
    meta: { requiresAuth: true },
    children: [
      {
        path: '',
        redirect: '/dashboard'
      },
      {
        path: 'dashboard',
        name: 'Dashboard',
        component: Dashboard
      },
      {
        path: 'inspection/new',
        name: 'NewInspection',
        component: NewInspection
      },
      {
        path: 'inspections',
        name: 'InspectionHistory',
        component: InspectionHistory
      },
      {
        path: 'inspection/:id',
        name: 'InspectionDetail',
        component: InspectionDetail
      }
    ]
  }
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes
})

/**
 * Guard global d’authentification
 */
router.beforeEach((to, from, next) => {
  const authStore = useAuthStore()

  // Page protégée sans connexion
  if (to.meta.requiresAuth && !authStore.isAuthenticated) {
    next({ name: 'Login' })
    return
  }

  // Utilisateur connecté qui tente d'aller sur /login
  if (to.name === 'Login' && authStore.isAuthenticated) {
    next({ name: 'Dashboard' })
    return
  }

  next()
})

export default router
