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

<style>
/* Correction du zoom sur iPhone */
input[type="text"],
input[type="email"],
input[type="tel"],
input[type="password"],
select,
textarea {
    font-size: 16px !important; /* Minimum 16px pour éviter le zoom automatique sur iOS */
}

/* Sur desktop, garder la taille responsive */
@media (min-width: 640px) {
    input[type="text"],
    input[type="email"],
    input[type="tel"],
    input[type="password"],
    select,
    textarea {
        font-size: 1rem !important;
    }
}
</style>