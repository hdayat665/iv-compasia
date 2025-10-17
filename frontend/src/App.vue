<template>
  <div id="app">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark" :style="{ backgroundColor: '#A8E6CF' }">
      <div class="container">
        <a class="navbar-brand fw-bold text-dark" href="#">CompAsia</a>

        <div class="ms-auto" v-if="showLogout">
          <button class="btn btn-danger btn-sm" @click="logout">Logout</button>
        </div>
      </div>
    </nav>

    <!-- Page content -->
    <div class="container mt-5">
      <router-view />
    </div>
  </div>
</template>

<script setup>
import { onMounted, computed } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useAuthStore } from './stores/auth'


const router = useRouter()
const route = useRoute()
const showLogout = computed(() => route.path.includes('/inventory'))

const auth = useAuthStore()

const logout = async () => {
  try {
    await auth.logout()
    router.push('/') 
  } catch (err) {
    console.error('Logout failed', err)
  }
}

// onMounted(async () => {
//   const token = localStorage.getItem('token')
//   if (token) {
//     window.location.href = '/inventory'
//   }else{
//     window.location.href = '/'

//   }
// })
</script>

<style scoped></style>
