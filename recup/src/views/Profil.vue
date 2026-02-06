<template>
  <MainLayout>
    <div class="min-h-screen bg-gray-50">
      <main class="w-full max-w-4xl mx-auto px-3 sm:px-4 md:px-6 lg:px-8 py-4 sm:py-6 lg:py-8">
        <!-- Header -->
        <div class="mb-4 sm:mb-6 lg:mb-8">
          <h1 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900">Mon profil</h1>
          <p class="text-xs sm:text-sm md:text-base text-gray-600 mt-1">Gérez vos informations personnelles</p>
        </div>

        <!-- Onglets -->
        <div class="mb-4 sm:mb-6">
          <div class="border-b border-gray-200">
            <nav class="-mb-px flex" aria-label="Tabs">
              <button
                @click="activeTab = 'profile'"
                :class="[
                  activeTab === 'profile'
                    ? 'border-indigo-600 text-indigo-600'
                    : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300',
                  'flex-1 sm:flex-none whitespace-nowrap py-3 sm:py-4 px-2 sm:px-4 border-b-2 font-medium text-xs sm:text-sm md:text-base transition'
                ]"
              >
                <span class="flex items-center justify-center">
                  <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1.5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                  </svg>
                  <span class="hidden xs:inline sm:inline">Informations</span>
                  <span class="xs:hidden sm:hidden">Profil</span>
                </span>
              </button>
              <button
                @click="activeTab = 'password'"
                :class="[
                  activeTab === 'password'
                    ? 'border-indigo-600 text-indigo-600'
                    : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300',
                  'flex-1 sm:flex-none whitespace-nowrap py-3 sm:py-4 px-2 sm:px-4 border-b-2 font-medium text-xs sm:text-sm md:text-base transition'
                ]"
              >
                <span class="flex items-center justify-center">
                  <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1.5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                  </svg>
                  Mot de passe
                </span>
              </button>
            </nav>
          </div>
        </div>

        <!-- Messages de feedback -->
        <div v-if="successMessage" class="mb-4 sm:mb-6 bg-green-50 border border-green-200 rounded-lg p-3 sm:p-4 flex items-start">
          <svg class="w-4 h-4 sm:w-5 sm:h-5 text-green-600 mt-0.5 mr-2 sm:mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
          </svg>
          <p class="text-xs sm:text-sm text-green-800">{{ successMessage }}</p>
        </div>

        <div v-if="errorMessage" class="mb-4 sm:mb-6 bg-red-50 border border-red-200 rounded-lg p-3 sm:p-4 flex items-start">
          <svg class="w-4 h-4 sm:w-5 sm:h-5 text-red-600 mt-0.5 mr-2 sm:mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
          <p class="text-xs sm:text-sm text-red-800">{{ errorMessage }}</p>
        </div>

        <div class="space-y-6">
          <!-- Section Informations personnelles -->
          <div v-if="activeTab === 'profile'" class="bg-white rounded-lg sm:rounded-xl shadow-sm border border-gray-200">
            <div class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 md:py-5 border-b border-gray-200">
              <h2 class="text-sm sm:text-base md:text-lg font-bold text-gray-900">Informations personnelles</h2>
            </div>
            
            <form @submit.prevent="updateProfile" class="p-3 sm:p-4 md:p-6">
              <div class="space-y-3 sm:space-y-4 md:space-y-5">
                <!-- Nom et Prénom -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                  <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-1.5">
                      Nom <span class="text-red-500">*</span>
                    </label>
                    <input 
                      v-model="profileForm.name" 
                      type="text" 
                      required
                      class="w-full px-3 py-2 sm:px-4 sm:py-2.5 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                      placeholder="Entrez le nom" 
                    />
                  </div>
                  <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-1.5">
                      Prénom <span class="text-red-500">*</span>
                    </label>
                    <input 
                      v-model="profileForm.firstname" 
                      type="text" 
                      required
                      class="w-full px-3 py-2 sm:px-4 sm:py-2.5 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                      placeholder="Entrez le prénom" 
                    />
                  </div>
                </div>

                <!-- Email -->
                <div>
                  <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-1.5">
                    Email <span class="text-red-500">*</span>
                  </label>
                  <input 
                    v-model="profileForm.email" 
                    type="email" 
                    required
                    class="w-full px-3 py-2 sm:px-4 sm:py-2.5 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                    placeholder="exemple@email.com" 
                  />
                </div>

                <!-- Contact -->
                <div>
                  <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-1.5">
                    Contact <span class="text-red-500">*</span>
                  </label>
                  <input 
                    v-model="profileForm.contact" 
                    type="tel" 
                    required
                    class="w-full px-3 py-2 sm:px-4 sm:py-2.5 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                    placeholder="+225 XX XX XX XX XX" 
                  />
                </div>
              </div>

              <!-- Bouton de sauvegarde -->
              <div class="mt-4 sm:mt-5 md:mt-6 flex justify-end">
                <button
                  type="submit"
                  :disabled="loadingProfile"
                  class="w-full sm:w-auto px-4 sm:px-6 py-2.5 sm:py-3 bg-indigo-600 text-white text-sm sm:text-base font-medium rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition disabled:opacity-50 disabled:cursor-not-allowed"
                >
                  <span v-if="loadingProfile" class="flex items-center justify-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Enregistrement...
                  </span>
                  <span v-else>Enregistrer les modifications</span>
                </button>
              </div>
            </form>
          </div>

          <!-- Section Modification du mot de passe -->
          <div v-if="activeTab === 'password'" class="bg-white rounded-lg sm:rounded-xl shadow-sm border border-gray-200">
            <div class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 md:py-5 border-b border-gray-200">
              <h2 class="text-sm sm:text-base md:text-lg font-bold text-gray-900">Modifier le mot de passe</h2>
            </div>
            
            <form @submit.prevent="updatePassword" class="p-3 sm:p-4 md:p-6">
              <div class="space-y-3 sm:space-y-4 md:space-y-5">
                <!-- Mot de passe actuel -->
                <div>
                  <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-1.5">
                    Mot de passe actuel <span class="text-red-500">*</span>
                  </label>
                  <div class="relative">
                    <input 
                      v-model="passwordForm.currentPassword" 
                      :type="showCurrentPassword ? 'text' : 'password'" 
                      required
                      class="w-full px-3 py-2 sm:px-4 sm:py-2.5 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent pr-10 transition"
                      placeholder="Mot de passe actuel" 
                    />
                    <button
                      type="button"
                      @click="showCurrentPassword = !showCurrentPassword"
                      class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition"
                    >
                      <svg v-if="showCurrentPassword" class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                      </svg>
                      <svg v-else class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                      </svg>
                    </button>
                  </div>
                </div>

                <!-- Nouveau mot de passe -->
                <div>
                  <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-1.5">
                    Nouveau mot de passe <span class="text-red-500">*</span>
                  </label>
                  <div class="relative">
                    <input 
                      v-model="passwordForm.newPassword" 
                      :type="showNewPassword ? 'text' : 'password'" 
                      required
                      minlength="6"
                      class="w-full px-3 py-2 sm:px-4 sm:py-2.5 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent pr-10 transition"
                      placeholder="Nouveau mot de passe (min. 6 caractères)" 
                    />
                    <button
                      type="button"
                      @click="showNewPassword = !showNewPassword"
                      class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition"
                    >
                      <svg v-if="showNewPassword" class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                      </svg>
                      <svg v-else class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                      </svg>
                    </button>
                  </div>
                </div>

                <!-- Confirmation du nouveau mot de passe -->
                <div>
                  <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-1.5">
                    Confirmer le nouveau mot de passe <span class="text-red-500">*</span>
                  </label>
                  <div class="relative">
                    <input 
                      v-model="passwordForm.confirmPassword" 
                      :type="showConfirmPassword ? 'text' : 'password'" 
                      required
                      minlength="6"
                      class="w-full px-3 py-2 sm:px-4 sm:py-2.5 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent pr-10 transition"
                      :class="{ 'border-red-500 focus:ring-red-500': passwordForm.confirmPassword && passwordForm.newPassword !== passwordForm.confirmPassword }"
                      placeholder="Confirmez le mot de passe" 
                    />
                    <button
                      type="button"
                      @click="showConfirmPassword = !showConfirmPassword"
                      class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition"
                    >
                      <svg v-if="showConfirmPassword" class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                      </svg>
                      <svg v-else class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                      </svg>
                    </button>
                  </div>
                  <p v-if="passwordForm.confirmPassword && passwordForm.newPassword !== passwordForm.confirmPassword" 
                     class="mt-1 text-xs sm:text-sm text-red-600">
                    Les mots de passe ne correspondent pas
                  </p>
                </div>
              </div>

              <!-- Bouton de sauvegarde -->
              <div class="mt-4 sm:mt-5 md:mt-6 flex justify-end">
                <button
                  type="submit"
                  :disabled="loadingPassword || (passwordForm.newPassword !== passwordForm.confirmPassword)"
                  class="w-full sm:w-auto px-4 sm:px-6 py-2.5 sm:py-3 bg-indigo-600 text-white text-sm sm:text-base font-medium rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition disabled:opacity-50 disabled:cursor-not-allowed"
                >
                  <span v-if="loadingPassword" class="flex items-center justify-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Modification...
                  </span>
                  <span v-else>Modifier le mot de passe</span>
                </button>
              </div>
            </form>
          </div>
        </div>
      </main>
    </div>
  </MainLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/services/api'
