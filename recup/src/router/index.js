import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const routes = [
  /**
   * Route publique
   */
  {
    path: '/login',
    name: 'Login',
    component: () => import('@/views/Login.vue'),
    meta: { 
      requiresAuth: false,
      title: 'Connexion - Inspections'
    },
  },

  /**
   * Routes protégées
   */
  {
    path: '/',
    redirect: '/dashboard',
    meta: { 
      requiresAuth: true,
      title: 'Tableau de Bord - Inspections'
    },
  },
  {
    path: '/dashboard',
    name: 'Dashboard',
    component: () => import('@/views/Dashboard.vue'),
    meta: { 
      requiresAuth: true,
      title: 'Tableau de Bord - Inspections'
    },
  },
  {
    path: '/inspection/new',
    name: 'NewInspection',
    component: () => import('@/views/NewInspection.vue'),
    meta: { 
      requiresAuth: true,
      title: 'Nouvelle Inspection - Inspections'
    },
  },
  {
    path: '/inspections',
    name: 'InspectionHistory',
    component: () => import('@/views/InspectionHistory.vue'),
    meta: { 
      requiresAuth: true,
      title: 'Historique des Inspections - Inspections'
    },
  },
  {
    path: '/inspection/:id',
    name: 'InspectionDetail',
    component: () => import('@/views/InspectionDetail.vue'),
    props: true,
    meta: { 
      requiresAuth: true,
      title: 'Détail de l\'Inspection - Inspections'
    },
  },
  {
    path: '/users',
    name: 'UserList',
    component: () => import('@/views/UserList.vue'),
    meta: { 
      requiresAuth: true,
      title: 'Liste des Utilisateurs - Inspections'
    },
  },

  /**
   * 404
   */
  {
    path: '/:pathMatch(.*)*',
    name: 'NotFound',
    component: () => import('@/views/NotFound.vue'),
    meta: { 
      title: 'Page Non Trouvée - Inspections'
    },
  },
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
})

/**
 * ================================
 * GUARD GLOBAL (TOKEN)
 * ================================
 */
router.beforeEach(async (to) => {
  const authStore = useAuthStore()

  // Si l'utilisateur n'est pas encore initialisé
  if (!authStore.user && localStorage.getItem('auth_token')) {
    await authStore.fetchUser()
  }

  // Accès à une route protégée sans être connecté
  if (to.meta.requiresAuth && !authStore.isAuthenticated) {
    return { name: 'Login' }
  }

  // Utilisateur connecté qui tente d'accéder à /login
  if (to.name === 'Login' && authStore.isAuthenticated) {
    return { name: 'Dashboard' }
  }

  // Mettre à jour le titre de la page
  document.title = to.meta.title || 'Inspections'
})

export default router
