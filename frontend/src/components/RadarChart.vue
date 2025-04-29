<template>
    <canvas ref="canvasRef"></canvas>
  </template>
  
  <script setup>
  import { onMounted, ref, watch, nextTick } from 'vue'
  import { Chart } from 'chart.js/auto'
  
  const props = defineProps(['labels', 'data'])
  const canvasRef = ref()
  let chartInstance = null
  
  watch(
    () => [props.labels, props.data],
    async () => {
      await nextTick(); // attendre que le DOM soit mis à jour
  
      if (!canvasRef.value) return; // sécurise le canvas
  
      // Si une instance précédente existe, la détruire
      if (chartInstance) {
        chartInstance.destroy();
      }
  
      // Si les labels et les données sont présents
      if (props.labels.length && props.data.length) {
        chartInstance = new Chart(canvasRef.value.getContext('2d'), {
          type: 'radar',
          data: {
            labels: props.labels,
            datasets: [{
              label: 'Qualité',
              data: props.data,
              backgroundColor: 'rgba(59,130,246,0.3)',
              borderColor: '#3b82f6',
              borderWidth: 2
            }]
          },
          options: {
            responsive: true,
            scales: {
              r: {
                min: 0,
                max: 5,
                ticks: {
                  stepSize: 1
                }
              }
            }
          }
        });
      }
    },
    { immediate: true, deep: true }
  )
  </script>
  