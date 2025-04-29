<template>
  <div>
    <Navbar />
    <div class="survey-container mt-4">
      <SurveyForm />
    </div>
  </div>
</template>

<script setup>
import Navbar from "../components/Navbar.vue";
import SurveyForm from "../components/SurveyForm.vue"; // Assure-toi que ce chemin est correct
</script>

<style scoped>
.survey-container {
  padding: 2rem;
}
</style>
