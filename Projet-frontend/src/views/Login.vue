<template>
  <div class="min-h-screen w-full flex bg-slate-900 overflow-hidden font-sans">
    <!-- Colonne gauche : Présentation & Marque (Desktop / Tablette large) -->
    <div class="hidden lg:flex lg:w-1/2 xl:w-5/12 relative bg-gradient-to-br from-slate-950 via-indigo-950 to-slate-900 p-12 flex-col justify-between overflow-hidden border-r border-white/10">
      <!-- Cercles lumineux d'ambiance en arrière-plan -->
      <div class="absolute -top-24 -left-24 w-96 h-96 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
      <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-purple-500/15 rounded-full blur-3xl pointer-events-none"></div>

      <!-- En-tête Marque -->
      <div class="relative z-10 flex items-center space-x-3.5">
        <div class="w-12 h-12 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 p-2 flex items-center justify-center shadow-lg shadow-indigo-500/10">
          <img src="/logo.png" alt="Logo de l'application" class="w-full h-full object-contain filter drop-shadow" />
        </div>
        <div>
          <span class="text-xl font-bold tracking-tight text-white block">Inspections<span class="text-indigo-400">Pro</span></span>
          <span class="text-xs text-indigo-200/70 font-medium">Plateforme d'Audit & Contrôle</span>
        </div>
      </div>

      <!-- Contenu central : Proposition de valeur & Avantages -->
      <div class="relative z-10 my-auto py-8">
        <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-indigo-500/15 border border-indigo-500/30 text-indigo-300 text-xs font-medium mb-6">
          <span class="w-2 h-2 rounded-full bg-indigo-400 animate-pulse"></span>
          <span>Gestion numérique terrain</span>
        </div>

        <h2 class="text-3xl xl:text-4xl font-extrabold text-white tracking-tight leading-tight mb-4">
          Simplifiez vos inspections et valorisez vos rapports.
        </h2>
        <p class="text-indigo-100/70 text-sm xl:text-base leading-relaxed mb-8">
          Une suite complète pour inspecteurs et administrateurs, pensée pour fluidifier la saisie terrain, la conformité réglementaire et l'édition de synthèses PDF.
        </p>

        <!-- Liste des atouts majeurs -->
        <div class="space-y-4">
          <div class="flex items-start space-x-3.5 p-3.5 rounded-xl bg-white/[0.04] border border-white/[0.07] backdrop-blur-sm">
            <div class="w-9 h-9 rounded-lg bg-indigo-600/30 border border-indigo-500/40 flex items-center justify-center text-indigo-300 flex-shrink-0 mt-0.5">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
            </div>
            <div>
              <h3 class="text-sm font-semibold text-white">Capture & Documentation Terrain</h3>
              <p class="text-xs text-indigo-200/60 mt-0.5">Prise de clichés catégorisés avec observations et preuves horodatées.</p>
            </div>
          </div>

          <div class="flex items-start space-x-3.5 p-3.5 rounded-xl bg-white/[0.04] border border-white/[0.07] backdrop-blur-sm">
            <div class="w-9 h-9 rounded-lg bg-emerald-600/30 border border-emerald-500/40 flex items-center justify-center text-emerald-300 flex-shrink-0 mt-0.5">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
              </svg>
            </div>
            <div>
              <h3 class="text-sm font-semibold text-white">Rapports PDF instantanés</h3>
              <p class="text-xs text-indigo-200/60 mt-0.5">Génération automatique prête à être transmise aux clients ou archivée.</p>
            </div>
          </div>

          <div class="flex items-start space-x-3.5 p-3.5 rounded-xl bg-white/[0.04] border border-white/[0.07] backdrop-blur-sm">
            <div class="w-9 h-9 rounded-lg bg-purple-600/30 border border-purple-500/40 flex items-center justify-center text-purple-300 flex-shrink-0 mt-0.5">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
              </svg>
            </div>
            <div>
              <h3 class="text-sm font-semibold text-white">Tableau de bord & Suivi</h3>
              <p class="text-xs text-indigo-200/60 mt-0.5">Indicateurs mensuels, statuts de conformité et annuaire clients centralisé.</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Bas de page gauche -->
      <div class="relative z-10 flex items-center justify-between text-xs text-indigo-300/50 pt-4 border-t border-white/5">
        <span>© 2026 InspectionsPro</span>
        <span>Version 1.0</span>
      </div>
    </div>

    <!-- Colonne droite : Formulaire de connexion -->
    <div class="w-full lg:w-1/2 xl:w-7/12 flex items-center justify-center p-4 sm:p-8 lg:p-12 bg-gray-50 relative">
      <!-- Décoration subtile en arrière-plan -->
      <div class="absolute top-0 right-0 w-80 h-80 bg-indigo-100/60 rounded-full blur-3xl pointer-events-none"></div>
      <div class="absolute bottom-0 left-0 w-80 h-80 bg-slate-200/60 rounded-full blur-3xl pointer-events-none"></div>

      <div class="w-full max-w-md relative z-10">
        <!-- Carte de connexion -->
        <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/80 border border-gray-200/70 p-6 sm:p-8 md:p-10 transition-all">
          
          <!-- Logo & Titre (visible sur tous les écrans, mis en valeur) -->
          <div class="text-center mb-8">
            <div class="inline-flex p-3 rounded-2xl bg-gradient-to-tr from-indigo-50 to-indigo-100/70 border border-indigo-100 shadow-sm mb-4">
              <img src="/logo.png" alt="Logo Inspections" class="w-14 h-14 sm:w-16 sm:h-16 object-contain drop-shadow-sm" />
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
              Espace de Connexion
            </h1>
            <p class="text-sm text-gray-500 mt-1.5">
              Saisissez vos identifiants pour accéder à votre espace
            </p>
          </div>

          <!-- Raccourcis de remplissage rapide pour test (facilite la vie) -->
          <div class="mb-6 p-3 bg-indigo-50/70 rounded-xl border border-indigo-100 text-xs text-indigo-900">
            <div class="flex items-center justify-between mb-2">
              <span class="font-semibold flex items-center gap-1.5 text-indigo-800">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Comptes préconfigurés :
              </span>
              <span class="text-[11px] text-indigo-600">Cliquer pour remplir</span>
            </div>
            <div class="grid grid-cols-2 gap-2">
              <button
                type="button"
                @click="fillCredentials('admin@inspections.com', 'password123')"
                class="px-2.5 py-1.5 rounded-lg bg-white border border-indigo-200/80 text-indigo-700 hover:bg-indigo-600 hover:text-white transition font-medium text-left truncate flex items-center gap-1.5 shadow-xs"
              >
                <span>👑</span>
                <span class="truncate">Admin</span>
              </button>
              <button
                type="button"
                @click="fillCredentials('inspecteur@inspections.com', 'password123')"
                class="px-2.5 py-1.5 rounded-lg bg-white border border-indigo-200/80 text-indigo-700 hover:bg-indigo-600 hover:text-white transition font-medium text-left truncate flex items-center gap-1.5 shadow-xs"
              >
                <span>📋</span>
                <span class="truncate">Inspecteur</span>
              </button>
            </div>
          </div>

          <!-- Formulaire -->
          <form @submit.prevent="handleLogin" class="space-y-5">
            <!-- Champ Email -->
            <div>
              <label for="email" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5">
                Adresse email
              </label>
              <div class="relative rounded-lg">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                  </svg>
                </div>
                <input
                  id="email"
                  v-model="form.email"
                  name="email"
                  type="email"
                  required
                  autocomplete="username"
                  placeholder="nom@exemple.com"
                  class="w-full pl-10 pr-4 py-2.5 sm:py-3 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 placeholder-gray-400"
                />
              </div>
            </div>

            <!-- Champ Mot de passe -->
            <div>
              <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-xs sm:text-sm font-semibold text-gray-700">
                  Mot de passe
                </label>
              </div>
              <div class="relative rounded-lg">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                  </svg>
                </div>
                <input
                  id="password"
                  v-model="form.password"
                  name="password"
                  :type="showPassword ? 'text' : 'password'"
                  required
                  autocomplete="current-password"
                  placeholder="••••••••"
                  class="w-full pl-10 pr-11 py-2.5 sm:py-3 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 placeholder-gray-400"
                />
                <button
                  type="button"
                  @click="showPassword = !showPassword"
                  class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none transition-colors"
                  aria-label="Afficher ou masquer le mot de passe"
                >
                  <svg v-if="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                  </svg>
                  <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                  </svg>
                </button>
              </div>
            </div>

            <!-- Option Se souvenir de moi -->
            <div class="flex items-center justify-between">
              <label class="flex items-center cursor-pointer select-none">
                <input
                  v-model="form.remember"
                  type="checkbox"
                  class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 cursor-pointer"
                />
                <span class="ml-2 text-xs sm:text-sm text-gray-600 hover:text-gray-900 transition">
                  Garder ma session active
                </span>
              </label>
            </div>

            <!-- Message d'erreur -->
            <div
              v-if="error"
              class="p-3.5 bg-red-50/90 border border-red-200 rounded-xl text-red-700 text-xs sm:text-sm flex items-start space-x-2.5 animate-shake"
            >
              <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
              </svg>
              <span class="font-medium leading-relaxed">{{ error }}</span>
            </div>

            <!-- Bouton de soumission -->
            <button
              type="submit"
              :disabled="loading"
              class="w-full relative py-3 px-4 rounded-xl text-sm sm:text-base font-semibold text-white bg-gradient-to-r from-indigo-600 via-indigo-700 to-indigo-800 hover:from-indigo-500 hover:to-indigo-700 active:from-indigo-700 active:to-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 shadow-lg shadow-indigo-600/25 transition-all duration-200 disabled:opacity-60 disabled:cursor-not-allowed flex items-center justify-center cursor-pointer transform hover:-translate-y-0.5 active:translate-y-0"
            >
              <span v-if="!loading" class="flex items-center space-x-2">
                <span>Se connecter</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
              </span>
              <span v-else class="flex items-center space-x-2">
                <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Vérification des accès...</span>
              </span>
            </button>
          </form>

          <!-- Sécurité & Protection -->
          <div class="mt-8 pt-6 border-t border-gray-100 flex items-center justify-center space-x-2 text-xs text-gray-400">
            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
            <span>Connexion sécurisée par jeton chiffré Sanctum</span>
          </div>
        </div>

        <!-- Mentions de bas de page mobile -->
        <p class="lg:hidden text-center text-xs text-gray-500 mt-6">
          © 2026 InspectionsPro • Tous droits réservés
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const router = useRouter()
const authStore = useAuthStore()

