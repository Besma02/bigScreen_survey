<template>
  <div class="result-page">
    <h1 class="title">Résultats du Sondage</h1>

    <div v-if="loading" class="loading">Chargement...</div>
    <div v-else-if="error" class="error">{{ error }}</div>
    <div v-else>
      <div v-if="results && results.length">
        <div v-for="(result, index) in results" :key="index" class="result-item">
          <h3>{{ result.question_title }}</h3>
          <p><strong>Réponse :</strong> {{ result.value }}</p>
        </div>
      </div>
      <div v-else>
        <p>Aucune réponse trouvée.</p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';

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
        const response = await axios.get(`http://localhost:8000/api/survey/result/${token}`);
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