import MainLayout from '@/components/MainLayout.vue'

// Onglet actif
const activeTab = ref('profile')

// États pour les formulaires
const profileForm = ref({
  name: '',
  firstname: '',
  email: '',
  contact: ''
})

const passwordForm = ref({
  currentPassword: '',
  newPassword: '',
  confirmPassword: ''
})

// États pour l'affichage des mots de passe
const showCurrentPassword = ref(false)
const showNewPassword = ref(false)
const showConfirmPassword = ref(false)

// États de chargement
const loadingProfile = ref(false)
const loadingPassword = ref(false)

// Messages de feedback
const successMessage = ref('')
const errorMessage = ref('')

// Charger les données du profil
const loadProfile = async () => {
  try {
    const response = await api.getProfile() // À adapter selon votre API
    const data = response.data
    
    profileForm.value = {
      name: data.name || '',
      firstname: data.firstname || '',
      email: data.email || '',
      contact: data.contact || ''
    }
  } catch (error) {
    console.error('Erreur chargement profil:', error)
    showError('Impossible de charger les informations du profil')
  }
}

// Mettre à jour le profil
const updateProfile = async () => {
  loadingProfile.value = true
  clearMessages()
  
  try {
    await api.updateProfile(profileForm.value) // À adapter selon votre API
    showSuccess('Profil mis à jour avec succès')
  } catch (error) {
    console.error('Erreur mise à jour profil:', error)
    showError('Erreur lors de la mise à jour du profil')
  } finally {
    loadingProfile.value = false
  }
}

