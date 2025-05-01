<template>
  <div class="p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl text-center font-bold mb-6">List of Questions</h2>

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

    <!-- Affichage des questions -->
    <div v-else>
      <!-- Table pour desktop -->
      <div class="hidden md:block">
        <table class="min-w-full table-auto">
          <thead>
            <tr class="bg-gray-100">
              <th class="px-4 py-2 text-left">Question Number</th>
              <th class="px-4 py-2 text-left">Question</th>
              <th class="px-4 py-2 text-left">Type</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="question in questions"
              :key="question.id"
              class="border-t"
            >
              <td class="px-4 py-2">{{ question.id }}</td>
              <td class="px-4 py-2">{{ question.title }}</td>
              <td class="px-4 py-2">{{ formatQuestionType(question.type) }}</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Cartes pour mobile -->
      <div class="md:hidden space-y-4">
        <div
          v-for="question in questions"
          :key="question.id"
          class="bg-gray-50 border rounded-lg p-4 shadow-sm"
        >
          <p>
            <span class="font-semibold">Question Number:</span>
            {{ question.id }}
          </p>
          <p>
            <span class="font-semibold">Question:</span> {{ question.title }}
          </p>
          <p>
            <span class="font-semibold">Type:</span>
            {{ formatQuestionType(question.type) }}
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '../services/api'

const questions = ref([])
const loading = ref(true)

onMounted(async () => {
  try {
    const response = await api.get('/admin/questions', {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`,
      },
    })
    questions.value = response.data
  } catch (error) {
    console.error('Error fetching questions:', error)
  } finally {
    loading.value = false
  }
})

const formatQuestionType = (type) => {
  switch (type) {
    case 'A':
      return 'Type A (Evaluation)'
    case 'B':
      return 'Type B (Multiple Choice)'
    case 'C':
      return 'Type C (Open-ended)'
    default:
      return 'Unknown Type'
  }
}
</script>
