<template>
  <div class="min-h-screen bg-gray-50 pb-20 sm:pb-0">
    <!-- Navbar Desktop -->
    <nav class="hidden sm:block bg-white shadow-sm border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <!-- Logo et navigation -->
          <div class="flex">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
              <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center">
                <!-- <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg> -->
                <img src="/logo.png" alt="Logo du logiciel">
              </div>
              <span class="ml-3 text-xl font-bold text-gray-900">Inspections</span>
            </div>

            <!-- Menu de navigation Desktop -->
            <div class="ml-8 flex space-x-4">
              <router-link :to="{ name: 'Dashboard' }"
                class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md transition" :class="isActive('/dashboard')
                  ? 'text-indigo-600 bg-indigo-50'
                  : 'text-gray-700 hover:text-indigo-600 hover:bg-gray-50'
                  ">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                  </path>
                </svg>
                Tableau de bord
              </router-link>

              <router-link :to="{ name: 'NewInspection' }"
                class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md transition" :class="isActive('/inspection/new')
                  ? 'text-indigo-600 bg-indigo-50'
                  : 'text-gray-700 hover:text-indigo-600 hover:bg-gray-50'
                  ">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nouvelle inspection
              </router-link>

              <router-link :to="{ name: 'InspectionHistory' }"
                class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md transition" :class="isActive('/inspections')
                  ? 'text-indigo-600 bg-indigo-50'
                  : 'text-gray-700 hover:text-indigo-600 hover:bg-gray-50'
                  ">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Historique
              </router-link>

              <router-link :to="{ name: 'UserList' }"
                class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md transition" :class="isActive('/users')
                  ? 'text-indigo-600 bg-indigo-50'
                  : 'text-gray-700 hover:text-indigo-600 hover:bg-gray-50'
                  ">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 20h5v-2a4 4 0 00-4-4h-1m-4 6h-2a4 4 0 01-4-4v-1a4 4 0 014-4h2m4-6a4 4 0 11-8 0 4 4 0 018 0zm6 4a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Utilisateurs
              </router-link>
            </div>
          </div>

          <!-- Menu utilisateur Desktop -->
          <div class="flex items-center">
            <div class="relative" ref="dropdownRef">
              <button @click="toggleDropdown"
                class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <div class="w-9 h-9 bg-indigo-600 rounded-full flex items-center justify-center">
                  <span class="text-white font-medium">{{ userInitials }}</span>
                </div>
                <span class="ml-3 text-gray-700 font-medium hidden md:block">{{ userName }}</span>
                <svg class="ml-2 w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
              </button>

              <!-- Dropdown menu -->
              <div v-if="isDropdownOpen"
                class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 z-10 border border-gray-200">
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                  Mon profil
                </a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                  Paramètres
                </a>
                <hr class="my-1" />
                <button @click="handleLogout"
                  class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                  Déconnexion
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <!-- Header Mobile Simple -->
    <header class="sm:hidden bg-white shadow-sm border-b border-gray-200 fixed top-0 left-0 right-0 z-30">
      <div class="flex items-center justify-between h-14 px-4">
        <!-- Logo Mobile -->
        <div class="flex items-center">
          <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
            <!-- <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg> -->
            <img src="/logo.png" alt="Logo du logiciel">
          </div>
          <span class="ml-2 text-lg font-bold text-gray-900">Inspections</span>
        </div>

        <!-- User Avatar Mobile -->
        <button @click="toggleMobileUserMenu"
          class="w-8 h-8 bg-indigo-600 rounded-full flex items-center justify-center focus:outline-none focus:ring-2 focus:ring-indigo-500">
          <span class="text-white text-sm font-medium">{{ userInitials }}</span>
        </button>
      </div>
    </header>

    <!-- Mobile User Menu Overlay -->
    <div v-if="isMobileUserMenuOpen" @click="toggleMobileUserMenu"
      class="sm:hidden fixed inset-0 bg-black bg-opacity-50 z-40">
      <div @click.stop class="absolute top-14 right-0 left-0 bg-white shadow-lg py-2 mx-4 mt-2 rounded-lg">
        <div v-if="userName" class="px-4 py-3 border-b border-gray-200">
          <p class="text-sm font-medium text-gray-900">{{ userName }}</p>
        </div>
        <a href="#" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50">
          Mon profil
        </a>
        <a href="#" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50">
          Paramètres
        </a>
        <button @click="handleLogout"
          class="block w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50 border-t border-gray-200">
          Déconnexion
        </button>
      </div>
    </div>

    <!-- Contenu principal -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-8 mt-14 sm:mt-0">
      <slot></slot>
    </main>

    <!-- Bottom Navigation Mobile (Style Betclic) -->
    <nav
      class="sm:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-lg z-40 safe-area-bottom">
      <div class="grid grid-cols-4 h-16">
        <!-- Dashboard -->
        <router-link :to="{ name: 'Dashboard' }"
          class="flex flex-col items-center justify-center space-y-1 transition-colors" :class="isActive('/dashboard')
            ? 'text-indigo-600'
            : 'text-gray-600 hover:text-indigo-600'
            ">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
            </path>
          </svg>
          <span class="text-xs font-medium">Accueil</span>
        </router-link>

        <!-- Nouvelle inspection -->
        <router-link :to="{ name: 'NewInspection' }"
          class="flex flex-col items-center justify-center space-y-1 transition-colors" :class="isActive('/inspection/new')
            ? 'text-indigo-600'
            : 'text-gray-600 hover:text-indigo-600'
            ">
          <div class="relative">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
          <span class="text-xs font-medium">Nouvelle</span>
        </router-link>

        <!-- Historique -->
        <router-link :to="{ name: 'InspectionHistory' }"
          class="flex flex-col items-center justify-center space-y-1 transition-colors" :class="isActive('/inspections')
            ? 'text-indigo-600'
            : 'text-gray-600 hover:text-indigo-600'
            ">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
          <span class="text-xs font-medium">Historique</span>
        </router-link>

        <!-- Utilisateurs -->
        <router-link :to="{ name: 'UserList' }"
          class="flex flex-col items-center justify-center space-y-1 transition-colors" :class="isActive('/users')
            ? 'text-indigo-600'
            : 'text-gray-600 hover:text-indigo-600'
            ">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
          </svg>
          <span class="text-xs font-medium">Utilisateurs</span>
        </router-link>
      </div>
    </nav>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const route = useRoute()
