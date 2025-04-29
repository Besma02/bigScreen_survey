<template>
    <div>
    <h2 class="text-2xl text-center font-bold mb-6">Survey Statistics</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div
        v-for="(chart, index) in pieCharts"
        :key="index"
        class="bg-white p-4 rounded shadow"
      >
        <h3 class="font-semibold mb-2">{{ chart.question }}</h3>
        <PieChart :labels="chart.labels" :data="chart.data" />
      </div>

      <div class="bg-white p-4 rounded shadow col-span-1 md:col-span-2">
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
import axios from 'axios'
import PieChart from '../components/PieChart.vue'
import RadarChart from '../components/RadarChart.vue'

const pieCharts = ref([])
const radarLabels = ref([])
const radarData = ref([])

onMounted(async () => {
  console.log(localStorage.getItem('token'))
  try {
    const response = await axios.get('http://localhost:8000/api/admin/dashboard', {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`, // ou ton système de stockage
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
    console.log(response.data.radarChart)
  } catch (error) {
    console.error('Erreur lors de la récupération des données du dashboard :', error)
  }
})
</script>

<style>

</style>