// Mettre à jour le mot de passe
const updatePassword = async () => {
  if (passwordForm.value.newPassword !== passwordForm.value.confirmPassword) {
    showError('Les mots de passe ne correspondent pas')
    return
  }

  loadingPassword.value = true
  clearMessages()
  
  try {
    await api.updatePassword({
      currentPassword: passwordForm.value.currentPassword,
      newPassword: passwordForm.value.newPassword
    }) // À adapter selon votre API
    
    showSuccess('Mot de passe modifié avec succès')
    
    // Réinitialiser le formulaire
    passwordForm.value = {
      currentPassword: '',
      newPassword: '',
      confirmPassword: ''
    }
  } catch (error) {
    console.error('Erreur modification mot de passe:', error)
    showError(error.response?.data?.message || 'Erreur lors de la modification du mot de passe')
  } finally {
    loadingPassword.value = false
  }
}

// Gestion des messages
const showSuccess = (message) => {
  successMessage.value = message
  setTimeout(() => {
    successMessage.value = ''
  }, 5000)
}

const showError = (message) => {
  errorMessage.value = message
  setTimeout(() => {
    errorMessage.value = ''
  }, 5000)
}

const clearMessages = () => {
  successMessage.value = ''
  errorMessage.value = ''
}

onMounted(() => {
  loadProfile()
})
</script>