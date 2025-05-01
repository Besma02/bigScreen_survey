<template>
  <div class="p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl text-center font-bold mb-6">Survey Responses</h2>

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

    <!-- Affichage des réponses -->
    <div v-else>
      <!-- Responsive responses display -->
      <div v-for="(response, index) in paginatedResponses" :key="index" class="mb-8">
        <h3 class="text-xl font-semibold mb-4">Responses for: {{ response.email }}</h3>

        <!-- Table display for desktop -->
        <div class="hidden md:block">
          <table class="min-w-full table-auto border-collapse">
            <thead>
              <tr class="bg-gray-100">
                <th class="px-4 py-2 text-left">Question Number</th>
                <th class="px-4 py-2 text-left">Question</th>
                <th class="px-4 py-2 text-left">Answer</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="(answer, i) in response.answers"
                :key="i"
                class="border-t"
              >
                <td class="px-4 py-2">{{ answer.question_number }}</td>
                <td class="px-4 py-2">{{ answer.question_title }}</td>
                <td class="px-4 py-2">{{ answer.value }}</td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Cards display for mobile -->
        <div class="md:hidden space-y-4">
          <div
            v-for="(answer, i) in response.answers"
            :key="i"
            class="bg-gray-50 border rounded-lg p-4 shadow-sm"
          >
            <p>
              <span class="font-semibold">Question #:</span>
              {{ answer.question_number }}
            </p>
            <p>
              <span class="font-semibold">Question:</span>
              {{ answer.question_title }}
            </p>
            <p>
              <span class="font-semibold">Answer:</span>
              {{ answer.value }}
            </p>
          </div>
        </div>
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
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import api from '../services/api'

const allResponses = ref([])
const currentPage = ref(1)
const perPage = ref(5)
const loading = ref(true)

const fetchResponses = async () => {
  try {
    const response = await api.get('/admin/responses', {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`,
      }
    })
    allResponses.value = response.data
  } catch (error) {
    console.error('Error fetching responses:', error)
  } finally {
    loading.value = false
  }
}

onMounted(fetchResponses)

const totalPages = computed(() =>
  Math.ceil(allResponses.value.length / perPage.value)
)

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
