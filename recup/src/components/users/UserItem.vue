<template>
    <div class="px-4 sm:px-6 py-4 sm:py-5 hover:bg-gray-50 transition">
        <div class="flex items-start sm:items-center gap-3 sm:gap-4">
            <!-- Avatar -->
            <div
                class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-full flex items-center justify-center text-white font-bold text-sm sm:text-lg flex-shrink-0">
                {{ getInitials(user.firstname, user.name) }}
            </div>

            <!-- Informations -->
            <div class="flex-1 min-w-0">
                <!-- Nom et rôle -->
                <div class="flex flex-col sm:flex-row sm:items-center gap-1.5 sm:gap-3 mb-1.5 sm:mb-1">
                    <h3 class="text-sm sm:text-base font-bold text-gray-900 truncate">
                        {{ user.firstname }} {{ user.name }}
                    </h3>
                    <span v-if="user.role"
                        class="px-2 py-0.5 sm:py-1 text-xs font-medium rounded-full inline-block w-fit"
                        :class="getRoleClass(user.role)">
                        {{ getRoleLabel(user.role) }}
                    </span>
                </div>

                <!-- Email et Contact -->
                <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4 text-xs sm:text-sm text-gray-600">
                    <span class="flex items-center truncate">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span class="truncate">{{ user.email }}</span>
                    </span>
                    <span v-if="user.contact" class="flex items-center">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
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
                <button @click="$emit('edit', user)"
                    class="p-1.5 sm:p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition" title="Modifier">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                        </path>
                    </svg>
                </button>
                <button @click="$emit('delete', user.id)"
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
</template>

<script setup>
const props = defineProps({
    user: {
        type: Object,
        required: true
    }
})

const emit = defineEmits(['edit', 'delete'])

// Méthodes utilitaires
const getInitials = (firstname, name) => {
    const first = firstname ? firstname.charAt(0) : ''
    const last = name ? name.charAt(0) : ''
    return `${first}${last}`.toUpperCase() || '?'
}

const getRoleLabel = (role) => {
    const labels = {
        admin: 'Administrateur',
        inspecteur: 'Inspecteur'
    }
    return labels[role] || role
}

const getRoleClass = (role) => {
    const classes = {
        admin: 'bg-purple-100 text-purple-800',
        inspecteur: 'bg-blue-100 text-blue-800'
    }
    return classes[role] || 'bg-gray-100 text-gray-800'
}
</script>