<template>
  <div class="max-w-3xl mx-auto p-6">
    <h1 class="text-3xl font-semibold mb-4 text-center">My Survey Answers</h1>
    <p class="text-lg text-gray-700 mb-8 text-center">
      Below you will find the answers you provided to our survey:
    </p>

    <!-- Spinner de chargement -->
    <div v-if="loading" class="flex justify-center my-8">
      <svg
        class="animate-spin h-8 w-8 text-blue-600"
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
      >
        <circle
          class="opacity-25"
          cx="12"
          cy="12"
          r="10"
          stroke="currentColor"
          stroke-width="4"
        />
        <path
          class="opacity-75"
          fill="currentColor"
          d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
        />
      </svg>
    </div>

    <!-- Message d'erreur -->
    <div v-else-if="error" class="text-red-600 text-center text-lg mb-4">
      {{ error }}
    </div>

    <!-- Résultats -->
    <div v-else>
      <div v-if="results && results.length">
        <div
          v-for="(result, index) in results"
          :key="index"
          class="bg-gray-100 border border-gray-300 rounded-lg p-4 mb-4 shadow-sm"
        >
          <p class="text-sm text-gray-500 mb-1">
            <span class="font-medium">Question #{{ result.question_id }}</span>
          </p>
          <h3 class="text-lg font-semibold text-gray-800 mb-2">
            {{ result.question_title }}
          </h3>
          <p class="text-gray-700">
            <span class="font-semibold">Response:</span> {{ result.value }}
          </p>
        </div>
      </div>
      <div v-else class="text-center text-gray-500">
        <p>No answers found.</p>
      </div>
    </div>

    <!-- Lien retour accueil -->
    <router-link
      to="/"
      class="inline-flex items-center mt-6 text-blue-600 hover:text-blue-800 font-medium transition duration-200"
    >
      <Icon icon="mdi:arrow-left" class="w-5 h-5 mr-2" />
      Back Home
    </router-link>
  </div>
</template>

<script>
import { Icon } from '@iconify/vue';
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';
import api from '../services/api';

export default {
  name: 'ResultPage',
  components: {
    Icon,
  },
  setup() {
    const route = useRoute();
    const token = route.params.token;
    const results = ref([]);
    const loading = ref(true);
    const error = ref(null);

    onMounted(async () => {
      try {
        const response = await api.get(`/survey/result/${token}`);
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
