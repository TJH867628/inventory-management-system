<template>
    <div id="app">
      <page-loading-spinner v-show="isLoading" />
      <router-view />
    </div>
  </template>
  
  <script>
  import pageLoadingSpinner from './components/page-loading-spinner.vue';
  
  export default {
    name: "App",
    components: {
      pageLoadingSpinner
    },
    data() {
      return {
        isLoading: false
      };
    },
    created() {
      // Watch for route changes and trigger loading animation
      this.$router.beforeEach((to, from, next) => {
        this.isLoading = true;
        next();
      });
  
      this.$router.afterEach(() => {
        setTimeout(() => {
          this.isLoading = false;
        }, 500); // Delay for 1 second to allow fade-out
      });
    }
  };
  </script>