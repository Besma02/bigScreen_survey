<template>
  <div class="max-w-md mx-auto mt-12 p-4 bg-white shadow-lg rounded-lg">
    <h2 class="text-2xl mb-4">Login</h2>
    <form @submit.prevent="login">
      <div class="mb-4">
        <label for="email" class="block text-gray-700">Email</label>
        <input
          type="email"
          id="email"
          v-model="email"
          class="w-full p-2 border border-gray-300 rounded-md"
        />
      </div>
      <div class="mb-4">
        <label for="password" class="block text-gray-700">Password</label>
        <input
          type="password"
          id="password"
          v-model="password"
          class="w-full p-2 border border-gray-300 rounded-md"
        />
      </div>
      <button
        type="submit"
        class="w-full bg-black text-white p-2 rounded-md mt-6 hover:bg-gray-800"
      >
        Login
      </button>
    </form>
    <p class="mt-4 text-center">
      <span>Don't have an account?</span>
      <router-link to="/register" class="text-blue-500 hover:underline"
        >Register</router-link
      >
    </p>
  </div>
</template>
<script>
import { useToast } from 'vue-toastification'

export default {
  data() {
    return {
      email: '',
      password: '',
    }
  },
  methods: {
    async login() {
      const toast = useToast()

      const credentials = {
        email: this.email,
        password: this.password,
      }

      try {
        const response = await fetch('http://localhost:8000/api/login', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(credentials),
        })

        const data = await response.json()

        if (data.access_token) {
          this.$store.commit('setUser', data.user)
          this.$store.commit('setToken', data.access_token)
          localStorage.setItem('token', data.access_token)

          // ✅ Toast de succès
          toast.success('Login successful!')

          if (data.user.role === 'admin') {
            this.$router.push('/dashboard')
          } else {
            this.$router.push('/')
          }
        } else {
          if (data.message === 'Les informations ne sont pas correctes') {
            toast.error('Incorrect email or password.')
          } else {
            toast.error('Something went wrong, please try again.')
          }
        }
      } catch (error) {
        console.error('Login failed', error)
        toast.error('Server error. Please try again.')
      }
    },
  },
}
</script>


<style scoped></style>
