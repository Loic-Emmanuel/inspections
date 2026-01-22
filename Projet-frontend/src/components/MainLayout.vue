<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <!-- Logo et navigation -->
          <div class="flex">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
              <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
              </div>
              <span class="ml-3 text-xl font-bold text-gray-900">Inspections</span>
            </div>

            <!-- Menu de navigation -->
            <div class="hidden sm:ml-8 sm:flex sm:space-x-4">
              <router-link to="/dashboard"
                class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md transition"
                :class="isActive('/dashboard') ? 'text-indigo-600 bg-indigo-50' : 'text-gray-700 hover:text-indigo-600 hover:bg-gray-50'">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                  </path>
                </svg>
                Tableau de bord
              </router-link>

              <router-link to="/inspection/new"
                class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md transition"
                :class="isActive('/inspection/new') ? 'text-indigo-600 bg-indigo-50' : 'text-gray-700 hover:text-indigo-600 hover:bg-gray-50'">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nouvelle inspection
              </router-link>

              <router-link to="/inspections"
                class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md transition"
                :class="isActive('/inspections') ? 'text-indigo-600 bg-indigo-50' : 'text-gray-700 hover:text-indigo-600 hover:bg-gray-50'">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Historique
              </router-link>
            </div>
          </div>

          <!-- Menu utilisateur -->
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
                <hr class="my-1">
                <button @click="handleLogout"
                  class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                  Déconnexion
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Mobile menu -->
      <div class="sm:hidden border-t border-gray-200">
        <div class="px-2 pt-2 pb-3 space-y-1">
          <router-link to="/dashboard" class="block px-3 py-2 rounded-md text-base font-medium"
            :class="isActive('/dashboard') ? 'text-indigo-600 bg-indigo-50' : 'text-gray-700 hover:bg-gray-50'">
            Tableau de bord
          </router-link>
          <router-link to="/inspection/new" class="block px-3 py-2 rounded-md text-base font-medium"
            :class="isActive('/inspection/new') ? 'text-indigo-600 bg-indigo-50' : 'text-gray-700 hover:bg-gray-50'">
            Nouvelle inspection
          </router-link>
          <router-link to="/inspections" class="block px-3 py-2 rounded-md text-base font-medium"
            :class="isActive('/inspections') ? 'text-indigo-600 bg-indigo-50' : 'text-gray-700 hover:bg-gray-50'">
            Historique
          </router-link>
        </div>
      </div>
    </nav>

    <!-- Contenu principal -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <slot></slot>
    </main>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { useRoute } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const route = useRoute()
const authStore = useAuthStore()

// Dropdown utilisateur
const isDropdownOpen = ref(false)
const dropdownRef = ref(null)

/**
 * Données utilisateur depuis Pinia
 */
const userName = computed(() => authStore.user?.name || 'Utilisateur')

const userInitials = computed(() => {
  return userName.value
    .split(' ')
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
 * Dropdown
 */
const toggleDropdown = () => {
  isDropdownOpen.value = !isDropdownOpen.value
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
  await authStore.logout()
}

onMounted(() => {
  document.addEventListener('click', handleClickOutside)
})

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside)
})
</script>
