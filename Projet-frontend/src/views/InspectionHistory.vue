<template>
  <MainLayout>
    <!-- Header -->
    <div class="mb-4 sm:mb-6 lg:mb-8 px-4 sm:px-0">
      <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900">
        Historique des inspections
      </h1>
      <p class="text-sm sm:text-base text-gray-600 mt-1 sm:mt-2">
        Consultez et recherchez vos inspections passées
      </p>
    </div>

    <!-- Filtres et recherche -->
    <div class="bg-white rounded-lg sm:rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6 mb-4 sm:mb-6 mx-4 sm:mx-0">
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
        <!-- Recherche -->
        <div class="sm:col-span-2">
          <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">
            Recherche
          </label>
          <div class="relative">
            <input 
              v-model="filters.search" 
              type="text" 
              placeholder="Rechercher par lieu..."
              class="w-full pl-9 sm:pl-10 pr-3 sm:pr-4 py-2 sm:py-2.5 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
              @input="applyFilters" 
            />
            <svg 
              class="absolute left-2.5 sm:left-3 top-2 sm:top-2.5 w-4 h-4 sm:w-5 sm:h-5 text-gray-400" 
              fill="none" 
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path 
                stroke-linecap="round" 
                stroke-linejoin="round" 
                stroke-width="2"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
              />
            </svg>
          </div>
        </div>

        <!-- Filtre par type -->
        <div>
          <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">
            Type d'inspection
          </label>
          <input 
            v-model="filters.type" 
            placeholder="Type"
            class="w-full px-3 sm:px-4 py-2 sm:py-2.5 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
            @change="applyFilters"
          />
        </div>

        <!-- Filtre par statut -->
        <div>
          <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">
            Statut
          </label>
          <select 
            v-model="filters.status"
            class="w-full px-3 sm:px-4 py-2 sm:py-2.5 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
            @change="applyFilters"
          >
            <option value="">Tous les statuts</option>
            <option value="conforme">Conforme</option>
            <option value="Non conforme">Non conforme</option>
            <option value="Partiellement conforme">Partiellement conforme</option>
          </select>
        </div>
      </div>

      <!-- Filtres de date -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 mt-3 sm:mt-4">
        <div>
          <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">
            Date de début
          </label>
          <input 
            v-model="filters.dateFrom" 
            type="date"
            class="w-full px-3 sm:px-4 py-2 sm:py-2.5 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
            @change="applyFilters" 
          />
        </div>

        <div>
          <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">
            Date de fin
          </label>
          <input 
            v-model="filters.dateTo" 
            type="date"
            class="w-full px-3 sm:px-4 py-2 sm:py-2.5 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
            @change="applyFilters" 
          />
        </div>

        <div class="flex items-end">
          <button 
            @click="resetFilters"
            class="w-full px-3 sm:px-4 py-2 sm:py-2.5 text-sm sm:text-base border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 active:bg-gray-100 transition"
          >
            Réinitialiser
          </button>
        </div>
      </div>
    </div>

    <!-- Résultats -->
    <div class="bg-white rounded-lg sm:rounded-xl shadow-sm border border-gray-200 mx-4 sm:mx-0">
      <!-- Header du tableau -->
      <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
        <div class="flex items-center justify-between gap-3">
          <p class="text-xs sm:text-sm text-gray-600 flex-shrink-0">
            <span class="font-medium text-gray-900">{{ filteredInspections.length }}</span>
            <span class="hidden xs:inline"> inspection(s)</span>
          </p>
          <div class="flex items-center space-x-1.5 sm:space-x-2">
            <button 
              @click="viewMode = 'grid'" 
              :class="viewMode === 'grid'
                ? 'bg-indigo-100 text-indigo-600'
                : 'text-gray-600 hover:bg-gray-100'
              " 
              class="p-1.5 sm:p-2 rounded-lg transition"
              aria-label="Vue grille"
            >
              <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path 
                  stroke-linecap="round" 
                  stroke-linejoin="round" 
                  stroke-width="2"
                  d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"
                />
              </svg>
            </button>
            <button 
              @click="viewMode = 'list'" 
              :class="viewMode === 'list'
                ? 'bg-indigo-100 text-indigo-600'
                : 'text-gray-600 hover:bg-gray-100'
              " 
              class="p-1.5 sm:p-2 rounded-lg transition"
              aria-label="Vue liste"
            >
              <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path 
                  stroke-linecap="round" 
                  stroke-linejoin="round" 
                  stroke-width="2" 
                  d="M4 6h16M4 12h16M4 18h16"
                />
              </svg>
            </button>
          </div>
        </div>
      </div>

      <!-- Loading state -->
      <div v-if="loading" class="p-8 sm:p-12 text-center">
        <div class="inline-block animate-spin rounded-full h-10 w-10 sm:h-12 sm:w-12 border-4 border-gray-300 border-t-indigo-600">
        </div>
        <p class="text-sm sm:text-base text-gray-600 mt-3 sm:mt-4">Chargement des inspections...</p>
      </div>

      <!-- Empty state -->
      <div v-else-if="filteredInspections.length === 0" class="p-8 sm:p-12 text-center">
        <svg class="w-12 h-12 sm:w-16 sm:h-16 text-gray-300 mx-auto mb-3 sm:mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path 
            stroke-linecap="round" 
            stroke-linejoin="round" 
            stroke-width="2"
            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
          />
        </svg>
        <h3 class="text-base sm:text-lg font-medium text-gray-900 mb-1 sm:mb-2">
          Aucune inspection trouvée
        </h3>
        <p class="text-sm sm:text-base text-gray-600 mb-4 sm:mb-6 px-4">
          Aucune inspection ne correspond à vos critères de recherche
        </p>
        <button 
          @click="resetFilters"
          class="px-4 sm:px-6 py-2 sm:py-2.5 text-sm sm:text-base bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 active:bg-indigo-800 transition"
        >
          Réinitialiser les filtres
        </button>
      </div>

      <!-- Vue grille -->
      <div v-else-if="viewMode === 'grid'" class="p-3 sm:p-4 lg:p-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-4 lg:gap-6">
          <div 
            v-for="inspection in filteredInspections" 
            :key="inspection.id" 
            @click="goToDetail(inspection.id)"
            class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg active:shadow-md transition cursor-pointer group"
          >
            <!-- Image de couverture -->
            <div class="h-36 sm:h-44 lg:h-48 bg-gradient-to-br from-indigo-100 to-purple-100 relative overflow-hidden">
              <img 
                v-if="inspection.cover_image" 
                :src="inspection.cover_image" 
                alt="Cover"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" 
              />
              <div v-else class="flex items-center justify-center h-full">
                <svg class="w-12 h-12 sm:w-14 sm:h-14 lg:w-16 lg:h-16 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path 
                    stroke-linecap="round" 
                    stroke-linejoin="round" 
                    stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                  />
                </svg>
              </div>
              <span 
                class="absolute top-2 sm:top-3 right-2 sm:right-3 px-2 sm:px-3 py-0.5 sm:py-1 text-xs font-medium rounded-full"
                :class="getStatusClass(inspection.status)"
              >
                {{ inspection.status }}
              </span>
            </div>

            <!-- Contenu -->
            <div class="p-3 sm:p-4">
              <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-1.5 sm:mb-2 group-hover:text-indigo-600 transition line-clamp-2">
                {{ inspection.location }}
              </h3>
              <div class="space-y-1.5 sm:space-y-2 text-xs sm:text-sm text-gray-600">
                <div class="flex items-center">
                  <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path 
                      stroke-linecap="round" 
                      stroke-linejoin="round" 
                      stroke-width="2"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                    />
                  </svg>
                  <span class="truncate">{{ formatDate(inspection.date) }}</span>
                </div>
                <div class="flex items-center">
                  <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path 
                      stroke-linecap="round" 
                      stroke-linejoin="round" 
                      stroke-width="2"
                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                    />
                  </svg>
                  <span class="truncate">{{ inspection.farmer_name }}</span>
                </div>
                <div class="flex items-center">
                  <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path 
                      stroke-linecap="round" 
                      stroke-linejoin="round" 
                      stroke-width="2"
                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                    />
                  </svg>
                  {{ inspection.images_count }} images
                </div>
              </div>

              <div class="mt-3 sm:mt-4 pt-3 sm:pt-4 border-t border-gray-200 flex items-center justify-between gap-2">
                <span class="text-xs font-medium text-gray-500 uppercase truncate">
                  {{ inspection.type }}
                </span>
                <button class="text-indigo-600 hover:text-indigo-700 font-medium text-xs sm:text-sm whitespace-nowrap flex-shrink-0">
                  Voir détails →
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Vue liste -->
      <div v-else class="divide-y divide-gray-200">
        <div 
          v-for="inspection in filteredInspections" 
          :key="inspection.id" 
          @click="goToDetail(inspection.id)"
          class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 lg:py-5 hover:bg-gray-50 active:bg-gray-100 transition cursor-pointer"
        >
          <div class="flex items-center justify-between gap-2 sm:gap-3">
            <div class="flex items-center space-x-2 sm:space-x-3 lg:space-x-4 flex-1 min-w-0">
              <!-- Thumbnail -->
              <div class="w-12 h-12 sm:w-14 sm:h-14 lg:w-16 lg:h-16 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-lg overflow-hidden flex-shrink-0">
                <img 
                  v-if="inspection.cover_image" 
                  :src="inspection.cover_image" 
                  alt="Cover"
                  class="w-full h-full object-cover" 
                />
                <div v-else class="flex items-center justify-center h-full">
                  <svg class="w-6 h-6 sm:w-7 sm:h-7 lg:w-8 lg:h-8 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path 
                      stroke-linecap="round" 
                      stroke-linejoin="round" 
                      stroke-width="2"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                  </svg>
                </div>
              </div>

              <!-- Informations -->
              <div class="flex-1 min-w-0">
                <div class="flex items-center flex-wrap gap-1.5 sm:gap-2 mb-1">
                  <h3 class="text-sm sm:text-base font-bold text-gray-900 truncate">
                    {{ inspection.location }}
                  </h3>
                  <span 
                    class="px-2 py-0.5 text-xs font-medium rounded-full flex-shrink-0"
                    :class="getStatusClass(inspection.status)"
                  >
                    {{ inspection.status }}
                  </span>
                </div>
                <div class="flex flex-wrap items-center gap-x-2 sm:gap-x-3 lg:gap-x-4 gap-y-1 text-xs sm:text-sm text-gray-600">
                  <span class="flex items-center flex-shrink-0">
                    <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path 
                        stroke-linecap="round" 
                        stroke-linejoin="round" 
                        stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                      />
                    </svg>
                    <span class="hidden sm:inline">{{ formatDate(inspection.date) }}</span>
                    <span class="sm:hidden">{{ formatDateShort(inspection.date) }}</span>
                  </span>
                  <span class="flex items-center truncate">
                    <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path 
                        stroke-linecap="round" 
                        stroke-linejoin="round" 
                        stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                      />
                    </svg>
                    {{ inspection.farmer_name }}
                  </span>
                  <span class="flex items-center flex-shrink-0">
                    <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path 
                        stroke-linecap="round" 
                        stroke-linejoin="round" 
                        stroke-width="2"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                      />
                    </svg>
                    {{ inspection.images_count }}
                  </span>
                  <span class="hidden lg:inline text-xs font-medium text-gray-500 uppercase truncate">
                    {{ inspection.type }}
                  </span>
                </div>
              </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center space-x-1 sm:space-x-2 flex-shrink-0">
              <button 
                @click.stop="downloadReport(inspection.id)"
                class="p-1.5 sm:p-2 text-gray-600 hover:bg-gray-100 active:bg-gray-200 rounded-lg transition" 
                title="Télécharger le rapport"
                aria-label="Télécharger le rapport"
              >
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path 
                    stroke-linecap="round" 
                    stroke-linejoin="round" 
                    stroke-width="2"
                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                  />
                </svg>
              </button>
              <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
            </div>
          </div>
        </div>
      </div>

      <!-- Pagination -->
      <div v-if="filteredInspections.length > 0" class="px-4 sm:px-6 py-3 sm:py-4 border-t border-gray-200">
        <div class="flex items-center justify-between">
          <p class="text-xs sm:text-sm text-gray-600">
            <span class="hidden sm:inline">Affichage de <span class="font-medium">1</span> à </span>
            <span class="font-medium">{{ filteredInspections.length }}</span>
            <span class="hidden sm:inline"> sur <span class="font-medium">{{ filteredInspections.length }}</span> résultats</span>
          </p>
        </div>
      </div>
    </div>
  </MainLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'
