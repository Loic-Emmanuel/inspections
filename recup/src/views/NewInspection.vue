<template>
  <MainLayout>
    <div class="w-full px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8">
      <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6 sm:mb-8">
          <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900">
            Nouvelle inspection
          </h1>
          <p class="text-sm sm:text-base text-gray-600 mt-1 sm:mt-2">
            Créez une inspection en suivant les étapes ci-dessous
          </p>
        </div>

        <!-- Progress Steps -->
        <div class="mb-6 sm:mb-8 overflow-x-auto pb-2">
          <div class="flex items-center justify-between min-w-max sm:min-w-0">
            <div v-for="(step, index) in steps" :key="index" class="flex items-center"
              :class="{ 'flex-1': index < steps.length - 1 }">
              <div class="flex flex-col items-center">
                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center border-2 transition"
                  :class="getStepClass(index)">
                  <svg v-if="index < currentStep" class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span v-else class="text-xs sm:text-sm font-semibold">{{ index + 1 }}</span>
                </div>
                <span class="text-xs sm:text-sm mt-1 sm:mt-2 font-medium text-center max-w-[80px] sm:max-w-none"
                  :class="index <= currentStep ? 'text-indigo-600' : 'text-gray-500'">
                  {{ step }}
                </span>
              </div>
              <div v-if="index < steps.length - 1" class="flex-1 h-0.5 mx-2 sm:mx-4"
                :class="index < currentStep ? 'bg-indigo-600' : 'bg-gray-300'"></div>
            </div>
          </div>
        </div>

        <!-- Formulaire -->
        <div class="bg-white rounded-lg sm:rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6 lg:p-8">
          <!-- Étape 1: Informations générales -->
          <div v-if="currentStep === 0">
            <h2 class="text-lg sm:text-xl font-bold text-gray-900 mb-4 sm:mb-6">
              Informations générales
            </h2>

            <div class="space-y-4 sm:space-y-6">
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">
                    Date d'inspection <span class="text-red-500">*</span>
                  </label>
                  <input v-model="form.date_inspection" type="date" required
                    class="w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent" />
                </div>

                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">
                    Type d'inspection <span class="text-red-500">*</span>
                  </label>
                  <input v-model="form.type_inspection" type="text" required placeholder="Ex: Inspection sanitaire"
                    class="w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent" />
                </div>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Lieu d'inspection <span class="text-red-500">*</span>
                </label>
                <input v-model="form.lieu_inspection" type="text" required placeholder="Entrez le lieu de l'inspection"
                  class="w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent" />
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Nom du responsable <span class="text-red-500">*</span>
                </label>
                <input v-model="form.responsible_name" type="text" required placeholder="Nom complet du responsable"
                  class="w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent" />
              </div>
            </div>
          </div>

          <!-- Étape 2: Ajout d'images -->
          <div v-if="currentStep === 1">
            <h2 class="text-lg sm:text-xl font-bold text-gray-900 mb-4 sm:mb-6">
              Ajout d'images par catégorie
            </h2>

            <div class="space-y-4 sm:space-y-6">
              <div v-for="(category, index) in form.categories" :key="index"
                class="border border-gray-200 rounded-lg p-4 sm:p-6">
                <div class="flex items-center justify-between mb-4">
                  <h3 class="text-base sm:text-lg font-semibold text-gray-900 truncate pr-2">
                    {{ category.name }}
                  </h3>
                  <button v-if="form.categories.length > 1" @click="removeCategory(index)"
                    class="text-red-600 hover:text-red-700 flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                      </path>
                    </svg>
                  </button>
                </div>

                <!-- Zone de upload -->
                <div class="mb-4">
                  <label class="block w-full">
                    <div
                      class="border-2 border-dashed border-gray-300 rounded-lg p-4 sm:p-6 lg:p-8 text-center hover:border-indigo-400 transition cursor-pointer">
                      <svg class="w-8 h-8 sm:w-10 sm:h-10 lg:w-12 lg:h-12 text-gray-400 mx-auto mb-2 sm:mb-4"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                        </path>
                      </svg>
                      <p class="text-sm sm:text-base text-gray-600 font-medium mb-1">
                        Cliquez pour ajouter des images
                      </p>
                      <p class="text-xs sm:text-sm text-gray-500">PNG, JPG jusqu'à 10MB</p>
                      <input type="file" multiple accept="image/*" class="hidden"
                        @change="handleFileUpload($event, index)" />
                    </div>
                  </label>
                </div>

                <!-- Prévisualisation des images -->
                <div v-if="category.images.length > 0"
                  class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4">
                  <div v-for="(image, imgIndex) in category.images" :key="imgIndex" class="relative group">
                    <img :src="image.preview" alt="Preview"
                      class="w-full h-24 sm:h-32 object-cover rounded-lg border border-gray-200" />
                    <button @click="removeImage(index, imgIndex)"
                      class="absolute top-1 right-1 sm:top-2 sm:right-2 w-6 h-6 bg-red-600 text-white rounded-full opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                      <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                      </svg>
                    </button>
                  </div>
                </div>
              </div>

              <!-- Bouton ajouter catégorie -->
              <button @click="addCategory"
                class="w-full border-2 border-dashed border-gray-300 rounded-lg py-3 sm:py-4 text-sm sm:text-base text-gray-600 hover:border-indigo-400 hover:text-indigo-600 transition">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 mx-auto mb-1 sm:mb-2" fill="none" stroke="currentColor"
                  viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Ajouter une catégorie
              </button>
            </div>

            <!-- Modale -->
            <div v-if="showModal"
              class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4 sm:p-0"
              @click="closeModal">

              <div class="bg-white rounded-lg shadow-xl w-full max-w-md sm:max-w-lg md:max-w-xl p-6 sm:p-8" @click.stop>

                <h3 class="text-xl sm:text-2xl font-semibold mb-4 text-center sm:text-left">Nouvelle catégorie</h3>

                <input v-model="newCategoryName" type="text" placeholder="Entrez le nom de la catégorie" class="w-full px-4 py-2 border border-gray-300 rounded-lg 
                  focus:outline-none focus:ring-2 mb-4
                  focus:ring-indigo-500 focus:border-transparent" @keyup.enter="confirmAddCategory" autofocus />

                <div class="flex flex-col sm:flex-row justify-end gap-2">
                  <button @click="closeModal" class="px-4 py-2 text-gray-700 bg-gray-200 
                  rounded-lg hover:bg-gray-300 w-full sm:w-auto">
                    Annuler
                  </button>
                  <button @click="confirmAddCategory" class="px-4 py-2 bg-blue-500 text-white rounded-lg 
                    hover:bg-blue-600 w-full sm:w-auto">
                    Ajouter
                  </button>
                </div>

              </div>
            </div>

          </div>

          <!-- Étape 3: Observations -->
          <div v-if="currentStep === 2">
            <h2 class="text-lg sm:text-xl font-bold text-gray-900 mb-4 sm:mb-6">
              Observations et notes finales
            </h2>

            <div class="space-y-4 sm:space-y-6">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Observations générales
                </label>
                <textarea v-model="form.observations" rows="6"
                  placeholder="Décrivez vos observations, anomalies détectées, recommandations..."
                  class="w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"></textarea>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Conformité générale
                </label>
                <div class="flex flex-col sm:flex-row sm:space-x-4 space-y-2 sm:space-y-0">
                  <label class="flex items-center">
                    <input v-model="form.statut" type="radio" value="Conforme"
                      class="w-4 h-4 text-indigo-600 focus:ring-indigo-500" />
                    <span class="ml-2 text-sm sm:text-base text-gray-700">Conforme</span>
                  </label>
                  <label class="flex items-center">
                    <input v-model="form.statut" type="radio" value="Non conforme"
                      class="w-4 h-4 text-indigo-600 focus:ring-indigo-500" />
                    <span class="ml-2 text-sm sm:text-base text-gray-700">Non conforme</span>
                  </label>
                  <label class="flex items-center">
                    <input v-model="form.statut" type="radio" value="Partiellement conforme"
                      class="w-4 h-4 text-indigo-600 focus:ring-indigo-500" />
                    <span class="ml-2 text-sm sm:text-base text-gray-700">Partiellement conforme</span>
                  </label>
                </div>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Recommandations
                </label>
                <textarea v-model="form.recommandations" rows="4"
                  placeholder="Actions recommandées, mesures correctives à prendre..."
                  class="w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"></textarea>
              </div>
            </div>
          </div>

          <!-- Boutons de navigation -->
          <div
            class="flex flex-col sm:flex-row sm:justify-between gap-3 sm:gap-0 mt-6 sm:mt-8 pt-4 sm:pt-6 border-t border-gray-200">
            <button v-if="currentStep > 0" @click="previousStep"
              class="w-full sm:w-auto order-2 sm:order-1 px-4 sm:px-6 py-2.5 sm:py-3 text-sm sm:text-base border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
              Précédent
            </button>
            <div v-else class="hidden sm:block"></div>

            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 order-1 sm:order-2">
              <!-- <button
                @click="saveDraft"
                :disabled="saving"
                class="w-full sm:w-auto px-4 sm:px-6 py-2.5 sm:py-3 text-sm sm:text-base border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition disabled:opacity-50"
              >
                Sauvegarder brouillon
              </button> -->
              <button v-if="currentStep < steps.length - 1" @click="nextStep"
                class="w-full sm:w-auto px-4 sm:px-6 py-2.5 sm:py-3 text-sm sm:text-base bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                Suivant
              </button>
              <button v-else @click="submitInspection" :disabled="saving"
                class="w-full sm:w-auto px-4 sm:px-6 py-2.5 sm:py-3 text-sm sm:text-base bg-green-600 text-white rounded-lg hover:bg-green-700 transition disabled:opacity-50">
                <span v-if="!saving">Créer l'inspection</span>
                <span v-else>Création en cours...</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </MainLayout>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/services/api'
