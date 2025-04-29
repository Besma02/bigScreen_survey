<template>
  <canvas ref="canvasRef"></canvas>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { Chart } from 'chart.js/auto'

const props = defineProps(['labels', 'data'])
const canvasRef = ref()

onMounted(() => {
  new Chart(canvasRef.value, {
    type: 'pie',
    data: {
      labels: props.labels,
      datasets: [{ data: props.data, backgroundColor: ['#3b82f6', '#10b981', '#f59e0b'] }],
    },
  })
})
</script>
