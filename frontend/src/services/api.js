// src/services/api.js
import axios from 'axios'

const api = axios.create({
  baseURL: 'http://localhost:8000/api', // adapte si différent
  withCredentials: true,
  headers: {
    Accept: 'application/json',
  },
})

export default api
