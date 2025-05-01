<template>
  <div>
    <h2 class="text-2xl text-center font-bold mb-6">Survey Statistics</h2>

    <!-- Spinner de chargement -->
    <div v-if="isLoading" class="flex justify-center items-center h-40">
      <svg class="animate-spin h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
        <path class="opacity-75" fill="currentColor"
              d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z" />
      </svg>
    </div>

    <!-- Contenu uniquement après chargement -->
    <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <!-- Affichage des 2 premiers pieCharts -->
      <div
        v-for="(chart, index) in pieCharts.slice(0, 2)"
        :key="index"
        class="bg-white p-4 rounded shadow w-full"
      >
        <h3 class="font-semibold mb-2">{{ chart.question }}</h3>
        <PieChart :labels="chart.labels" :data="chart.data" />
      </div>

      <!-- Troisième PieChart -->
      <div
        v-if="pieCharts.length > 2"
        class="bg-white p-4 rounded shadow w-full"
      >
        <h3 class="font-semibold mb-2">{{ pieCharts[2].question }}</h3>
        <PieChart :labels="pieCharts[2].labels" :data="pieCharts[2].data" />
      </div>

      <!-- RadarChart à côté du 3e PieChart -->
      <div class="bg-white p-4 rounded shadow w-full">
        <h3 class="font-semibold mb-2">Quality (Questions 11 à 15)</h3>
        <RadarChart
          v-if="radarLabels.length && radarData.length"
          :labels="radarLabels"
          :data="radarData"
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import PieChart from '../components/PieChart.vue'
import RadarChart from '../components/RadarChart.vue'
import api from '../services/api'

const pieCharts = ref([])
const radarLabels = ref([])
const radarData = ref([])
const isLoading = ref(true)

onMounted(async () => {
  try {
    const response = await api.get('/admin/dashboard', {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`,
      },
    })

    // Traitement des pie charts
    pieCharts.value = response.data.pieCharts.map(chart => ({
      question: chart.question,
      labels: chart.data.map(item => item.value),
      data: chart.data.map(item => item.count),
    }))

    // Traitement du radar chart
    radarLabels.value = response.data.radarChart.map(item => item.question)
    radarData.value = response.data.radarChart.map(item => item.average)
  } catch (error) {
    console.error('Error retrieving dashboard data:', error)
  } finally {
    isLoading.value = false
  }
})
</script>
