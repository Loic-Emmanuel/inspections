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
        <UserFilters 
            :initial-filters="filters"
            @search="handleSearch"
            @role-change="handleRoleChange"
            @reset="resetFilters"
        />

        <!-- Liste des utilisateurs -->
        <UserList 
            :users="users"
            :loading="loading"
            :total="pagination.total"
            :pagination="pagination"
            @edit="editUser"
            @delete="deleteUser"
            @page-change="changePage"
            @reset-filters="resetFilters"
        />

        <!-- Modal de création/édition -->
        <UserModal 
            :show="showModal"
            :is-editing="isEditing"
            :form-data="formData"
            :saving="saving"
            @close="closeModal"
            @submit="saveUser"
        />
    </MainLayout>
</template>

<script setup>
import MainLayout from '@/components/MainLayout.vue'
import { ref, reactive, onMounted } from 'vue'
import { useNotifications } from '@/services/useNotifications'
import api from '@/services/api'

// Import des composants
import UserFilters from '@/components/users/UserFilters.vue'
import UserList from '@/components/users/UserList.vue'
import UserModal from '@/components/users/UserModal.vue'

const { notify } = useNotifications()

/* =========================
   États
========================= */
const loading = ref(true)
const saving = ref(false)
const showModal = ref(false)
const isEditing = ref(false)

const filters = reactive({
    search: '',
    role: ''
})

const formData = reactive({
    id: null,
    firstname: '',
    name: '',
    email: '',
    contact: '',
    role: '',
    password: '',
    password_confirmation: ''
})

const users = ref([])

// Pagination
const pagination = reactive({
    current_page: 1,
    from: 0,
    to: 0,
    total: 0,
    per_page: 10,
    last_page: 1,
    next_page_url: null,
    prev_page_url: null,
})

// Timer pour le debounce
let searchTimeout = null

/* =========================
   Méthodes API
========================= */
const fetchUserList = async (page = 1) => {
    loading.value = true
    try {
        const params = {
            page,
            search: filters.search || undefined,
            role: filters.role || undefined,
        }

        Object.keys(params).forEach(key => params[key] === undefined && delete params[key])

        const response = await api.getUserList(params)
        const p = response.data.users

        users.value = p.data || []
        
        Object.assign(pagination, {
            current_page: p.current_page,
            from: p.from,
            to: p.to,
            total: p.total,
            per_page: p.per_page,
            last_page: p.last_page,
            next_page_url: p.next_page_url,
            prev_page_url: p.prev_page_url,
        })

    } catch (error) {
        console.error('Erreur:', error)
        notify.error('Erreur lors du chargement des utilisateurs')
    } finally {
        loading.value = false
    }
}

/* =========================
   Cycle de vie
========================= */
onMounted(() => {
    fetchUserList()
})

/* =========================
   Filtres
========================= */
const handleSearch = (searchTerm) => {
    filters.search = searchTerm
    if (searchTimeout) {
        clearTimeout(searchTimeout)
    }
    searchTimeout = setTimeout(() => {
        fetchUserList(1)
    }, 500)
}

const handleRoleChange = (role) => {
    filters.role = role
    fetchUserList(1)
}

const resetFilters = () => {
    filters.search = ''
    filters.role = ''
    fetchUserList(1)
}

/* =========================
   Méthodes CRUD
========================= */
const resetForm = () => {
    Object.assign(formData, {
        id: null,
        firstname: '',
        name: '',
        email: '',
        contact: '',
        role: '',
        password: '',
        password_confirmation: ''
    })
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
    Object.assign(formData, {
        id: user.id,
        firstname: user.firstname,
        name: user.name,
        email: user.email,
        contact: user.contact || '',
        role: user.role || '',
        password: '',
        password_confirmation: ''
    })
    showModal.value = true
    notify.info('Veuillez laisser le mot de passe vide si vous ne souhaitez pas le modifier')
}

const saveUser = async (data) => {
    saving.value = true

    try {
        const dataToSend = {
            firstname: data.firstname,
            name: data.name,
            email: data.email,
            contact: data.contact,
            role: data.role
        }

        // Gestion du mot de passe
        if (data.password) {
            if (!isEditing.value) {
                if (data.password !== data.password_confirmation) {
                    notify.error('Les mots de passe ne correspondent pas')
                    saving.value = false
                    return
                }
                dataToSend.password = data.password
                dataToSend.password_confirmation = data.password_confirmation
            } else {
                if (data.password_confirmation && data.password !== data.password_confirmation) {
                    notify.error('Les mots de passe ne correspondent pas')
                    saving.value = false
                    return
                }
                dataToSend.password = data.password
                if (data.password_confirmation) {
                    dataToSend.password_confirmation = data.password_confirmation
                }
            }
        } else if (!isEditing.value) {
            notify.error('Le mot de passe est obligatoire')
            saving.value = false
            return
        }

        if (isEditing.value) {
            const response = await api.updateUser(formData.id, dataToSend)
            console.log(response.data)
            notify.success(response.data.message)
        } else {
            await api.registerUser(dataToSend)
            notify.success('Utilisateur créé avec succès')
        }

        await fetchUserList(isEditing.value ? pagination.current_page : 1)
        closeModal()
    } catch (error) {
        console.error('Erreur:', error)
        if (error.response?.data?.errors) {
            const errors = error.response.data.errors
            const firstError = Object.values(errors)[0]
            notify.error(Array.isArray(firstError) ? firstError[0] : firstError)
        } else if (error.response?.data?.message) {
            notify.error(error.response.data.message)
        } else {
            notify.error('Une erreur est survenue')
        }
    } finally {
        saving.value = false
    }
}

const deleteUser = async (userId) => {
    if (confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')) {
        try {
            const response = await api.deleteUser(userId)
            notify.success(response.data.message)
            await fetchUserList(pagination.current_page)
        } catch (error) {
            console.error('Erreur:', error)
            notify.error('Erreur lors de la suppression')
        }
    }
}

/* =========================
   Pagination
========================= */
const changePage = (page) => {
    if (page < 1 || page > pagination.last_page || page === pagination.current_page) {
        return
    }
    window.scrollTo({ top: 0, behavior: 'smooth' })
    fetchUserList(page)
}
</script>