const form = ref({
  email: '',
  password: '',
  remember: false,
})

const loading = ref(false)
const error = ref('')
const showPassword = ref(false)

const fillCredentials = (email, password) => {
  form.value.email = email
  form.value.password = password
  error.value = ''
}

const handleLogin = async () => {
  loading.value = true
  error.value = ''

  try {
    // Appel du store Pinia
    await authStore.login({
      email: form.value.email,
      password: form.value.password,
      remember: form.value.remember,
    })

    // Redirection après succès
    router.push({ name: 'Dashboard' })
  } catch (err) {
    // Reset message
    error.value = 'Une erreur est survenue lors de la connexion'

    // Erreur Axios avec réponse serveur
    if (err.response) {
      const status = err.response.status
      const data = err.response.data

      switch (status) {
        case 401:
          error.value = 'Email ou mot de passe incorrect.'
          break

        case 419:
          error.value = 'Session expirée ou jeton CSRF invalide. Veuillez rafraîchir la page.'
          break

        case 422:
          if (data?.errors) {
            error.value = Object.values(data.errors)
              .flat()
              .join(', ')
          } else {
            error.value = data?.message || 'Données saisies invalides.'
          }
          break

        case 403:
          error.value = 'Votre compte est suspendu ou non autorisé.'
          break

        case 500:
          error.value = 'Erreur interne du serveur. Veuillez réessayer ultérieurement.'
          break

        default:
          error.value = data?.message || 'Erreur inconnue du serveur.'
      }
    } else if (err.request) {
      error.value = 'Impossible de joindre le serveur API. Vérifiez votre connexion.'
    } else {
      error.value = err.message || 'Erreur inattendue.'
    }
  } finally {
    loading.value = false
  }
}
</script>

<style scoped>
@keyframes shake {
  0%, 100% { transform: translateX(0); }
  10%, 30%, 50%, 70%, 90% { transform: translateX(-4px); }
  20%, 40%, 60%, 80% { transform: translateX(4px); }
}

.animate-shake {
  animation: shake 0.4s ease-in-out;
}
</style>