import MainLayout from '../components/MainLayout.vue'

const router = useRouter()

const inspections = ref([])
const loading = ref(true)
const viewMode = ref('grid') // 'grid' ou 'list'

const filters = ref({
  search: '',
  type: '',
  status: '',
  dateFrom: '',
  dateTo: '',
})

const fetchInspections = async () => {
  try {
    const response = await axios.get('/api/inspections')
    inspections.value = response.data.inspections
  } catch (error) {
    console.error('Erreur lors du chargement des inspections:', error)
  } finally {
    loading.value = false
  }
}

const filteredInspections = computed(() => {
  let result = [...inspections.value]

  // Filtre par recherche
  if (filters.value.search) {
    const searchLower = filters.value.search.toLowerCase()
    result = result.filter(
      (i) =>
        i.location.toLowerCase().includes(searchLower) ||
        i.farmer_name.toLowerCase().includes(searchLower),
    )
  }

  // Filtre par type
  if (filters.value.type) {
    result = result.filter((i) => i.type === filters.value.type)
  }

  // Filtre par statut
  if (filters.value.status) {
    result = result.filter((i) => i.status === filters.value.status)
  }

  // Filtre par date de début
  if (filters.value.dateFrom) {
    result = result.filter((i) => new Date(i.date) >= new Date(filters.value.dateFrom))
  }

  // Filtre par date de fin
  if (filters.value.dateTo) {
    result = result.filter((i) => new Date(i.date) <= new Date(filters.value.dateTo))
  }

  return result
})

