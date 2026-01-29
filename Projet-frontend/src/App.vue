<script setup>
import { ref, onMounted } from 'vue';
import { RouterLink, RouterView } from 'vue-router'
import { useInactivityLogout } from '@/services/useInactivityLogout'
import { useNotifications } from '@/services/useNotifications';
import NotificationSystem from '@/components/NotificationSystem.vue';

const notificationSystem = ref(null);
const { registerNotificationSystem } = useNotifications();

onMounted(() => {
  // Enregistrer le système de notifications pour l'utiliser partout
  registerNotificationSystem(notificationSystem.value);
});

useInactivityLogout()
</script>

<template>
  <NotificationSystem ref="notificationSystem" />
  <RouterView />
</template>