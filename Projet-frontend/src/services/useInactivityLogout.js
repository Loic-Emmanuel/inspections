// src/composables/useInactivityLogout.js
import { ref, onMounted, onUnmounted, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import api from '@/services/api';

export function useInactivityLogout(timeout = 10 * 60 * 1000) {
    const route = useRoute();
    const router = useRouter();
    const timer = ref(null);
    const isActive = ref(false);

    // Pages publiques où le timer ne doit PAS fonctionner
    const publicRoutes = ['/login'];

    const shouldBeActive = () => {
        return !publicRoutes.includes(route.path);
    };

    const resetTimer = () => {
        if (!isActive.value) return;
        
        if (timer.value) clearTimeout(timer.value);
        timer.value = setTimeout(() => {
            logout();
        }, timeout);
    };

    const logout = async () => {
        try {
            await api.logout();
        } catch (error) {
            console.error('Erreur logout:', error);
        }
    };

    const setupListeners = () => {
        ['mousedown', 'keydown', 'touchstart', 'scroll'].forEach(event => {
            window.addEventListener(event, resetTimer, { passive: true });
        });
    };

    const removeListeners = () => {
        ['mousedown', 'keydown', 'touchstart', 'scroll'].forEach(event => {
            window.removeEventListener(event, resetTimer);
        });
    };

    const activate = () => {
        isActive.value = true;
        resetTimer();
    };

    const deactivate = () => {
        isActive.value = false;
        if (timer.value) {
            clearTimeout(timer.value);
            timer.value = null;
        }
    };

    // Watch le changement de route
    watch(() => route.path, () => {
        if (shouldBeActive()) {
            activate();
        } else {
            deactivate();
        }
    }, { immediate: true });

    onMounted(() => {
        setupListeners();
        if (shouldBeActive()) {
            activate();
        }
    });

    onUnmounted(() => {
        removeListeners();
        deactivate();
    });
}