const applyFilters = () => {
  // Les filtres sont appliqués automatiquement via computed
}

const resetFilters = () => {
  filters.value = {
    search: '',
    type: '',
    status: '',
    dateFrom: '',
    dateTo: '',
  }
}

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('fr-FR', {
    day: '2-digit',
    month: 'long',
    year: 'numeric',
  })
}

const formatDateShort = (date) => {
  return new Date(date).toLocaleDateString('fr-FR', {
    day: '2-digit',
    month: 'short',
    year: 'numeric',
  })
}

const getStatusClass = (status) => {
  const classes = {
    Complétée: 'bg-green-100 text-green-800',
    'En cours': 'bg-yellow-100 text-yellow-800',
    Brouillon: 'bg-gray-100 text-gray-800',
  }
  return classes[status] || 'bg-gray-100 text-gray-800'
}

const goToDetail = (id) => {
  router.push({ name: 'InspectionDetail', params: { id } })
}

const downloadReport = async (id) => {
  try {
    const response = await axios.get(`/api/inspections/${id}/report`, {
      responseType: 'blob',
    })

    const url = window.URL.createObjectURL(new Blob([response.data]))
    const link = document.createElement('a')
    link.href = url
    link.setAttribute('download', `rapport-inspection-${id}.pdf`)
    document.body.appendChild(link)
    link.click()
    link.remove()
  } catch (error) {
    console.error('Erreur lors du téléchargement du rapport:', error)
    alert('Erreur lors du téléchargement du rapport')
  }
}

onMounted(() => {
  fetchInspections()
})
</script>

<style scoped>
/* Utilities pour une meilleure responsivité */
@media (max-width: 640px) {
  /* Pour très petits écrans */
  .xs\:inline {
    display: inline;
  }
}

/* Amélioration du line-clamp pour supporter plus de navigateurs */
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>