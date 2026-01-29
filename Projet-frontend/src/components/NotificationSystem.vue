<template>
  <teleport to="body">
    <div class="fixed top-6 right-6 z-50 flex flex-col gap-3 max-w-md">
      <transition-group
        name="notification"
        tag="div"
        class="flex flex-col gap-3">
        <div
          v-for="notification in notifications"
          :key="notification.id"
          :class="[
            'notification-card',
            'relative overflow-hidden rounded-xl shadow-2xl backdrop-blur-sm',
            'border-l-4 p-4',
            'transform transition-all duration-300 ease-out',
            notificationClasses[notification.type]
          ]"
          @mouseenter="pauseTimer(notification.id)"
          @mouseleave="resumeTimer(notification.id)">
          <!-- Animated background gradient -->
          <div 
            :class="[
              'absolute inset-0 opacity-10',
              notificationGradients[notification.type]
            ]"
          />
          
          <!-- Progress bar -->
          <div
            v-if="notification.autoClose"
            class="absolute bottom-0 left-0 h-1 transition-all duration-100 ease-linear"
            :class="notificationProgressBars[notification.type]"
            :style="{ width: `${notification.progress}%` }"/>

          <div class="relative flex items-start gap-3 pr-8">
            <!-- Icon -->
            <div
              :class="[
                'flex-shrink-0 w-6 h-6 flex items-center justify-center rounded-full',
                notificationIconBg[notification.type]
              ]"
            >
              <component
                :is="notificationIcons[notification.type]"
                :class="['w-4 h-4', notificationIconColors[notification.type]]"
              />
            </div>

            <!-- Content -->
            <div class="flex-1 min-w-0">
              <h4
                v-if="notification.title"
                class="font-semibold text-sm mb-1 text-gray-900 dark:text-white"
              >
                {{ notification.title }}
              </h4>
              <p class="text-sm text-gray-700 dark:text-gray-300">
                {{ notification.message }}
              </p>
            </div>
          </div>

          <!-- Close button -->
          <button
            @click="removeNotification(notification.id)"
            class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors z-10"
            aria-label="Fermer"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
      </transition-group>
    </div>
  </teleport>
</template>

<script setup>
import { ref, computed, h } from 'vue';

// État des notifications
const notifications = ref([]);
let notificationId = 0;
const timers = ref({});

// Icônes SVG comme composants
const SuccessIcon = {
  render: () => h('svg', {
    fill: 'none',
    stroke: 'currentColor',
    viewBox: '0 0 24 24',
    class: 'w-full h-full'
  }, [
    h('path', {
      'stroke-linecap': 'round',
      'stroke-linejoin': 'round',
      'stroke-width': '2.5',
      d: 'M5 13l4 4L19 7'
    })
  ])
};

const ErrorIcon = {
  render: () => h('svg', {
    fill: 'none',
    stroke: 'currentColor',
    viewBox: '0 0 24 24',
    class: 'w-full h-full'
  }, [
    h('path', {
      'stroke-linecap': 'round',
      'stroke-linejoin': 'round',
      'stroke-width': '2.5',
      d: 'M6 18L18 6M6 6l12 12'
    })
  ])
};

const WarningIcon = {
  render: () => h('svg', {
    fill: 'none',
    stroke: 'currentColor',
    viewBox: '0 0 24 24',
    class: 'w-full h-full'
  }, [
    h('path', {
      'stroke-linecap': 'round',
      'stroke-linejoin': 'round',
      'stroke-width': '2.5',
      d: 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'
    })
  ])
};

const InfoIcon = {
  render: () => h('svg', {
    fill: 'none',
    stroke: 'currentColor',
    viewBox: '0 0 24 24',
    class: 'w-full h-full'
  }, [
    h('path', {
      'stroke-linecap': 'round',
      'stroke-linejoin': 'round',
      'stroke-width': '2.5',
      d: 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
    })
  ])
};

// Configuration des styles par type
const notificationIcons = {
  success: SuccessIcon,
  error: ErrorIcon,
  warning: WarningIcon,
  info: InfoIcon
};

const notificationClasses = {
  success: 'bg-green-50/95 dark:bg-green-950/95 border-green-500',
  error: 'bg-red-50/95 dark:bg-red-950/95 border-red-500',
  warning: 'bg-amber-50/95 dark:bg-amber-950/95 border-amber-500',
  info: 'bg-blue-50/95 dark:bg-blue-950/95 border-blue-500'
};

