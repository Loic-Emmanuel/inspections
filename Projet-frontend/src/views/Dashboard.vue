<template>
  <MainLayout>
    <div class="min-h-screen bg-gray-50">
      <!-- Contenu principal -->
      <main class="w-full max-w-7xl mx-auto px-3 sm:px-4 md:px-6 lg:px-8 py-4 sm:py-6 lg:py-8">
        <!-- Header -->
        <div class="mb-6 sm:mb-8">
          <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900">Tableau de bord</h1>
          <p class="text-sm sm:text-base text-gray-600 mt-1 sm:mt-2">Vue d'ensemble de vos inspections</p>
        </div>

        <!-- Statistiques -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6 mb-6 sm:mb-8">
          <!-- Total Inspections -->
          <div class="bg-white rounded-lg sm:rounded-xl shadow-sm p-4 sm:p-6 border border-gray-200">
            <div class="flex items-center justify-between">
              <div class="flex-1 min-w-0">
                <p class="text-xs sm:text-sm text-gray-600 font-medium truncate">Total inspections</p>
                <p class="text-2xl sm:text-3xl font-bold text-gray-900 mt-1 sm:mt-2">{{ stats.total }}</p>
              </div>
              <div class="w-10 h-10 sm:w-12 sm:h-12 bg-indigo-100 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
              </div>
            </div>
            <div class="mt-3 sm:mt-4 flex items-center text-xs sm:text-sm">
              <span class="text-green-600 font-medium">+12%</span>
              <span class="text-gray-600 ml-2">ce mois-ci</span>
            </div>
          </div>

          <!-- Inspections ce mois -->
          <div class="bg-white rounded-lg sm:rounded-xl shadow-sm p-4 sm:p-6 border border-gray-200">
            <div class="flex items-center justify-between">
              <div class="flex-1 min-w-0">
                <p class="text-xs sm:text-sm text-gray-600 font-medium truncate">Ce mois</p>
                <p class="text-2xl sm:text-3xl font-bold text-gray-900 mt-1 sm:mt-2">{{ stats.thisMonth }}</p>
              </div>
              <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
              </div>
            </div>
            <div class="mt-3 sm:mt-4 flex items-center text-xs sm:text-sm">
              <span class="text-green-600 font-medium">+8%</span>
              <span class="text-gray-600 ml-2">vs mois dernier</span>
            </div>
          </div>

          <!-- Images ajoutées -->
          <div class="bg-white rounded-lg sm:rounded-xl shadow-sm p-4 sm:p-6 border border-gray-200">
            <div class="flex items-center justify-between">
              <div class="flex-1 min-w-0">
                <p class="text-xs sm:text-sm text-gray-600 font-medium truncate">Images</p>
                <p class="text-2xl sm:text-3xl font-bold text-gray-900 mt-1 sm:mt-2">{{ stats.images }}</p>
              </div>
              <div class="w-10 h-10 sm:w-12 sm:h-12 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                  </path>
                </svg>
              </div>
            </div>
            <div class="mt-3 sm:mt-4 flex items-center text-xs sm:text-sm">
              <span class="text-gray-600">Total uploadées</span>
            </div>
          </div>

          <!-- Rapports générés -->
          <div class="bg-white rounded-lg sm:rounded-xl shadow-sm p-4 sm:p-6 border border-gray-200">
            <div class="flex items-center justify-between">
              <div class="flex-1 min-w-0">
                <p class="text-xs sm:text-sm text-gray-600 font-medium truncate">Rapports</p>
                <p class="text-2xl sm:text-3xl font-bold text-gray-900 mt-1 sm:mt-2">{{ stats.reports }}</p>
              </div>
              <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                  </path>
                </svg>
              </div>
            </div>
            <div class="mt-3 sm:mt-4 flex items-center text-xs sm:text-sm">
              <span class="text-gray-600">PDFs générés</span>
            </div>
          </div>
        </div>

        <!-- Actions rapides -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 mb-6 sm:mb-8">
          <!-- Nouvelle inspection -->
          <router-link to="/inspection/new"
            class="bg-gradient-to-r from-indigo-600 to-indigo-700 rounded-lg sm:rounded-xl shadow-lg p-6 sm:p-8 text-white hover:from-indigo-700 hover:to-indigo-800 transition group">
            <div class="flex items-start sm:items-center justify-between gap-4">
              <div class="flex-1 min-w-0">
                <h3 class="text-lg sm:text-xl font-bold mb-1 sm:mb-2">Créer une inspection</h3>
                <p class="text-sm sm:text-base text-indigo-100">Démarrer une nouvelle inspection avec ajout d'images</p>
              </div>
              <div
                class="w-12 h-12 sm:w-14 sm:h-14 bg-white/20 rounded-full flex items-center justify-center group-hover:bg-white/30 transition flex-shrink-0">
                <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
              </div>
            </div>
          </router-link>

          <!-- Voir l'historique -->
          <router-link to="/inspections"
            class="bg-white rounded-lg sm:rounded-xl shadow-sm p-6 sm:p-8 border-2 border-gray-200 hover:border-indigo-300 hover:shadow-md transition group">
            <div class="flex items-start sm:items-center justify-between gap-4">
              <div class="flex-1 min-w-0">
                <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-1 sm:mb-2">Consulter l'historique</h3>
                <p class="text-sm sm:text-base text-gray-600">Accéder aux inspections passées et leurs rapports</p>
              </div>
              <div
                class="w-12 h-12 sm:w-14 sm:h-14 bg-gray-100 rounded-full flex items-center justify-center group-hover:bg-indigo-100 transition flex-shrink-0">
                <svg class="w-6 h-6 sm:w-7 sm:h-7 text-gray-600 group-hover:text-indigo-600 transition" fill="none"
                  stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
              </div>
            </div>
          </router-link>
        </div>

        <!-- Inspections récentes -->
        <div class="bg-white rounded-lg sm:rounded-xl shadow-sm border border-gray-200">
          <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-200">
            <div class="flex items-center justify-between gap-4">
              <h2 class="text-base sm:text-lg font-bold text-gray-900">Inspections récentes</h2>
              <router-link to="/inspections" class="text-xs sm:text-sm text-indigo-600 hover:text-indigo-700 font-medium whitespace-nowrap">
                Voir tout →
              </router-link>
            </div>
          </div>

          <div v-if="loading" class="p-6 sm:p-8 text-center">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-gray-300 border-t-indigo-600">
            </div>
            <p class="text-sm sm:text-base text-gray-600 mt-4">Chargement...</p>
          </div>

          <div v-else-if="recentInspections.length === 0" class="p-6 sm:p-8 text-center">
            <svg class="w-12 h-12 sm:w-16 sm:h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
              </path>
            </svg>
            <p class="text-sm sm:text-base text-gray-600">Aucune inspection récente</p>
          </div>

          <div v-else class="divide-y divide-gray-200">
            <div v-for="inspection in recentInspections" :key="inspection.id"
              class="px-4 sm:px-6 py-3 sm:py-4 hover:bg-gray-50 transition cursor-pointer" @click="goToInspection(inspection.id)">
              <div class="flex items-center justify-between gap-3">
                <div class="flex-1 min-w-0">
                  <div class="flex flex-wrap items-center gap-2 sm:gap-3 mb-1 sm:mb-0">
                    <h3 class="text-sm sm:text-base font-semibold text-gray-900 truncate">{{ inspection.location }}</h3>
                    <span class="px-2 py-0.5 sm:py-1 text-xs font-medium rounded-full flex-shrink-0" :class="getStatusClass(inspection.status)">
                      {{ inspection.status }}
                    </span>
                  </div>
                  <div class="mt-1 sm:mt-1.5 flex flex-wrap items-center gap-x-3 gap-y-1 text-xs sm:text-sm text-gray-600">
                    <span class="flex items-center">
                      <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                      </svg>
                      <span class="truncate">{{ formatDate(inspection.date) }}</span>
                    </span>
                    <span class="flex items-center">
                      <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                      </svg>
                      {{ inspection.images_count }} images
                    </span>
                  </div>
                </div>
                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </MainLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/services/api'
import MainLayout from '@/components/MainLayout.vue'

const router = useRouter()

const loading = ref(true)

const stats = ref({
  total: 0,
  thisMonth: 0,
  images: 0,
  reports: 0,
})

const recentInspections = ref([])

const fetchDashboardData = async () => {
  loading.value = true

  try {
    const { data } = await api.getDashboard()
    console.log(data)

    stats.value = data.stats ?? stats.value
    recentInspections.value = data.recent_inspections ?? []
  } catch (error) {
    console.error('Erreur chargement dashboard:', error)
  } finally {
    loading.value = false
  }
}

const formatDate = (date) =>
  new Date(date).toLocaleDateString('fr-FR', {
    day: '2-digit',
    month: 'long',
    year: 'numeric',
  })

const getStatusClass = (status) => {
  const map = {
    Complétée: 'bg-green-100 text-green-800',
    'En cours': 'bg-yellow-100 text-yellow-800',
    Brouillon: 'bg-gray-100 text-gray-800',
  }
  return map[status] || 'bg-gray-100 text-gray-800'
}

const goToInspection = (id) => {
  router.push({ name: 'InspectionDetail', params: { id } })
}

onMounted(fetchDashboardData)
</script>