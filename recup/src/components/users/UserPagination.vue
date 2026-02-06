<template>
    <div class="px-4 sm:px-6 py-3 sm:py-4 border-t border-gray-200">
        <div class="flex items-center justify-between">
            <!-- Informations -->
            <p class="text-xs sm:text-sm text-gray-600">
                <span class="font-medium">{{ pagination.from || 0 }}</span>
                -
                <span class="font-medium">{{ pagination.to || 0 }}</span>
                /
                <span class="font-medium">{{ pagination.total }}</span>
            </p>

            <!-- Navigation -->
            <div v-if="pagination.last_page > 1" class="flex items-center gap-2">
                <!-- Précédent -->
                <button @click="changePage(pagination.current_page - 1)" :disabled="!pagination.prev_page_url"
                    class="p-2 rounded-lg border border-gray-300 disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-50 active:bg-gray-100 transition">
                    ←
                </button>

                <!-- Numéros de page -->
                <div class="flex gap-1">
                    <button v-for="page in paginationPages" :key="page"
                        @click="page !== '...' && changePage(page)" :disabled="page === '...'"
                        class="px-3 py-2 text-sm rounded-lg border transition-colors" :class="page === pagination.current_page
                            ? 'bg-indigo-600 text-white border-indigo-600'
                            : page === '...'
                                ? 'border-transparent cursor-default'
                                : 'border-gray-300 hover:bg-gray-50'
                            ">
                        {{ page }}
                    </button>
                </div>

                <!-- Suivant -->
                <button @click="changePage(pagination.current_page + 1)" :disabled="!pagination.next_page_url"
                    class="p-2 rounded-lg border border-gray-300 disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-50 active:bg-gray-100 transition">
                    →
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
    pagination: {
        type: Object,
        required: true
    }
})

const emit = defineEmits(['page-change'])

const paginationPages = computed(() => {
    const current = props.pagination.current_page
    const last = props.pagination.last_page
    const delta = 2
    const pages = []

    if (last <= 7) {
        for (let i = 1; i <= last; i++) {
            pages.push(i)
        }
        return pages
    }

    pages.push(1)

    let start = Math.max(2, current - delta)
    let end = Math.min(last - 1, current + delta)

    if (start > 2) {
        pages.push('...')
    }

    for (let i = start; i <= end; i++) {
        pages.push(i)
    }

    if (end < last - 1) {
        pages.push('...')
    }

    if (last > 1) {
        pages.push(last)
    }

    return pages
})

const changePage = (page) => {
    if (page < 1 || page > props.pagination.last_page || page === props.pagination.current_page) {
        return
    }
    emit('page-change', page)
}
</script>