const notificationIconBg = {
  success: 'bg-green-100 dark:bg-green-900',
  error: 'bg-red-100 dark:bg-red-900',
  warning: 'bg-amber-100 dark:bg-amber-900',
  info: 'bg-blue-100 dark:bg-blue-900'
};

const notificationIconColors = {
  success: 'text-green-600 dark:text-green-400',
  error: 'text-red-600 dark:text-red-400',
  warning: 'text-amber-600 dark:text-amber-400',
  info: 'text-blue-600 dark:text-blue-400'
};

const notificationProgressBars = {
  success: 'bg-green-500',
  error: 'bg-red-500',
  warning: 'bg-amber-500',
  info: 'bg-blue-500'
};

const notificationGradients = {
  success: 'bg-gradient-to-br from-green-400 to-green-600',
  error: 'bg-gradient-to-br from-red-400 to-red-600',
  warning: 'bg-gradient-to-br from-amber-400 to-amber-600',
  info: 'bg-gradient-to-br from-blue-400 to-blue-600'
};

// Fonction pour ajouter une notification
const addNotification = (options) => {
  const id = notificationId++;
  const notification = {
    id,
    type: options.type || 'info',
    title: options.title || '',
    message: options.message || '',
    autoClose: options.autoClose !== false,
    duration: options.duration || 5000,
    progress: 100
  };

  notifications.value.push(notification);

  if (notification.autoClose) {
    startTimer(notification);
  }

  return id;
};

// Gestion des timers
const startTimer = (notification) => {
  const startTime = Date.now();
  const duration = notification.duration;

  const updateProgress = () => {
    const elapsed = Date.now() - startTime;
    const remaining = Math.max(0, duration - elapsed);
    notification.progress = (remaining / duration) * 100;

    if (remaining > 0) {
      timers.value[notification.id] = requestAnimationFrame(updateProgress);
    } else {
      removeNotification(notification.id);
    }
  };

  timers.value[notification.id] = requestAnimationFrame(updateProgress);
};

const pauseTimer = (id) => {
  if (timers.value[id]) {
    cancelAnimationFrame(timers.value[id]);
  }
};

const resumeTimer = (id) => {
  const notification = notifications.value.find(n => n.id === id);
  if (notification && notification.autoClose) {
    startTimer(notification);
  }
};

// Fonction pour supprimer une notification
const removeNotification = (id) => {
  if (timers.value[id]) {
    cancelAnimationFrame(timers.value[id]);
    delete timers.value[id];
  }
  notifications.value = notifications.value.filter(n => n.id !== id);
};

// API publique
const notify = {
  success: (message, options = {}) => addNotification({ ...options, message, type: 'success' }),
  error: (message, options = {}) => addNotification({ ...options, message, type: 'error' }),
  warning: (message, options = {}) => addNotification({ ...options, message, type: 'warning' }),
  info: (message, options = {}) => addNotification({ ...options, message, type: 'info' }),
  custom: (options) => addNotification(options)
};

// Exposer les méthodes
defineExpose({
  notify,
  addNotification,
  removeNotification
});
</script>

<style scoped>
/* Animations d'entrée/sortie */
.notification-enter-active {
  animation: slideInRight 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.notification-leave-active {
  animation: slideOutRight 0.3s cubic-bezier(0.4, 0, 1, 1);
}

@keyframes slideInLeft {
  from {
    opacity: 0;
    transform: translateX(-100%) scale(0.8);
  }
  to {
    opacity: 1;
    transform: translateX(0) scale(1);
  }
}

@keyframes slideOutLeft {
  from {
    opacity: 1;
    transform: translateX(0) scale(1);
  }
  to {
    opacity: 0;
    transform: translateX(-100%) scale(0.8);
  }
}

@keyframes slideInRight {
  from {
    opacity: 0;
    transform: translateX(100%) scale(0.8);
  }
  to {
    opacity: 1;
    transform: translateX(0) scale(1);
  }
}

@keyframes slideOutRight {
  from {
    opacity: 1;
    transform: translateX(0) scale(1);
  }
  to {
    opacity: 0;
    transform: translateX(100%) scale(0.8);
  }
}

/* Effet de hover */
.notification-card {
  cursor: default;
}

.notification-card:hover {
  transform: translateX(4px);
}
</style>