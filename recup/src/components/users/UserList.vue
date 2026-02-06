<template>
    <div class="bg-white rounded-lg sm:rounded-xl shadow-sm border border-gray-200">
        <!-- Header du tableau -->
        <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
            <p class="text-xs sm:text-sm text-gray-600">
                <span class="font-medium text-gray-900">{{ total }}</span>
                utilisateur(s) trouvé(s)
            </p>
        </div>

        <!-- Loading state -->
        <div v-if="loading" class="p-8 sm:p-12 text-center">
            <div class="inline-block animate-spin rounded-full h-10 w-10 sm:h-12 sm:w-12 border-4 border-gray-300 border-t-indigo-600">
            </div>
            <p class="text-sm sm:text-base text-gray-600 mt-3 sm:mt-4">Chargement des utilisateurs...</p>
        </div>

        <!-- Empty state -->
        <UserEmptyState 
            v-else-if="users.length === 0" 
            @reset="$emit('reset-filters')" 
        />

        <!-- Liste des utilisateurs -->
        <div v-else class="divide-y divide-gray-200">
            <UserItem 
                v-for="user in users" 
                :key="user.id" 
                :user="user" 
                @edit="$emit('edit', user)"
                @delete="$emit('delete', user.id)"
            />
        </div>

        <!-- Pagination -->
        <UserPagination 
            v-if="!loading && total > 0"
            :pagination="pagination"
            @page-change="$emit('page-change', $event)"
        />
    </div>
</template>

<script setup>
import UserItem from './UserItem.vue'
import UserEmptyState from './UserEmptyState.vue'
import UserPagination from './UserPagination.vue'

defineProps({
    users: {
        type: Array,
        default: () => []
    },
    loading: {
        type: Boolean,
        default: false
    },
    total: {
        type: Number,
        default: 0
    },
    pagination: {
        type: Object,
        default: () => ({})
    }
})

defineEmits(['edit', 'delete', 'page-change', 'reset-filters'])
</script>