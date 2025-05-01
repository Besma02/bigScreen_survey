<template>
  
  <div class="result-page">
    <h1 class="title">My Survey Answers</h1>

    <div v-if="loading" class="loading">Loading...</div>
    <div v-else-if="error" class="error">{{ error }}</div>
    <div v-else>
      <div v-if="results && results.length">
        <div v-for="(result, index) in results" :key="index" class="result-item">
          <h3>{{ result.question_title }}</h3>
          <p><strong>Response :</strong> {{ result.value }}</p>
        </div>
      </div>
      <div v-else>
        <p>No answers found.</p>
      </div>
    </div>
      <!-- Back Home avec Iconify -->
      <router-link
      to="/"
      class="inline-flex items-center text-black hover:text-blue-800 font-medium mb-4 transition duration-200"
    >
      <Icon icon="mdi:arrow-left" class="w-5 h-5 mr-2" />
      Back Home
    </router-link>
  </div>
</template>

<script>

import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';
import api from '../services/api'
export default {
  name: 'ResultPage',
  setup() {
    const route = useRoute();
    const token = route.params.token;
    const results = ref([]);
    const loading = ref(true);
    const error = ref(null);

    onMounted(async () => {
      try {
        const response = await api.get(`/survey/result/${token}`);
        console.log('Response data:', response.data);
        results.value = response.data.answers;
      } catch (err) {
        error.value = 'Erreur lors du chargement des résultats.';
      } finally {
        loading.value = false;
      }
    });

    return {
      results,
      loading,
      error,
    };
  },
};
</script>

<style scoped>
.result-page {
  max-width: 600px;
  margin: 0 auto;
  padding: 2rem;
}
.title {
  font-size: 2rem;
  margin-bottom: 1.5rem;
}
.loading, .error {
  font-size: 1.2rem;
  color: #888;
}
.result-item {
  margin-bottom: 1.5rem;
  padding: 1rem;
  background: #f5f5f5;
  border-radius: 8px;
}
</style>