import MainLayout from '@/components/MainLayout.vue'
import { useNotifications } from '@/services/useNotifications';

const { notify } = useNotifications();

const router = useRouter()

const steps = ['Informations générales', "Ajout d'images", 'Observations']
const currentStep = ref(0)
const saving = ref(false)

const form = ref({
  date_inspection: new Date().toISOString().split('T')[0],
  type_inspection: '',
  lieu_inspection: '',
  responsible_name: '',
  categories: [],
  observations: '',
  statut: '',
  recommandations: '',
})

const showModal = ref(false)
const newCategoryName = ref('')

const getStepClass = (index) => {
  if (index < currentStep.value) {
    return 'bg-indigo-600 border-indigo-600 text-white'
  } else if (index === currentStep.value) {
    return 'bg-white border-indigo-600 text-indigo-600'
  } else {
    return 'bg-white border-gray-300 text-gray-500'
  }
}

const nextStep = () => {
  if (currentStep.value < steps.length - 1) {
    currentStep.value++
  }
}

const previousStep = () => {
  if (currentStep.value > 0) {
    currentStep.value--
  }
}

const addCategory = () => {
  showModal.value = true
}

const confirmAddCategory = () => {
  if (newCategoryName.value.trim()) {
    form.value.categories.push({
      name: newCategoryName.value,
      images: [],
    })
    notify.info(`Catégorie ${newCategoryName.value} ajoutée`, {
      duration: 3000,
    })
  }

  closeModal()
}

