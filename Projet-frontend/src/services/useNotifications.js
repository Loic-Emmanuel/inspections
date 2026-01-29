import { ref } from 'vue';

// Instance globale du système de notifications
const notificationInstance = ref(null);

export function useNotifications() {
  // Enregistrer l'instance du composant
  const registerNotificationSystem = (instance) => {
    notificationInstance.value = instance;
  };

  // Fonction helper pour afficher des notifications
  const notify = {
    success: (message, options = {}) => {
      if (notificationInstance.value) {
        return notificationInstance.value.notify.success(message, options);
      }
      console.warn('Notification system not initialized');
    },
    error: (message, options = {}) => {
      if (notificationInstance.value) {
        return notificationInstance.value.notify.error(message, options);
      }
      console.warn('Notification system not initialized');
    },
    warning: (message, options = {}) => {
      if (notificationInstance.value) {
        return notificationInstance.value.notify.warning(message, options);
      }
      console.warn('Notification system not initialized');
    },
    info: (message, options = {}) => {
      if (notificationInstance.value) {
        return notificationInstance.value.notify.info(message, options);
      }
      console.warn('Notification system not initialized');
    },
    custom: (options) => {
      if (notificationInstance.value) {
        return notificationInstance.value.notify.custom(options);
      }
      console.warn('Notification system not initialized');
    }
  };

  return {
    notify,
    registerNotificationSystem
  };
}