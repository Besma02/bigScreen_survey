<template>
    <div class="h-screen flex items-center justify-center bg-gray-100">
      <div class="text-center p-8 bg-white shadow-md rounded-lg">
        <h1 class="text-4xl font-bold text-red-600">Oups !</h1>
        <p class="text-xl text-gray-700 mt-4">La page que vous recherchez n'existe pas.</p>
        <router-link to="/" class="mt-6 text-blue-600 hover:underline">Retour à l'accueil</router-link>
      </div>
    </div>
  </template>
  
  <script setup>
  </script>
  
  <style scoped>
  </style>
  