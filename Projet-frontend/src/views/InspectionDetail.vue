<template>
  <MainLayout>
    <!-- Loading state -->
    <div v-if="loading" class="flex items-center justify-center py-20">
      <div class="text-center">
        <div
          class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-gray-300 border-t-indigo-600 mb-4"
        ></div>
        <p class="text-gray-600">Chargement de l'inspection...</p>
      </div>
    </div>

    <!-- Contenu principal -->
    <div v-else-if="inspection">
      <!-- Header avec actions -->
      <div class="flex items-center justify-between mb-8">
        <div>
          <button
            @click="$router.back()"
            class="flex items-center text-gray-600 hover:text-gray-900 mb-3 transition"
          >
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M15 19l-7-7 7-7"
              ></path>
            </svg>
            Retour
          </button>
          <h1 class="text-3xl font-bold text-gray-900">{{ inspection.location }}</h1>
          <div class="flex items-center space-x-4 mt-2">
            <span
              class="px-3 py-1 text-sm font-medium rounded-full"
              :class="getStatusClass(inspection.status)"
            >
              {{ inspection.status }}
            </span>
            <span class="text-gray-600">{{ formatDate(inspection.date) }}</span>
          </div>
        </div>

        <div class="flex items-center space-x-3">
          <button
            @click="downloadReport"
            class="flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition"
          >
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
              ></path>
            </svg>
            Télécharger le rapport
          </button>
          <button
            class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition"
            title="Partager"
          >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"
              ></path>
            </svg>
          </button>
        </div>
      </div>

      <!-- Grille d'informations -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Informations principales -->
        <div class="lg:col-span-2 space-y-6">
          <!-- Carte d'informations générales -->
          <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Informations générales</h2>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="text-sm font-medium text-gray-500">Type d'inspection</label>
                <p class="text-base font-semibold text-gray-900 mt-1">{{ inspection.type }}</p>
              </div>
              <div>
                <label class="text-sm font-medium text-gray-500">Date</label>
                <p class="text-base font-semibold text-gray-900 mt-1">
                  {{ formatDate(inspection.date) }}
                </p>
              </div>
              <div>
                <label class="text-sm font-medium text-gray-500">Éleveur</label>
                <p class="text-base font-semibold text-gray-900 mt-1">
                  {{ inspection.farmer_name }}
                </p>
              </div>
              <div>
                <label class="text-sm font-medium text-gray-500">Lieu</label>
                <p class="text-base font-semibold text-gray-900 mt-1">{{ inspection.location }}</p>
              </div>
              <div v-if="inspection.farming_type">
                <label class="text-sm font-medium text-gray-500">Type d'élevage</label>
                <p class="text-base font-semibold text-gray-900 mt-1">
                  {{ inspection.farming_type }}
                </p>
              </div>
              <div v-if="inspection.animal_count">
                <label class="text-sm font-medium text-gray-500">Nombre d'animaux</label>
                <p class="text-base font-semibold text-gray-900 mt-1">
                  {{ inspection.animal_count }}
                </p>
              </div>
            </div>
          </div>

          <!-- Observations -->
          <div
            v-if="inspection.observations"
            class="bg-white rounded-xl shadow-sm border border-gray-200 p-6"
          >
            <h2 class="text-xl font-bold text-gray-900 mb-4">Observations</h2>
            <p class="text-gray-700 leading-relaxed whitespace-pre-line">
              {{ inspection.observations }}
            </p>
          </div>

          <!-- Recommandations -->
          <div
            v-if="inspection.recommendations"
            class="bg-white rounded-xl shadow-sm border border-gray-200 p-6"
          >
            <h2 class="text-xl font-bold text-gray-900 mb-4">Recommandations</h2>
            <p class="text-gray-700 leading-relaxed whitespace-pre-line">
              {{ inspection.recommendations }}
            </p>
          </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
          <!-- Carte de conformité -->
          <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Conformité</h3>
            <div class="text-center">
              <div
                class="w-24 h-24 mx-auto rounded-full flex items-center justify-center mb-3"
                :class="getComplianceColor(inspection.compliance)"
              >
                <svg
                  v-if="inspection.compliance === 'Conforme'"
                  class="w-12 h-12 text-green-600"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M5 13l4 4L19 7"
                  ></path>
                </svg>
                <svg
                  v-else-if="inspection.compliance === 'Non conforme'"
                  class="w-12 h-12 text-red-600"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M6 18L18 6M6 6l12 12"
                  ></path>
                </svg>
                <svg
                  v-else
                  class="w-12 h-12 text-yellow-600"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                  ></path>
                </svg>
              </div>
              <p class="text-lg font-bold text-gray-900">
                {{ inspection.compliance || 'Non définie' }}
              </p>
            </div>
          </div>

          <!-- Statistiques -->
          <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Statistiques</h3>
            <div class="space-y-3">
              <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">Images totales</span>
                <span class="text-lg font-bold text-gray-900">{{
                  inspection.images_count || 0
                }}</span>
              </div>
              <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">Catégories</span>
                <span class="text-lg font-bold text-gray-900">{{
                  inspection.categories?.length || 0
                }}</span>
              </div>
              <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">Inspecteur</span>
                <span class="text-sm font-semibold text-gray-900">{{
                  inspection.inspector_name || 'N/A'
                }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Galerie d'images par catégorie -->
      <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Galerie d'images</h2>

        <div v-if="inspection.categories && inspection.categories.length > 0" class="space-y-8">
          <div v-for="category in inspection.categories" :key="category.id">
            <div class="flex items-center justify-between mb-4">
              <h3 class="text-lg font-semibold text-gray-900">{{ category.name }}</h3>
              <span class="text-sm text-gray-600">{{ category.images.length }} image(s)</span>
            </div>

            <div
              v-if="category.images.length > 0"
              class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"
            >
              <div
                v-for="(image, index) in category.images"
                :key="image.id"
                @click="openLightbox(category.images, index)"
                class="relative group cursor-pointer overflow-hidden rounded-lg border border-gray-200 hover:border-indigo-400 transition"
              >
                <img
                  :src="image.url"
                  :alt="`Image ${index + 1}`"
                  class="w-full h-48 object-cover group-hover:scale-110 transition duration-300"
                />
                <div
                  class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition flex items-center justify-center"
                >
                  <svg
                    class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"
                    ></path>
                  </svg>
                </div>
              </div>
            </div>

            <div v-else class="text-center py-8 text-gray-500">
              Aucune image dans cette catégorie
            </div>
          </div>
        </div>

        <div v-else class="text-center py-12">
          <svg
            class="w-16 h-16 text-gray-300 mx-auto mb-4"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
            ></path>
          </svg>
          <p class="text-gray-600">Aucune image disponible pour cette inspection</p>
        </div>
      </div>
    </div>

    <!-- Lightbox / Modal pour afficher les images en grand -->
    <Teleport to="body">
      <div
        v-if="lightboxOpen"
        class="fixed inset-0 z-50 bg-black bg-opacity-90 flex items-center justify-center"
        @click="closeLightbox"
      >
        <button
          @click="closeLightbox"
          class="absolute top-4 right-4 text-white hover:text-gray-300 transition"
        >
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M6 18L18 6M6 6l12 12"
            ></path>
          </svg>
        </button>

        <!-- Navigation précédente -->
        <button
          v-if="currentLightboxImages.length > 1"
          @click.stop="previousImage"
          class="absolute left-4 text-white hover:text-gray-300 transition"
        >
          <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M15 19l-7-7 7-7"
            ></path>
          </svg>
        </button>

        <!-- Image principale -->
        <div class="max-w-6xl max-h-screen p-8" @click.stop>
          <img
            :src="currentLightboxImages[currentLightboxIndex]?.url"
            alt="Image en grand"
            class="max-w-full max-h-[85vh] object-contain rounded-lg"
          />
          <p class="text-white text-center mt-4">
            Image {{ currentLightboxIndex + 1 }} / {{ currentLightboxImages.length }}
          </p>
        </div>

        <!-- Navigation suivante -->
        <button
          v-if="currentLightboxImages.length > 1"
          @click.stop="nextImage"
          class="absolute right-4 text-white hover:text-gray-300 transition"
        >
          <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M9 5l7 7-7 7"
            ></path>
          </svg>
        </button>
      </div>
    </Teleport>
  </MainLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import axios from 'axios'
import MainLayout from '../components/MainLayout.vue'

const route = useRoute()

const inspection = ref(null)
const loading = ref(true)

// Lightbox
const lightboxOpen = ref(false)
const currentLightboxImages = ref([])
const currentLightboxIndex = ref(0)

const fetchInspection = async () => {
  try {
    const response = await axios.get(`/api/inspections/${route.params.id}`)
    inspection.value = response.data
  } catch (error) {
    console.error("Erreur lors du chargement de l'inspection:", error)
  } finally {
    loading.value = false
  }
}

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('fr-FR', {
    day: '2-digit',
    month: 'long',
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

const getComplianceColor = (compliance) => {
  const colors = {
    Conforme: 'bg-green-100',
    'Non conforme': 'bg-red-100',
    'Partiellement conforme': 'bg-yellow-100',
  }
  return colors[compliance] || 'bg-gray-100'
}

const downloadReport = async () => {
  try {
    const response = await axios.get(`/api/inspections/${route.params.id}/report`, {
      responseType: 'blob',
    })

    const url = window.URL.createObjectURL(new Blob([response.data]))
    const link = document.createElement('a')
    link.href = url
    link.setAttribute('download', `rapport-inspection-${route.params.id}.pdf`)
    document.body.appendChild(link)
    link.click()
    link.remove()
  } catch (error) {
    console.error('Erreur lors du téléchargement du rapport:', error)
    alert('Erreur lors du téléchargement du rapport')
  }
}

const openLightbox = (images, index) => {
  currentLightboxImages.value = images
  currentLightboxIndex.value = index
  lightboxOpen.value = true
}

const closeLightbox = () => {
  lightboxOpen.value = false
}

const previousImage = () => {
  if (currentLightboxIndex.value > 0) {
    currentLightboxIndex.value--
  } else {
    currentLightboxIndex.value = currentLightboxImages.value.length - 1
  }
}

const nextImage = () => {
  if (currentLightboxIndex.value < currentLightboxImages.value.length - 1) {
    currentLightboxIndex.value++
  } else {
    currentLightboxIndex.value = 0
  }
}

onMounted(() => {
  fetchInspection()
})
</script>
