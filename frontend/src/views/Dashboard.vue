<template>
  <div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <aside
      :class="[
        'fixed z-40 inset-y-0 left-0 w-64 bg-black text-white shadow-md p-4 transform transition-transform duration-300 ease-in-out',
        isSidebarOpen ? 'translate-x-0' : '-translate-x-full',
        'md:relative md:translate-x-0'
      ]"
    >
      <!-- Close button (mobile only) -->
      <div class="flex justify-end md:hidden mb-4">
        <button @click="closeSidebar" class="text-white text-2xl">
          &times;
        </button>
      </div>

      <div>
        <img src="../assets/logo.png" alt="logo" class="mb-12 mt-4" />
        <nav class="space-y-2">
          <RouterLink
            to="/dashboard"
            class="block px-3 py-2 rounded text-white hover:bg-blue-100 hover:text-blue-600 transition"
            @click="closeSidebar"
          >
            Home
          </RouterLink>
          <RouterLink
            to="/dashboard/questions"
            class="block px-3 py-2 rounded text-white hover:bg-blue-100 hover:text-blue-600 transition"
            @click="closeSidebar"
          >
            Questionnaire
          </RouterLink>
          <RouterLink
            to="/dashboard/responses"
            class="block px-3 py-2 rounded text-white hover:bg-blue-100 hover:text-blue-600 transition"
            @click="closeSidebar"
          >
            Answers
          </RouterLink>
        </nav>

        <!-- Logout -->
        <button
          @click="logout"
          class="mt-12 block px-3 py-2 text-center rounded font-bold bg-white w-full text-gray-600 hover:bg-gray-400 hover:text-white transition"
        >
          Logout
        </button>
      </div>
    </aside>

    <!-- Main content -->
    <div class="flex-1 flex flex-col overflow-y-auto bg-gray-100">
      <!-- Top bar with hamburger -->
      <header class="md:hidden p-4 flex justify-between items-center bg-white shadow">
        <button @click="toggleSidebar" class="text-gray-700 focus:outline-none">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
            <path d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
        <span class="font-bold text-lg">Bigscreen</span>
      </header>

      <main class="p-6 flex-1">
        <RouterView />
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const isSidebarOpen = ref(false)
const router = useRouter()

const toggleSidebar = () => {
  isSidebarOpen.value = !isSidebarOpen.value
}
const closeSidebar = () => {
  isSidebarOpen.value = false
}
const logout = () => {
  localStorage.removeItem('token')
  router.push('/login')
}
</script>
