<template>
    <div class="login-page">
      <h2>Se connecter</h2>
      <form @submit.prevent="loginUser">
        <input v-model="email" type="email" placeholder="Email" required />
        <input v-model="password" type="password" placeholder="Mot de passe" required />
        <button type="submit">Se connecter</button>
      </form>
      <router-link to="/register">Pas encore de compte ? Créez-en un ici</router-link>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        email: '',
        password: ''
      };
    },
    methods: {
      async loginUser() {
        try {
          await this.$store.dispatch('login', {
            email: this.email,
            password: this.password
          });
          this.$router.push('/survey');  // Rediriger vers la page de sondage après connexion
        } catch (error) {
          alert('Échec de la connexion');
        }
      }
    }
  };
  </script>
  