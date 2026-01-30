<template>
    <MainLayout>
        <!-- Header -->
        <div class="mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Gestion des utilisateurs</h1>
            <p class="text-sm sm:text-base text-gray-600 mt-1 sm:mt-2">Gérez les utilisateurs de la plateforme</p>
        </div>

        <!-- Bouton pour ouvrir le modal de création -->
        <div class="mb-4 sm:mb-6">
            <button @click="openCreateModal"
                class="w-full sm:w-auto px-4 py-2.5 sm:py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition flex items-center justify-center sm:justify-start space-x-2 text-sm sm:text-base">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Ajouter un utilisateur</span>
            </button>
        </div>

        <!-- Filtres et recherche -->
        <div class="bg-white rounded-lg sm:rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6 mb-4 sm:mb-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-3 sm:gap-4">
                <!-- Recherche -->
                <div class="lg:col-span-2">
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">Recherche</label>
                    <div class="relative">
                        <input v-model="filters.search" type="text" placeholder="Rechercher par nom, email..."
                            class="w-full pl-9 sm:pl-10 pr-4 py-2 sm:py-2.5 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            @input="applyFilters" />
                        <svg class="absolute left-2.5 sm:left-3 top-2 sm:top-2.5 w-4 h-4 sm:w-5 sm:h-5 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Filtre par rôle -->
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">Rôle</label>
                    <select v-model="filters.role"
                        class="w-full px-3 sm:px-4 py-2 sm:py-2.5 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        @change="applyFilters">
                        <option value="">Tous les rôles</option>
                        <option value="Administrateur">Administrateur</option>
                        <option value="Inspecteur">Inspecteur</option>
                        <option value="Superviseur">Superviseur</option>
                        <option value="Gestionnaire">Gestionnaire</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Liste des utilisateurs -->
        <div class="bg-white rounded-lg sm:rounded-xl shadow-sm border border-gray-200">
            <!-- Header du tableau -->
            <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
                <p class="text-xs sm:text-sm text-gray-600">
                    <span class="font-medium text-gray-900">{{ filteredUsers.length }}</span>
                    utilisateur(s) trouvé(s)
                </p>
            </div>

            <!-- Loading state -->
            <div v-if="loading" class="p-8 sm:p-12 text-center">
                <div
                    class="inline-block animate-spin rounded-full h-10 w-10 sm:h-12 sm:w-12 border-4 border-gray-300 border-t-indigo-600">
                </div>
                <p class="text-sm sm:text-base text-gray-600 mt-3 sm:mt-4">Chargement des utilisateurs...</p>
            </div>

            <!-- Empty state -->
            <div v-else-if="filteredUsers.length === 0" class="p-8 sm:p-12 text-center">
                <svg class="w-12 h-12 sm:w-16 sm:h-16 text-gray-300 mx-auto mb-3 sm:mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </svg>
                <h3 class="text-base sm:text-lg font-medium text-gray-900 mb-1 sm:mb-2">Aucun utilisateur trouvé</h3>
                <p class="text-sm sm:text-base text-gray-600 mb-4 sm:mb-6 px-4">
                    Aucun utilisateur ne correspond à vos critères de recherche
                </p>
            </div>

            <!-- Liste des utilisateurs -->
            <div v-else class="divide-y divide-gray-200">
                <div v-for="user in filteredUsers" :key="user.id" class="px-4 sm:px-6 py-4 sm:py-5 hover:bg-gray-50 transition">
                    <div class="flex items-start sm:items-center gap-3 sm:gap-4">
                        <!-- Avatar -->
                        <div
                            class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-full flex items-center justify-center text-white font-bold text-sm sm:text-lg flex-shrink-0">
                            {{ getInitials(user.prenom, user.nom) }}
                        </div>

                        <!-- Informations -->
                        <div class="flex-1 min-w-0">
                            <!-- Nom et rôle -->
                            <div class="flex flex-col sm:flex-row sm:items-center gap-1.5 sm:gap-3 mb-1.5 sm:mb-1">
                                <h3 class="text-sm sm:text-base font-bold text-gray-900 truncate">
                                    {{ user.prenom }} {{ user.nom }}
                                </h3>
                                <span class="px-2 py-0.5 sm:py-1 text-xs font-medium rounded-full inline-block w-fit"
                                    :class="getRoleClass(user.role)">
                                    {{ user.role }}
                                </span>
                            </div>
                            
                            <!-- Email et Contact -->
                            <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4 text-xs sm:text-sm text-gray-600">
                                <span class="flex items-center truncate">
                                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <span class="truncate">{{ user.email }}</span>
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                        </path>
                                    </svg>
                                    {{ user.contact }}
                                </span>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center gap-1 sm:gap-2 flex-shrink-0">
                            <button @click="editUser(user)"
                                class="p-1.5 sm:p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition" title="Modifier">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                            </button>
                            <button @click="deleteUser(user.id)"
                                class="p-1.5 sm:p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Supprimer">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de création/édition -->
        <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-0 sm:p-4"
            @click.self="closeModal">
            <div class="bg-white w-full h-full sm:h-auto sm:rounded-xl shadow-xl sm:max-w-2xl sm:w-full max-h-screen sm:max-h-[90vh] overflow-y-auto">
                <!-- Header du modal -->
                <div class="sticky top-0 bg-white px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200 flex items-center justify-between z-10">
                    <h2 class="text-lg sm:text-xl font-bold text-gray-900">
                        {{ isEditing ? 'Modifier l\'utilisateur' : 'Nouvel utilisateur' }}
                    </h2>
                    <button @click="closeModal" class="text-gray-400 hover:text-gray-600 transition p-1">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Formulaire -->
                <form @submit.prevent="saveUser" class="p-4 sm:p-6">
                    <div class="space-y-4 sm:space-y-6">
                        <!-- Nom et Prénom -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">
                                    Prénom <span class="text-red-500">*</span>
                                </label>
                                <input v-model="formData.prenom" type="text" required
                                    class="w-full px-3 sm:px-4 py-2 sm:py-2.5 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                    placeholder="Jean" />
                            </div>

                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">
                                    Nom <span class="text-red-500">*</span>
                                </label>
                                <input v-model="formData.nom" type="text" required
                                    class="w-full px-3 sm:px-4 py-2 sm:py-2.5 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                    placeholder="Dupont" />
                            </div>
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input v-model="formData.email" type="email" required
                                    class="w-full pl-9 sm:pl-10 pr-3 sm:pr-4 py-2 sm:py-2.5 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                    placeholder="jean.dupont@exemple.com" />
                                <svg class="absolute left-2.5 sm:left-3 top-2 sm:top-2.5 w-4 h-4 sm:w-5 sm:h-5 text-gray-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                        </div>

                        <!-- Contact -->
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">
                                Contact <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input v-model="formData.contact" type="tel" required
                                    class="w-full pl-9 sm:pl-10 pr-3 sm:pr-4 py-2 sm:py-2.5 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                    placeholder="+225 XX XX XX XX XX" />
                                <svg class="absolute left-2.5 sm:left-3 top-2 sm:top-2.5 w-4 h-4 sm:w-5 sm:h-5 text-gray-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                    </path>
                                </svg>
                            </div>
                        </div>

                        <!-- Rôle -->
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">
                                Rôle <span class="text-red-500">*</span>
                            </label>
                            <select v-model="formData.role" required
                                class="w-full px-3 sm:px-4 py-2 sm:py-2.5 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                <option value="">Sélectionner un rôle</option>
                                <option value="Administrateur">Administrateur</option>
                                <option value="Inspecteur">Inspecteur</option>
                                <option value="Superviseur">Superviseur</option>
                                <option value="Gestionnaire">Gestionnaire</option>
                            </select>
                        </div>
                    </div>

                    <!-- Actions du formulaire -->
                    <div class="flex flex-col-reverse sm:flex-row items-stretch sm:items-center sm:justify-end gap-2 sm:gap-3 mt-6 sm:mt-8 pt-4 sm:pt-6 border-t border-gray-200">
                        <button type="button" @click="closeModal"
                            class="px-4 py-2.5 sm:py-2 text-sm sm:text-base border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                            Annuler
                        </button>
                        <button type="submit"
                            class="px-4 py-2.5 sm:py-2 text-sm sm:text-base bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition flex items-center justify-center space-x-2">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>{{ isEditing ? 'Mettre à jour' : 'Créer l\'utilisateur' }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import MainLayout from '@/components/MainLayout.vue'
import { ref, reactive, onMounted } from 'vue'


/* =========================
   États
========================= */
const loading = ref(false)
const showModal = ref(false)
const isEditing = ref(false)

const filters = reactive({
    search: '',
    role: ''
})

const formData = reactive({
    id: null,
    prenom: '',
    nom: '',
    email: '',
    contact: '',
    role: ''
})

const users = ref([
    {
        id: 1,
        prenom: 'Kouassi',
        nom: 'Koffi',
        email: 'kouassi.koffi@exemple.ci',
        contact: '+225 07 XX XX XX XX',
        role: 'Administrateur'
    },
    {
        id: 2,
        prenom: 'Aminata',
        nom: 'Touré',
        email: 'aminata.toure@exemple.ci',
        contact: '+225 05 XX XX XX XX',
        role: 'Inspecteur'
    },
    {
        id: 3,
        prenom: 'Jean',
        nom: "N'Guessan",
        email: 'jean.nguessan@exemple.ci',
        contact: '+225 01 XX XX XX XX',
        role: 'Superviseur'
    }
])

const filteredUsers = ref([])

/* =========================
   Cycle de vie
========================= */
onMounted(() => {
    filteredUsers.value = [...users.value]
})

/* =========================
   Méthodes
========================= */
const resetForm = () => {
    formData.id = null
    formData.prenom = ''
    formData.nom = ''
    formData.email = ''
    formData.contact = ''
    formData.role = ''
}

const openCreateModal = () => {
    isEditing.value = false
    resetForm()
    showModal.value = true
}

const closeModal = () => {
    showModal.value = false
    resetForm()
}

const editUser = (user) => {
    isEditing.value = true
    Object.assign(formData, user)
    showModal.value = true
}

const saveUser = () => {
    if (isEditing.value) {
        const index = users.value.findIndex(u => u.id === formData.id)
        if (index !== -1) {
            users.value[index] = { ...formData }
        }
    } else {
        const newUser = {
            ...formData,
            id: users.value.length
                ? Math.max(...users.value.map(u => u.id)) + 1
                : 1
        }
        users.value.push(newUser)
    }

    applyFilters()
    closeModal()
}

const deleteUser = (userId) => {
    if (confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')) {
        users.value = users.value.filter(u => u.id !== userId)
        applyFilters()
    }
}

const applyFilters = () => {
    let filtered = [...users.value]

    if (filters.search) {
        const term = filters.search.toLowerCase()
        filtered = filtered.filter(user =>
            user.prenom.toLowerCase().includes(term) ||
            user.nom.toLowerCase().includes(term) ||
            user.email.toLowerCase().includes(term)
        )
    }

    if (filters.role) {
        filtered = filtered.filter(user => user.role === filters.role)
    }

    filteredUsers.value = filtered
}

const getInitials = (prenom, nom) => {
    return `${prenom.charAt(0)}${nom.charAt(0)}`.toUpperCase()
}

const getRoleClass = (role) => {
    const classes = {
        Administrateur: 'bg-purple-100 text-purple-800',
        Inspecteur: 'bg-blue-100 text-blue-800',
        Superviseur: 'bg-green-100 text-green-800',
        Gestionnaire: 'bg-orange-100 text-orange-800'
    }
    return classes[role] || 'bg-gray-100 text-gray-800'
}
</script>