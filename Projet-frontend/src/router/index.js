import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

// Vues
import Login from '@/views/Login.vue'
import Dashboard from '@/views/Dashboard.vue'
import NewInspection from '@/views/NewInspection.vue'
import InspectionHistory from '@/views/InspectionHistory.vue'
import InspectionDetail from '@/views/InspectionDetail.vue'
import NotFound from '@/views/NotFound.vue'
import UserList from '@/views/UserList.vue'


const routes = [
  /**
   * Route publique
   */
  {
    path: '/login',
    name: 'Login',
    component: Login,
    meta: { requiresAuth: false },
  },

  /**
   * Routes protégées (indépendantes)
   */
  {
    path: '/',
    redirect: '/dashboard',
    meta: { requiresAuth: false },
  },
  {
    path: '/dashboard',
    name: 'Dashboard',
    component: Dashboard,
    meta: { requiresAuth: false },
  },
  {
    path: '/inspection/new',
    name: 'NewInspection',
    component: NewInspection,
    meta: { requiresAuth: false },
  },
  {
    path: '/inspections',
    name: 'InspectionHistory',
    component: InspectionHistory,
    meta: { requiresAuth: false },
  },
  {
    path: '/inspection/:id',
    name: 'InspectionDetail',
    component: InspectionDetail,
    props: true,
    meta: { requiresAuth: false },
  },
  {
    path: '/users',
    name: 'UserList',
    component: UserList,
    meta: { requiresAuth: false },
  },
  {
    path: '/:pathMatch(.*)*',
    name: 'NotFound',
    component: NotFound
  }
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
})

/**
 * Guard global d’authentification
 */
router.beforeEach((to, from, next) => {
  const authStore = useAuthStore()

  // Accès à une route protégée sans être connecté
  if (to.meta.requiresAuth && !authStore.isAuthenticated) {
    return next({ name: 'Login' })
  }

  // Utilisateur connecté qui tente d'accéder à /login
  if (to.name === 'Login' && authStore.isAuthenticated) {
    return next({ name: 'Dashboard' })
  }

  next()
})

export default router
