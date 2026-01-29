# Système de Notifications Vue.js avec Tailwind CSS

Un système de notifications élégant et moderne pour Vue 3 avec Tailwind CSS, incluant des animations fluides, des timers de fermeture automatique, et plusieurs types de notifications.

## ✨ Fonctionnalités

- 🎨 **4 types de notifications** : Success, Error, Warning, Info
- ⏱️ **Fermeture automatique** avec barre de progression
- 🖱️ **Pause au survol** : survolez une notification pour mettre en pause le timer
- 🎭 **Animations fluides** : entrée et sortie avec transitions élégantes
- 🌓 **Support du mode sombre** : s'adapte automatiquement
- 📱 **Responsive** : fonctionne sur tous les écrans
- 🎯 **Position personnalisable** : actuellement en haut à gauche
- 🔧 **Entièrement personnalisable** : durée, titre, fermeture automatique, etc.

## 📦 Installation

### 1. Copiez les fichiers dans votre projet

```
src/
├── components/
│   └── NotificationSystem.vue
├── composables/
│   └── useNotifications.js
└── App.vue
```

### 2. Assurez-vous que Tailwind CSS est installé

Si Tailwind n'est pas encore installé :

```bash
npm install -D tailwindcss postcss autoprefixer
npx tailwindcss init -p
```

Configurez `tailwind.config.js` :

```js
/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{vue,js,ts,jsx,tsx}",
  ],
  darkMode: 'class', // ou 'media' selon vos préférences
  theme: {
    extend: {},
  },
  plugins: [],
}
```

### 3. Intégrez le système dans votre App.vue

```vue
<template>
  <div>
    <!-- Système de notifications -->
    <NotificationSystem ref="notificationSystem" />
    
    <!-- Votre contenu -->
    <router-view />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import NotificationSystem from './components/NotificationSystem.vue';
import { useNotifications } from './composables/useNotifications';

const notificationSystem = ref(null);
const { registerNotificationSystem } = useNotifications();

onMounted(() => {
  registerNotificationSystem(notificationSystem.value);
});
</script>
```

## 🚀 Utilisation

### Utilisation basique

Dans n'importe quel composant Vue :

```vue
<script setup>
import { useNotifications } from '@/composables/useNotifications';

const { notify } = useNotifications();

// Success
notify.success('Opération réussie !');

// Error
notify.error('Une erreur est survenue.');

// Warning
notify.warning('Attention, vérifiez vos données.');

// Info
notify.info('Nouvelle mise à jour disponible.');
</script>
```

### Avec un titre

```js
notify.success('Fichier téléchargé avec succès', {
  title: 'Téléchargement terminé'
});
```

### Notification persistante (ne se ferme pas automatiquement)

```js
notify.info('Cette notification restera affichée.', {
  title: 'Important',
  autoClose: false
});
```

### Durée personnalisée

```js
notify.warning('Cette notification durera 10 secondes.', {
  duration: 10000 // en millisecondes
});
```

### Notification personnalisée

```js
notify.custom({
  type: 'success',
  title: 'Titre personnalisé',
  message: 'Message personnalisé',
  duration: 7000,
  autoClose: true
});
```

## 🎨 Personnalisation

### Changer la position

Dans `NotificationSystem.vue`, modifiez la classe du conteneur :

```vue
<!-- Haut gauche (par défaut) -->
<div class="fixed top-6 left-6 z-50">

<!-- Haut droite -->
<div class="fixed top-6 right-6 z-50">

<!-- Bas gauche -->
<div class="fixed bottom-6 left-6 z-50">

<!-- Bas droite -->
<div class="fixed bottom-6 right-6 z-50">

<!-- Centré en haut -->
<div class="fixed top-6 left-1/2 transform -translate-x-1/2 z-50">
```

### Modifier les couleurs

Modifiez les objets de configuration dans `NotificationSystem.vue` :

```js
const notificationClasses = {
  success: 'bg-green-50/95 dark:bg-green-950/95 border-green-500',
  error: 'bg-red-50/95 dark:bg-red-950/95 border-red-500',
  warning: 'bg-amber-50/95 dark:bg-amber-950/95 border-amber-500',
  info: 'bg-blue-50/95 dark:bg-blue-950/95 border-blue-500'
};
```

### Modifier la durée par défaut

Dans `NotificationSystem.vue`, ligne ~150 :

```js
const notification = {
  // ...
  duration: options.duration || 5000, // Changez 5000 par la valeur souhaitée
  // ...
};
```

### Changer les animations

Modifiez les keyframes dans la section `<style>` :

```css
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
```

## 📋 API Complète

### Options disponibles

```typescript
interface NotificationOptions {
  type?: 'success' | 'error' | 'warning' | 'info';  // Type de notification
  title?: string;                                     // Titre (optionnel)
  message: string;                                    // Message à afficher
  duration?: number;                                  // Durée en ms (défaut: 5000)
  autoClose?: boolean;                                // Fermeture auto (défaut: true)
}
```

### Méthodes disponibles

```js
const { notify } = useNotifications();

// Méthodes rapides
notify.success(message, options?)
notify.error(message, options?)
notify.warning(message, options?)
notify.info(message, options?)

// Méthode personnalisée
notify.custom(options)
```

## 💡 Exemples avancés

### Notification de chargement

```js
const notificationId = notify.info('Chargement en cours...', {
  autoClose: false
});

// Plus tard, après le chargement
removeNotification(notificationId);
notify.success('Chargement terminé !');
```

### Chaîne de notifications

```js
const showMultiple = () => {
  setTimeout(() => notify.info('Étape 1...'), 0);
  setTimeout(() => notify.info('Étape 2...'), 500);
  setTimeout(() => notify.success('Terminé !'), 1000);
};
```

### Intégration avec Axios

```js
import axios from 'axios';
import { useNotifications } from '@/composables/useNotifications';

const { notify } = useNotifications();

axios.interceptors.response.use(
  (response) => {
    if (response.data.message) {
      notify.success(response.data.message);
    }
    return response;
  },
  (error) => {
    notify.error(
      error.response?.data?.message || 'Une erreur est survenue'
    );
    return Promise.reject(error);
  }
);
```

## 🎯 Bonnes pratiques

1. **Ne pas abuser des notifications** : utilisez-les pour des actions importantes
2. **Messages clairs et concis** : gardez vos messages courts et compréhensibles
3. **Type approprié** : utilisez le bon type selon le contexte
4. **Durée adaptée** : ajustez la durée selon l'importance du message
5. **Fermeture manuelle** : pour les messages critiques, désactivez la fermeture automatique

## 🐛 Dépannage

### Les notifications ne s'affichent pas

Vérifiez que :
1. Le composant `NotificationSystem` est bien monté dans `App.vue`
2. `registerNotificationSystem()` est appelé dans `onMounted`
3. Tailwind CSS est correctement configuré
4. Le z-index n'est pas masqué par un autre élément

### Les animations ne fonctionnent pas

Assurez-vous que :
1. Les classes Tailwind pour les transitions sont disponibles
2. Aucun CSS global ne surcharge les animations

### Mode sombre ne fonctionne pas

Configurez Tailwind pour le mode sombre :
```js
// tailwind.config.js
export default {
  darkMode: 'class', // ou 'media'
  // ...
}
```

## 📝 License

Ce composant est libre d'utilisation et de modification selon vos besoins.

## 🤝 Contribution

N'hésitez pas à personnaliser ce système selon vos besoins !

---

Créé avec ❤️ pour Vue.js et Tailwind CSS