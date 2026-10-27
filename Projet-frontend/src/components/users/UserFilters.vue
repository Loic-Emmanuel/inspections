<template>
    <div class="bg-white rounded-lg sm:rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-3 sm:gap-4">
            <!-- Recherche -->
            <div class="lg:col-span-2">
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">Recherche</label>
                <div class="relative">
                    <input 
                        :value="initialFilters.search" 
                        type="text" 
                        placeholder="Rechercher par nom, email..."
                        class="w-full pl-9 sm:pl-10 pr-4 py-2 sm:py-2.5 text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        @input="$emit('search', $event.target.value)" 
                    />
                    <svg class="absolute left-2.5 sm:left-3 top-2 sm:top-2.5 w-4 h-4 sm:w-5 sm:h-5 text-gray-400"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            <!-- Filtre par rôle -->
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">Rôle</label>
                <select 
                    :value="initialFilters.role"
                    class="w-full px-3 sm:px-4 py-2 sm:py-2.5 text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    @change="handleRoleChange">
                    <option value="">Tous les rôles</option>
                    <option value="admin">Administrateur</option>
                    <option value="inspecteur">Inspecteur</option>
                </select>
            </div>
        </div>

        <!-- Bouton réinitialiser -->
        <div v-if="hasActiveFilters" class="mt-4 pt-4 border-t border-gray-100">
            <button @click="$emit('reset')"
                class="text-sm text-indigo-600 hover:text-indigo-800 font-medium flex items-center space-x-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                <span>Réinitialiser les filtres</span>
            </button>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
    initialFilters: {
        type: Object,
        default: () => ({ search: '', role: '' })
    }
})

const emit = defineEmits(['search', 'role-change', 'reset'])

const hasActiveFilters = computed(() => {
    return props.initialFilters.search !== '' || props.initialFilters.role !== ''
})

const handleRoleChange = (event) => {
    const value = event.target.value
    emit('role-change', value)
}
</script>