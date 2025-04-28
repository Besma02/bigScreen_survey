<template>
    <div class="register-page">
      <h2>Créer un compte</h2>
      <form @submit.prevent="registerUser">
        <input v-model="email" type="email" placeholder="Email" required />
        <input v-model="password" type="password" placeholder="Mot de passe" required />
        <button type="submit">S'inscrire</button>
      </form>
      <router-link to="/login">Déjà un compte ? Connectez-vous ici</router-link>
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
      async registerUser() {
        try {
          await this.$store.dispatch('login', {
            email: this.email,
            password: this.password
          });
          this.$router.push('/survey');  // Rediriger vers la page de sondage après inscription
        } catch (error) {
          alert('Échec de l\'inscription');
        }
      }
    }
  };
  </script>
  