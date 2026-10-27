<template>
    <div v-if="show" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-0 sm:p-4"
        @click.self="$emit('close')">
        <div
            class="bg-white w-full h-full sm:h-auto sm:rounded-xl shadow-xl sm:max-w-2xl sm:w-full max-h-screen sm:max-h-[90vh] overflow-y-auto">
            <!-- Header du modal -->
            <div
                class="sticky top-0 bg-white px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200 flex items-center justify-between z-10">
                <h2 class="text-lg sm:text-xl font-bold text-gray-900">
                    {{ isEditing ? 'Modifier l\'utilisateur' : 'Nouvel utilisateur' }}
                </h2>
                <button @click="$emit('close')" class="text-gray-400 hover:text-gray-600 transition p-1">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- Formulaire -->
            <form @submit.prevent="$emit('submit', formData)" class="p-4 sm:p-6">
                <div class="space-y-4 sm:space-y-6">
                    <!-- Nom et Prénom -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">
                                Nom <span class="text-red-500">*</span>
                            </label>
                            <input v-model="formData.name" type="text" required
                                class="w-full px-3 sm:px-4 py-2 sm:py-2.5 text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                placeholder="Entrez le nom" />
                        </div>
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">
                                Prénom <span class="text-red-500">*</span>
                            </label>
                            <input v-model="formData.firstname" type="text" required
                                class="w-full px-3 sm:px-4 py-2 sm:py-2.5 text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                placeholder="Entrez le prénom" />
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input v-model="formData.email" type="email" required
                                class="w-full pl-9 sm:pl-10 pr-3 sm:pr-4 py-2 sm:py-2.5 text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                placeholder="exemple@email.com" />
                            <svg class="absolute left-2.5 sm:left-3 top-2 sm:top-2.5 w-4 h-4 sm:w-5 sm:h-5 text-gray-400"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                    </div>

                    <!-- Contact -->
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">
                            Contact
                        </label>
                        <div class="relative">
                            <input v-model="formData.contact" type="tel"
                                class="w-full pl-9 sm:pl-10 pr-3 sm:pr-4 py-2 sm:py-2.5 text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                placeholder="+225 XX XX XX XX XX" />
                            <svg class="absolute left-2.5 sm:left-3 top-2 sm:top-2.5 w-4 h-4 sm:w-5 sm:h-5 text-gray-400"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                            class="w-full px-3 sm:px-4 py-2 sm:py-2.5 text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <option value="">Sélectionner un rôle</option>
                            <option value="admin">Administrateur</option>
                            <option value="inspecteur">Inspecteur</option>
                        </select>
                    </div>

                    <!-- Mot de passe -->
                    <div v-if="!isEditing" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">
                                Mot de passe <span class="text-red-500">*</span>
                            </label>
                            <input v-model="formData.password" type="password" required
                                class="w-full px-3 sm:px-4 py-2 sm:py-2.5 text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                placeholder="Mot de passe" />
                        </div>

                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">
                                Confirmation <span class="text-red-500">*</span>
                            </label>
                            <input v-model="formData.password_confirmation" type="password" required
                                class="w-full px-3 sm:px-4 py-2 sm:py-2.5 text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                placeholder="Confirmer le mot de passe" />
                        </div>
                    </div>
                    <div v-else>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">
                            Nouveau mot de passe <span class="text-gray-500 text-xs">(optionnel)</span>
                        </label>
                        <input v-model="formData.password" type="password"
                            class="w-full px-3 sm:px-4 py-2 sm:py-2.5 text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            placeholder="Laissez vide pour ne pas modifier" />
                    </div>
                </div>

                <!-- Actions du formulaire -->
                <div
                    class="flex flex-col-reverse sm:flex-row items-stretch sm:items-center sm:justify-end gap-2 sm:gap-3 mt-6 sm:mt-8 pt-4 sm:pt-6 border-t border-gray-200">
                    <button type="button" @click="$emit('close')"
                        class="px-4 py-2.5 sm:py-2 text-sm sm:text-base border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition"
                        :disabled="saving">
                        Annuler
                    </button>
                    <button type="submit"
                        class="px-4 py-2.5 sm:py-2 text-sm sm:text-base bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition flex items-center justify-center space-x-2 disabled:opacity-50 disabled:cursor-not-allowed"
                        :disabled="saving">
                        <svg v-if="!saving" class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        <div v-else
                            class="w-4 h-4 sm:w-5 sm:h-5 border-2 border-white border-t-transparent rounded-full animate-spin">
                        </div>
                        <span>{{ saving ? 'Enregistrement...' : (isEditing ? 'Mettre à jour' : 'Créer') }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
defineProps({
    show: {
        type: Boolean,
        required: true
    },
    isEditing: {
        type: Boolean,
        default: false
    },
    formData: {
        type: Object,
        required: true
    },
    saving: {
        type: Boolean,
        default: false
    }
})

defineEmits(['close', 'submit'])
</script>