const closeModal = () => {
  showModal.value = false
  newCategoryName.value = ''
}

const removeCategory = (index) => {
  form.value.categories.splice(index, 1)
}

const handleFileUpload = (event, categoryIndex) => {
  const files = Array.from(event.target.files)

  files.forEach((file) => {
    const reader = new FileReader()
    reader.onload = (e) => {
      form.value.categories[categoryIndex].images.push({
        file: file,
        preview: e.target.result,
      })
    }
    reader.readAsDataURL(file)
  })
}

const removeImage = (categoryIndex, imageIndex) => {
  form.value.categories[categoryIndex].images.splice(imageIndex, 1)
}

// const saveDraft = async () => {
//   saving.value = true
//   try {
//     await api.post('/api/inspections/draft', form.value)
//     alert('Brouillon sauvegardé avec succès')
//   } catch (error) {
//     console.error('Erreur lors de la sauvegarde:', error)
//     alert('Erreur lors de la sauvegarde du brouillon')
//   } finally {
//     saving.value = false
//   }
// }

const showValidationErrors = (errors) => {
  let delay = 0

  Object.values(errors).flat().forEach((message) => {
    setTimeout(() => {
      notify.error(message)
    }, delay)

    delay += 500
  })
}

const submitInspection = async () => {
  saving.value = true
  try {
    const formData = new FormData()

    Object.keys(form.value).forEach((key) => {
      if (key !== 'categories') {
        formData.append(key, form.value[key])
      }
    })

    form.value.categories.forEach((category, catIndex) => {
      formData.append(`categories[${catIndex}][name]`, category.name)
      category.images.forEach((image, imgIndex) => {
        formData.append(`categories[${catIndex}][images][]`, image.file)
      })
    })

    const response = await api.createInspection(formData)
    const message = response.data.message
    notify.success(message, { duration: 3000 })

    router.push({ name: 'InspectionDetail', params: { id: response.data.uuid } })
  } catch (error) {
    // Erreur Axios avec réponse du serveur
    if (error.response) {
      const status = error.response.status
      const data = error.response.data

      switch (status) {
        case 422: {
          showValidationErrors(data.errors)
          break
        }

        case 401:
          notify.error('Session expirée. Veuillez vous reconnecter.', { duration: 3000 })
          api.logout()
          break

        case 403:
          notify.error("Vous n'avez pas l'autorisation.", { duration: 5000 })
          break

        case 500:
          notify.error('Erreur interne du serveur.', { duration: 5000 })
          break

        default:
          notify.error(data.message || 'Une erreur est survenue.', { duration: 5000 })
      }

      // Erreur réseau (serveur inaccessible, timeout, etc.)
    } else if (error.request) {
      notify.error('Impossible de contacter le serveur.', { duration: 5000 })

      // Autre erreur JS
    } else {
      notify.error(error.message, { duration: 5000 })
    }

    console.error('Erreur lors de la création :', error)
  }
  finally {
    saving.value = false
  }
}
</script>