const router = useRouter()
const authStore = useAuthStore()

// Dropdown utilisateur Desktop
const isDropdownOpen = ref(false)
const dropdownRef = ref(null)

// Menu utilisateur Mobile
const isMobileUserMenuOpen = ref(false)

/**
 * Données utilisateur depuis Pinia
 */
 const userName = computed(() => {
  if (!authStore.user) return 'Utilisateur'
  return `${authStore.user.name} ${authStore.user.firstname}`
})

const userInitials = computed(() => {
  if (!authStore.user?.name) return 'U'

  return authStore.user.name
    .split(' ')
    .filter(Boolean)
    .map(n => n[0])
    .join('')
    .toUpperCase()
    .slice(0, 2)
})


/**
 * Vérifie si une route est active
 */
const isActive = (path) => route.path.startsWith(path)

/**
 * Dropdown Desktop
 */
const toggleDropdown = () => {
  isDropdownOpen.value = !isDropdownOpen.value
}

/**
 * Menu utilisateur Mobile
 */
const toggleMobileUserMenu = () => {
  isMobileUserMenuOpen.value = !isMobileUserMenuOpen.value
}

const handleClickOutside = (event) => {
  if (dropdownRef.value && !dropdownRef.value.contains(event.target)) {
    isDropdownOpen.value = false
  }
}

/**
 * Déconnexion via Pinia (sécurisé)
 */
const handleLogout = async () => {
  try {
    isMobileUserMenuOpen.value = false
    isDropdownOpen.value = false
    await authStore.logout()
    router.push({ name: 'Login' })
  } catch (error) {
    console.error('Erreur lors de la déconnexion:', error)
  }
}

onMounted(() => {
  document.addEventListener('click', handleClickOutside)
})

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside)
})
</script>

<style scoped>
/* Support pour le safe area sur iOS */
.safe-area-bottom {
  padding-bottom: env(safe-area-inset-bottom);
}

/* Animation pour le menu utilisateur mobile */
@media (max-width: 640px) {
  .fixed {
    -webkit-tap-highlight-color: transparent;
  }
}
</style>