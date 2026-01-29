<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 p-8">
    <div class="max-w-4xl mx-auto">
      <div class="bg-white/10 backdrop-blur-lg rounded-2xl shadow-2xl p-8 border border-white/20">
        <h1 class="text-4xl font-bold text-white mb-2">
          Système de Notifications Vue.js
        </h1>
        <p class="text-slate-300 mb-8">
          Testez les différents types de notifications avec Tailwind CSS
        </p>

        <!-- Grille de boutons -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <!-- Success -->
          <button
            @click="showSuccess"
            class="group relative overflow-hidden bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold py-4 px-6 rounded-xl shadow-lg transform transition-all duration-200 hover:scale-105 active:scale-95"
          >
            <span class="relative z-10 flex items-center justify-center gap-2">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              Notification Success
            </span>
            <div class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700" />
          </button>

          <!-- Error -->
          <button
            @click="showError"
            class="group relative overflow-hidden bg-gradient-to-r from-red-500 to-rose-600 hover:from-red-600 hover:to-rose-700 text-white font-semibold py-4 px-6 rounded-xl shadow-lg transform transition-all duration-200 hover:scale-105 active:scale-95"
          >
            <span class="relative z-10 flex items-center justify-center gap-2">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              Notification Error
            </span>
            <div class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700" />
          </button>

          <!-- Warning -->
          <button
            @click="showWarning"
            class="group relative overflow-hidden bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-semibold py-4 px-6 rounded-xl shadow-lg transform transition-all duration-200 hover:scale-105 active:scale-95"
          >
            <span class="relative z-10 flex items-center justify-center gap-2">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
              </svg>
              Notification Warning
            </span>
            <div class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700" />
          </button>

          <!-- Info -->
          <button
            @click="showInfo"
            class="group relative overflow-hidden bg-gradient-to-r from-blue-500 to-cyan-600 hover:from-blue-600 hover:to-cyan-700 text-white font-semibold py-4 px-6 rounded-xl shadow-lg transform transition-all duration-200 hover:scale-105 active:scale-95"
          >
            <span class="relative z-10 flex items-center justify-center gap-2">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              Notification Info
            </span>
            <div class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700" />
          </button>
        </div>

        <!-- Options avancées -->
        <div class="mt-8 space-y-4">
          <h2 class="text-2xl font-semibold text-white mb-4">Options avancées</h2>
          
          <button
            @click="showWithTitle"
            class="w-full bg-gradient-to-r from-purple-500 to-indigo-600 hover:from-purple-600 hover:to-indigo-700 text-white font-semibold py-4 px-6 rounded-xl shadow-lg transform transition-all duration-200 hover:scale-[1.02] active:scale-95"
          >
            Notification avec titre
          </button>

          <button
            @click="showPersistent"
            class="w-full bg-gradient-to-r from-slate-600 to-slate-700 hover:from-slate-700 hover:to-slate-800 text-white font-semibold py-4 px-6 rounded-xl shadow-lg transform transition-all duration-200 hover:scale-[1.02] active:scale-95"
          >
            Notification persistante (ne se ferme pas automatiquement)
          </button>

          <button
            @click="showLongDuration"
            class="w-full bg-gradient-to-r from-pink-500 to-fuchsia-600 hover:from-pink-600 hover:to-fuchsia-700 text-white font-semibold py-4 px-6 rounded-xl shadow-lg transform transition-all duration-200 hover:scale-[1.02] active:scale-95"
          >
            Notification longue durée (10 secondes)
          </button>

          <button
            @click="showMultiple"
            class="w-full bg-gradient-to-r from-teal-500 to-green-600 hover:from-teal-600 hover:to-green-700 text-white font-semibold py-4 px-6 rounded-xl shadow-lg transform transition-all duration-200 hover:scale-[1.02] active:scale-95"
          >
            Afficher plusieurs notifications
          </button>
        </div>

        <!-- Instructions -->
        <div class="mt-8 p-6 bg-slate-800/50 rounded-xl border border-slate-700">
          <h3 class="text-lg font-semibold text-white mb-2 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Astuce
          </h3>
          <p class="text-slate-300 text-sm">
            Survolez une notification avec votre souris pour mettre en pause le timer de fermeture automatique.
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useNotifications } from '@/services/useNotifications';

const { notify } = useNotifications();

const showSuccess = () => {
  notify.success('Opération réussie avec succès !');
};

const showError = () => {
  notify.error('Une erreur est survenue lors de l\'opération.');
};

const showWarning = () => {
  notify.warning('Attention, vérifiez vos données avant de continuer.');
};

const showInfo = () => {
  notify.info('Nouvelle mise à jour disponible.');
};

const showWithTitle = () => {
  notify.success('Fichier téléchargé', {
    title: 'Téléchargement terminé',
  });
};

const showPersistent = () => {
  notify.info('Cette notification restera affichée jusqu\'à ce que vous la fermiez.', {
    title: 'Notification importante',
    autoClose: false
  });
};

const showLongDuration = () => {
  notify.warning('Cette notification restera affichée pendant 10 secondes.', {
    duration: 10000
  });
};

const showMultiple = () => {
  setTimeout(() => notify.info('Première notification'), 0);
  setTimeout(() => notify.success('Deuxième notification'), 300);
  setTimeout(() => notify.warning('Troisième notification'), 600);
  setTimeout(() => notify.error('Quatrième notification'), 900);
};
</script>