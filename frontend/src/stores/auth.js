import { defineStore } from 'pinia'
import api from '../axios'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    token: null,
    user: null,
  }),
  actions: {
    // login
    async login(body) {
      const res = await api.post('/login', body)
      this.token = res.data.token
      this.user = res.data.user

      localStorage.setItem('token', this.token)

      // Set default header for future requests
      api.defaults.headers.common['Authorization'] = `Bearer ${this.token}`

      // redirect to inventory
      window.location.href = '/inventory'
    },

    // register
    async register(body) {
      const res = await api.post('/register', body)

      // Set default header for future requests
      api.defaults.headers.common['Authorization'] = `Bearer ${this.token}`

      // redirect to login
      window.location.href = '/'
    },

    getToken() {
      return this.token ? `Bearer ${this.token}` : null
    },

    // logout
    async logout() {
      const res = await api.post('/logout')

      // Set default header for future requests
      api.defaults.headers.common['Authorization'] = `Bearer ${this.token}`

      this.token = null
      this.user = null
      localStorage.removeItem('token')
      window.location.href = '/'
    },

    async checkSession() {
      const response = await api.get('/check-session')
      console.log(response);
      api.defaults.headers.common['Authorization'] = `Bearer ${this.token}`
      if (response.data.loggedIn) {
        router.push('/inventory')
      }
    },
  },
})
