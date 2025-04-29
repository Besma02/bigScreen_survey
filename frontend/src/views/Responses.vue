<template>
    <div class="p-6 bg-white rounded-lg shadow-md">
      <h2 class="text-2xl text-center font-bold mb-6">Survey Responses</h2>
  
      <!-- Display paginated responses -->
      <div v-for="(response, index) in paginatedResponses" :key="index" class="mb-8">
        <h3 class="text-xl font-semibold mb-4">Responses for: {{ response.email }}</h3>
  
        <table class="min-w-full table-auto border-collapse">
          <thead>
            <tr class="bg-gray-100">
              <th class="px-4 py-2 text-left">Question Number</th>
              <th class="px-4 py-2 text-left">Question</th>
              <th class="px-4 py-2 text-left">Answer</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(answer, i) in response.answers" :key="i" class="border-t">
              <td class="px-4 py-2">{{ answer.question_number }}</td>
              <td class="px-4 py-2">{{ answer.question_title }}</td>
              <td class="px-4 py-2">{{ answer.value }}</td>
            </tr>
          </tbody>
        </table>
      </div>
  
      <!-- Pagination controls -->
      <div class="flex justify-between items-center mt-6">
        <button
          class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 disabled:opacity-50"
          @click="prevPage"
          :disabled="currentPage === 1"
        >
          Previous
        </button>
        <span class="text-gray-700">Page {{ currentPage }} of {{ totalPages }}</span>
        <button
          class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 disabled:opacity-50"
          @click="nextPage"
          :disabled="currentPage === totalPages"
        >
          Next
        </button>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, computed, onMounted } from 'vue'
  import axios from 'axios'
  
  const allResponses = ref([])
  const currentPage = ref(1)
  const perPage = ref(5) // Nombre de groupes de réponses (utilisateurs) par page
  
  const fetchResponses = async () => {
    try {
      const response = await axios.get('http://localhost:8000/api/admin/responses', {
        headers: {
          Authorization: `Bearer ${localStorage.getItem('token')}`,
        }
      })
      allResponses.value = response.data
    } catch (error) {
      console.error('Error fetching responses:', error)
    }
  }
  
  onMounted(fetchResponses)
  
  // Pagination locale
  const totalPages = computed(() => Math.ceil(allResponses.value.length / perPage.value))
  
  const paginatedResponses = computed(() => {
    const start = (currentPage.value - 1) * perPage.value
    return allResponses.value.slice(start, start + perPage.value)
  })
  
  const nextPage = () => {
    if (currentPage.value < totalPages.value) currentPage.value++
  }
  
  const prevPage = () => {
    if (currentPage.value > 1) currentPage.value--
  }
  </script>
  
  <style scoped>
  /* Add any custom styles here */
  </style>
  