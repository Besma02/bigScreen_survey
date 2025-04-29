<template>
  <div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <aside class="w-64 bg-black text-white shadow-md p-4 flex flex-col justify-between">
      <div>
        <!--<h1 class="text-2xl font-bold mb-12 ">Bigscreen</h1>-->
        <img src="../assets/logo.png" alt="logo" class="mb-12 mt-4">
        <nav class="space-y-2">
          <RouterLink
            to="/dashboard"
            class="block px-3 py-2 rounded text-white hover:bg-blue-100 hover:text-blue-600 transition"
          >
           Home
          </RouterLink>
          <RouterLink
            to="/dashboard/questions"
            class="block px-3 py-2 rounded text-white hover:bg-blue-100 hover:text-blue-600 transition"
          >
            Questionnaire
          </RouterLink>
          <RouterLink
            to="/dashboard/responses"
            class="block px-3 py-2 rounded text-white hover:bg-blue-100 hover:text-blue-600 transition"
          
          >
          Answers
          </RouterLink>
        </nav>
        <!-- Logout -->
      <button
        @click="logout"
        class="mt-12 block px-3 py-2 text-center rounded font-bold bg-white w-full  text-gray-600 hover:bg-gray-400 hover:text-white transition"
      >
        Logout
      </button>
      </div>

      
    </aside>

    <!-- Main -->
    <div class="flex-1 overflow-y-auto p-6 bg-gray-100">
      <RouterView />
    </div>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router'

const router = useRouter()

const logout = () => {
  localStorage.removeItem('token') // Nettoyage du token
  router.push('/login') // Redirection vers la page d'accueil ou login
}
</script>
