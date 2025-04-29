<template>
    <div class="p-6 bg-white  rounded-lg shadow-md">
      <h2 class="text-2xl text-center font-bold mb-6">List of Questions</h2>
  
      <!-- Questions Table -->
      <table class="min-w-full table-auto">
        <thead>
          <tr class="bg-gray-100">
            <th class="px-4 py-2 text-left">Question Number</th>
            <th class="px-4 py-2 text-left">Question</th>
            <th class="px-4 py-2 text-left">Type</th>
          </tr>
        </thead>
        <tbody>
          <!-- Display each question -->
          <tr v-for="question in questions" :key="question.id" class="border-t">
            <td class="px-4 py-2">{{ question.id }}</td>
            <td class="px-4 py-2">{{ question.title }}</td>
            <td class="px-4 py-2">{{ formatQuestionType(question.type) }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue'
  import axios from 'axios'
  
  // Store the questions retrieved from the API
  const questions = ref([])
  
  // Fetch the questions from the Laravel API
  onMounted(async () => {
    try {
      const response = await axios.get('http://localhost:8000/api/admin/questions', {
        headers: {
          Authorization: `Bearer ${localStorage.getItem('token')}`, // Authentication token
        }
      })
      questions.value = response.data
    } catch (error) {
      console.error('Error fetching questions:', error)
    }
  })
  
  // Function to format the question type (A, B, C)
  const formatQuestionType = (type) => {
    switch (type) {
      case 'A':
        return 'Type A (Evaluation)';
      case 'B':
        return 'Type B (Multiple Choice)';
      case 'C':
        return 'Type C (Open-ended)';
      default:
        return 'Unknown Type';
    }
  }
  </script>
  
  <style scoped>
  /* Customize styles if needed */
  </style>
  