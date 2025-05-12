<template>
  <div>
    <nav class="bg-black p-4 fixed top-0 left-0 right-0 z-50 shadow-md">
      <div class="max-w-screen-xl mx-auto flex justify-between items-center">
        <!--<div class="text-white font-bold text-lg">Bigscreen Survey</div>-->
        <img src="../assets/logo.png" alt="logo" class="w-[100px] h-[25px] ">
        <div class="space-x-4">
          <router-link to="/" class="text-white hover:underline">Survey</router-link>
          <router-link v-if="!isAuthenticated" to="/login" class="text-white hover:underline">Login</router-link>
          <!--<router-link v-if="!isAuthenticated" to="/register" class="text-white hover:underline">Register</router-link>-->
          <button v-if="isAuthenticated" @click="logout" class="text-white hover:underline">Logout</button>
        </div>
      </div>
    </nav>
  </div>
</template>

<script>
export default {
  computed: {
    isAuthenticated() {
      return this.$store.getters.isAuthenticated;
    }
  },
  methods: {
    logout() {
      this.$store.dispatch('logout');
      this.$router.push('/login')
    }
  }
}
</script>

<style scoped>
/* Votre style ici */
</style>
