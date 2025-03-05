<template>
  <transition name="fade" @after-leave="onAfterLeave">
    <div v-if="isLoading" class="loading-overlay">
      <div class="spinner"></div>
    </div>
  </transition>
</template>

<script>
export default {
  data() {
    return {
      isLoading: true
    };
  },
  methods: {
    stopLoading() {
      this.isLoading = false;
    },
    onAfterLeave() {
      // This will be called after the fade-out transition finishes
      this.$el.style.display = 'none'; // Optionally hide the element after transition
    }
  },
};
</script>

<style scoped>
body {
  background-color: white;
}

.loading-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(255, 255, 255, 1); /* semi-transparent white */
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 9999;
  opacity: 1;
}

.spinner {
  border: 4px solid #f3f3f3;
  border-top: 4px solid #3498db;
  border-radius: 50%;
  width: 40px;
  height: 40px;
  animation: spin 2s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Fade-in and fade-out transition */
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.5s ease;
}
.fade-enter, .fade-leave-to {
  opacity: 0;
}
</style>