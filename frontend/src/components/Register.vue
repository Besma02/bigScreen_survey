<template>
    <div class="max-w-md mx-auto mt-12 p-4 bg-white shadow-lg rounded-lg my-12">
      <h2 class="text-2xl mb-4">Register</h2>
      <form @submit.prevent="register">
        <div class="mb-4">
          <label for="name" class="block text-gray-700">Name</label>
          <input type="text" id="name" v-model="name" class="w-full p-2 border border-gray-300 rounded-md" />
        </div>
        <div class="mb-4">
          <label for="email" class="block text-gray-700">Email</label>
          <input type="email" id="email" v-model="email" class="w-full p-2 border border-gray-300 rounded-md" />
        </div>
        <div class="mb-4">
          <label for="password" class="block text-gray-700">Password</label>
          <input type="password" id="password" v-model="password" class="w-full p-2 border border-gray-300 rounded-md" />
        </div>
        <div class="mb-4">
          <label for="password_confirmation" class="block text-gray-700">Confirm Password</label>
          <input type="password" id="password_confirmation" v-model="password_confirmation" class="w-full p-2 border border-gray-300 rounded-md" />
        </div>
        <button type="submit" class="w-full bg-black text-white p-2 rounded-md mt-6 hover:bg-gray-800">Register</button>
      </form>
      
      <p class="mt-4 text-center">
        <span>Already have an account?</span>
        <router-link to="/login" class="text-blue-500 hover:underline">Login</router-link>
      </p>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
      };
    },
    methods: {
      async register() {
        const userData = {
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation
        };
        const response = await fetch('http://localhost:8000/api/register', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(userData),
        });
  
        const data = await response.json();
  
        if (data.access_token) {
          // Store the user token and data
          this.$store.dispatch('setToken', data.access_token);
          this.$store.dispatch('setUser', data.user);
          this.$router.push('/');  // Redirect to the main page
        } else {
          alert('Registration failed');
        }
      }
    }
  };
  </script>
  
  <style scoped>
  /* Votre style ici */
  </style>
  